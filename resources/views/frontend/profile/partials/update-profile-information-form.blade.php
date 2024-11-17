<div class="card">
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')
        <div class="card-header">
            <div class="d-flex flex-column">
                <h4>Profile Information</h4>
                <p>Update your account's profile information and email address.</p>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

