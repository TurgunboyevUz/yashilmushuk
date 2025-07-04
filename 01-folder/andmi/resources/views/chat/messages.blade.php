@foreach($messages as $message)
    <div class="message my-2 d-flex align-items-start {{ $message->user_id == $user->id ? 'flex-row-reverse' : '' }}">
        <img src="{{ $message->user->picture_path() }}" alt="{{ $message->user->short_fio() }}'s profile" class="rounded-circle {{ $message->user_id == $user->id ? 'ml-2' : 'mr-2' }}" style="width: 40px; height: 40px;">
        <div class="{{ $message->user_id == $user->id ? 'text-right' : '' }}">
            <strong>{{ $message->user_id == $user->id ? 'Siz' : $message->user->short_fio() }}:</strong>
            <p>{{ $message->content }}</p>
            
            @if ($message->user_id == $user->id)
                <button class="btn btn-danger btn-sm delete-message" data-message-id="{{ $message->id }}" style="padding: 5px 7px; font-size: 14px;">
                    <i class="fas fa-trash-alt"></i>
                </button>
            @endif
        </div>
    </div>
@endforeach