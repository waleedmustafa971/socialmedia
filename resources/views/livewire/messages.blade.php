<div>
    <ul>
        @foreach ($messages as $message)
            <li>
                <p>{{ $message->body }}</p>
                <p>From: {{ $message->sender->name }}</p>
            </li>
        @endforeach
    </ul>
</div>
