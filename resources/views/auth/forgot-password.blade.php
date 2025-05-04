<div>
    <form action="{{ route('auth.password.email') }}" method="post">
        @csrf
        <label for="email">Please enter your email address: </label>
        <input type="email" name="email" id="email">
        <button type="submit">Reset Password</button>
    </form>
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif
</div>
