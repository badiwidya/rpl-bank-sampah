<div>
    <h1>Ganti Password</h1>
    <form action="{{ route($routeName . '.update') }}" method="post">
        @csrf
        <label for="old_password">Password Lama: </label>
        <input type="password" name="old_password" id="old_password">
        @error('old_password')
            <p>{{ $message }}</p>
        @enderror
        <br>
        <label for="password">Password Baru: </label>
        <input type="password" name="password" id="password">
        @error('password')
            <p>{{ $message }}</p>
        @enderror
        <br>
        <label for="password_confirmation">Konfirmasi Password Baru: </label>
        <input type="password" name="password_confirmation" id="password_confirmation">

        <button type="submit">Perbarui Password</button>
        @error('rate_limit')
            <p>{{ $message }}</p>
        @enderror
        
    </form>
</div>
