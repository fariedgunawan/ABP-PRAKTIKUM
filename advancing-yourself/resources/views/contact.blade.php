<form method="POST" action="{{ route('contact.send.mail') }}">
    @csrf
    <input type="text" name="name" placeholder="Name">
    @error('name') <p>{{ $message }}</p> @enderror

    <input type="email" name="email" placeholder="Email">
    @error('email') <p>{{ $message }}</p> @enderror

    <button type="submit">Send</button>
</form>