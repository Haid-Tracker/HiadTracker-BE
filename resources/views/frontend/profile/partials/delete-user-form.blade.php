<div class="card">
    <div class="card-header">
        <div class="d-flex flex-column">
            <h4>Delete Account</h4>
            <p>
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
            </p>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger" input="modal-5" data-toggle="modal" data-target="#confirmDeleteModal">Delete Account</button>
    </div>
</div>

{{-- Modal --}}
<form method="POST" action="{{ route('profile.destroy') }}">
    @csrf
    @method('delete')
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Are you sure you want to delete your account?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                    </p>
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input id="current_password" name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" required autocomplete="current-password">
                        @error('current_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </div>
        </div>
    </div>
</form>
