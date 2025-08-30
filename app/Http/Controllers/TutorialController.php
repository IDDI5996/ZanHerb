<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutorial;
use App\Models\TutorialProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TutorialController extends Controller
{
    public function index(Request $request)
    {
        $tutorials = Tutorial::latest()
        ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
        ->when($request->category, fn($q) => $q->where('category', $request->category))
        ->get();

    // Average completion across all viewer progress rows
    $globalCompletion = (int) round(TutorialProgress::avg('progress_percent'));

    // Hours of content:
    // sum of the longest known duration per tutorial (reported by clients)
    $secondsSum = \DB::table('tutorial_progress')
        ->selectRaw('MAX(duration_seconds) as dur')
        ->whereNotNull('duration_seconds')
        ->groupBy('tutorial_id')
        ->pluck('dur')
        ->sum();

    $hoursContent = round($secondsSum / 3600, 1);

    return view('admin.tutorials.index', compact('tutorials', 'globalCompletion', 'hoursContent'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video' => 'required|mimes:mp4,mov,avi|max:2048000', // ~2GB
        ]);

        $path = $request->file('video')->store('tutorials', 'public');

        Tutorial::create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'video_path' => $path,
            'views' => 0,
            'completion_rate' => 0,
        ]);

        return back()->with('success', 'Tutorial uploaded successfully!');
    }

    public function publicIndex(Request $request)
    {
        $tutorials = Tutorial::latest()
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->category, fn($q) => $q->where('category', $request->category))
            ->paginate(12);

        return view('tutorials.index', compact('tutorials'));
    }

    public function show(Tutorial $tutorial)
    {
        return view('tutorials.show', compact('tutorial'));
    }

    public function destroy(Tutorial $tutorial)
    {
        if ($tutorial->video_path && Storage::disk('public')->exists($tutorial->video_path)) {
            Storage::disk('public')->delete($tutorial->video_path);
        }

        $tutorial->delete();

        return redirect()->route('admin.tutorials.index')
            ->with('success', 'Tutorial deleted successfully!');
    }

    public function edit(Tutorial $tutorial)
    {
        return view('admin.tutorials.edit', compact('tutorial'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'nullable|mimes:mp4,mov,avi,flv,wmv|max:204800',
        ]);

        $tutorial->title = $request->title;
        $tutorial->description = $request->description;

        if ($request->hasFile('video')) {
            if ($tutorial->video_path && Storage::disk('public')->exists($tutorial->video_path)) {
                Storage::disk('public')->delete($tutorial->video_path);
            }

            $path = $request->file('video')->store('tutorials', 'public');
            $tutorial->video_path = $path;
        }

        $tutorial->save();

        return redirect()->route('admin.tutorials.index')
            ->with('success', 'Tutorial updated successfully!');
    }

    public function showPublic($id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $tutorial->increment('views');

        return view('tutorials.show', compact('tutorial'));
    }

    function formatNumber($n)
    {
        if ($n >= 1000000) return round($n/1000000,1).'M';
        if ($n >= 1000) return round($n/1000,1).'K';
        return $n;
    }

    public function incrementView($id)
    {
        $tutorial = Tutorial::findOrFail($id);
        $viewed = session()->get('viewed_tutorials', []);

        if (!in_array($id, $viewed)) {
            $tutorial->increment('views');
            session()->push('viewed_tutorials', $id);
        }

        return response()->json(['views' => $tutorial->views]);
    }

    // 🔥 NEW: update progress via AJAX
    //public function updateProgress(Request $request, $id)
    //{
    //    $request->validate([
    //        'progress' => 'required|integer|min:0|max:100',
    //    ]);

    //    $tutorial = Tutorial::findOrFail($id);

    //    if (!Auth::check()) {
    //        return response()->json(['error' => 'Not logged in'], 403);
    //    }

    //    $progress = TutorialProgress::updateOrCreate(
    //        ['user_id' => Auth::id(), 'tutorial_id' => $id],
    //        ['progress_percent' => $request->progress]
    //    );

        // update tutorial completion_rate (avg of all users)
    //    $avg = TutorialProgress::where('tutorial_id', $id)->avg('progress_percent');
    //    $tutorial->completion_rate = round($avg);
    //    $tutorial->save();

    //    return response()->json([
    //        'message' => 'Progress updated',
    //        'progress' => $progress->progress_percent,
    //        'completion_rate' => $tutorial->completion_rate,
    //    ]);
    //}
    
    protected function progressOwnerKey(): string
{
    return Auth::check() ? 'user:' . Auth::id() : 'session:' . session()->getId();
}

public function setDuration(Request $request, Tutorial $tutorial)
{
    $data = $request->validate([
        'duration' => 'required|numeric|min:1' // seconds
    ]);

    $owner = $this->progressOwnerKey();

    $row = TutorialProgress::firstOrNew([
        'tutorial_id' => $tutorial->id,
        'owner_key'   => $owner,
    ]);

    // keep the longest duration seen
    $row->duration_seconds = max((int)($row->duration_seconds ?? 0), (int)$data['duration']);
    $row->save();

    return response()->json(['ok' => true]);
}

public function updateProgress(Request $request, Tutorial $tutorial)
{
    $data = $request->validate([
        'progress'     => 'required|numeric|min:0|max:100',
        'current_time' => 'nullable|numeric|min:0',
        'duration'     => 'nullable|numeric|min:1'
    ]);

    $owner = $this->progressOwnerKey();

    $row = TutorialProgress::firstOrNew([
        'tutorial_id' => $tutorial->id,
        'owner_key'   => $owner,
    ]);

    // duration (optional) – keep the largest we’ve seen
    if (!empty($data['duration'])) {
        $row->duration_seconds = max((int)($row->duration_seconds ?? 0), (int)$data['duration']);
    }

    // current_time (optional)
    if (!empty($data['current_time'])) {
        $row->last_second = max((int)$row->last_second, (int)$data['current_time']);
        // update seconds_watched best-effort
        $row->seconds_watched = max((int)$row->seconds_watched, (int)$row->last_second);
    }

    // never let progress go backwards
    $row->progress_percent = max((int)$row->progress_percent, (int)$data['progress']);

    $row->save();

    return response()->json([
        'progress' => $row->progress_percent,
        'seconds'  => $row->seconds_watched,
        'duration' => $row->duration_seconds,
    ]);
}

}
