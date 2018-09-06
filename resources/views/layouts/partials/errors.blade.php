@if (count($errors) > 0)
    <div class="chatter-alert alert alert-danger">
        <div class="container">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif