<div>
    <form action="{{ route('auth.password.update') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" value="{{ $email }}" readonly>
        <br>
        <label for="password">New Password: </label>
        <input type="password" name="password" id="password">
        <br>
        <label for="password_confirmation">Confirm New Password: </label>
        <input type="password" name="password_confirmation" id="password_confirmation">

        <button type="submit">Change Password</button>
    </form>

    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
