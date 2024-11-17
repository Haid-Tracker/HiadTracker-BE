<div class="card">
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')
        <div class="card-header">
            <div class="d-flex flex-column">
                <h4>Update Password</h4>
                <p>Ensure your account is using a long, random password to stay secure.</p>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input id="current_password" name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" value="{{ old('current_password') }}" required autocomplete="current-password">
                @error('current_password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" required autocomplete="new-password">
                @error('password_confirmation')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
