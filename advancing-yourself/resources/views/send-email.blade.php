<!DOCTYPE html>
<html>
<head>
    <title>Form Kirim Email</title>
</head>
<body>
    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('send.mail') }}" method="POST">
        @csrf
        <label>Email Tujuan:</label>
        <input type="email" name="email" required>
        <button type="submit">Kirim Email</button>
    </form>
</body>
</html>
