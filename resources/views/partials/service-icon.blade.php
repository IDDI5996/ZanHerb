
@if(!empty($secondary_icon))
    <div class="relative inline-flex items-center">
        <span class="text-2xl text-green-600">
            @include('partials.single-icon', ['icon' => $icon])
        </span>
        <span class="text-xl text-green-500 ml-1 -mr-1">
            +
        </span>
        <span class="text-2xl text-green-600">
            @include('partials.single-icon', ['icon' => $secondary_icon])
        </span>
    </div>
@else
    <span class="text-2xl text-green-600">
        @include('partials.single-icon', ['icon' => $icon])
    </span>
@endif