@php
    $user_id = $message->user_id;
    $user = App\Models\User::find($user_id);
    $name = $user->name;
    $current_user_id = Auth::user()->id;
@endphp
<div class="message-card text-gray-600 dark:text-gray-400 text-sm mb-4">
    <div class="mb-1 flex items-center gap-x-1">
        @if ($user_id == $current_user_id)
        <span class="font-semibold text-purple-500 dark:text-purple-600">{{ $name }}</span>
        @else
        <span class="ml-auto font-semibold text-purple-500 dark:text-purple-600">{{ $name }}</span>
        @endif
        <span class="text-gray-400 dark:text-gray-400 text-xs italic">{{ $message->created_at->diffForHumans() }}</span>
        
        @role(1)
        <x-emotion-display class="px-2 py-0.5 capitalize text-xs rounded-full italic underline" :emotion="$message->emotion" />
        @endrole
        
    </div>
    <div class="flex">
        @if ($user_id == $current_user_id)
        <div class="min-w-0 p-2 bg-white rounded-lg shadow-xs dark:bg-gray-700 mb-1 inline-block" >
        @else
        <div class="min-w-0 p-2 bg-white rounded-lg shadow-xs dark:bg-gray-700 mb-1 inline-block ml-auto mr-2" >
        @endif
            <p class="text-gray-600 dark:text-gray-400"> {{ $message->message }} </p>
            
        </div>
    </div>
    
</div>