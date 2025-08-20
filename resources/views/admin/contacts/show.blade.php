@extends('layouts.app')

@section('content')
<div class="py-8 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to messages
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Contact Message Details
                    </h3>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        @if($contact->responded) bg-green-100 text-green-800 
                        @else bg-yellow-100 text-yellow-800 @endif">
                        @if($contact->responded) Responded @else Pending @endif
                    </span>
                </div>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $contact->name }}</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $contact->email }}</div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Message</label>
                        <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $contact->message }}</div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Received</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $contact->created_at->format('F j, Y \a\t g:i a') }}</div>
                    </div>
                </div>

                @if($contact->responded)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Your Response</h4>
                        <div class="bg-blue-50 p-4 rounded-md">
                            <p class="text-sm text-gray-800 whitespace-pre-line">{{ $contact->admin_response }}</p>
                            <p class="mt-2 text-xs text-gray-500">Responded on {{ $contact->updated_at->format('F j, Y \a\t g:i a') }}</p>
                        </div>
                    </div>
                @else
                    <form method="POST" action="{{ route('admin.contacts.respond', $contact) }}" class="mt-8 pt-6 border-t border-gray-200">
                        @csrf
                        <div>
                            <label for="response" class="block text-sm font-medium text-gray-700">Your Response</label>
                            <div class="mt-1">
                                <textarea id="response" name="response" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required></textarea>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">This response will be emailed to {{ $contact->name }}</p>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Send Response
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection