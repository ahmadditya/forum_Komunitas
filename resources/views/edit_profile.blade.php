@extends('layouts.main')
@section('contents')
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-md-12 p-1">
            <div class="card mb-2">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Profile</h5>
                </div>
                <div class="card-body">

                <div class="card-body text-center">
                    @if ($users->profile_image)
                        <img src="{{ asset('storage/' . $users->profile_image) }}" alt="Profile Image" class="img-fluid rounded" width="128" height="128" />
                    @else
                        <img src="/img/avatars/blank.png" alt="Default Profile Image" class="img-fluid rounded-circle" width="128" height="128" />
                    @endif
                </div>

                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ url('/profile/user/edit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 text-center mx-auto" style="max-width: 300px;">
    <label for="profile_image" class="form-label">Profile Image</label>
    <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image">
    @error('profile_image')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $users->name }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- <div class="mb-3">
                            <label for="profile_image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image">
                            @error('profile_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> -->
         
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
