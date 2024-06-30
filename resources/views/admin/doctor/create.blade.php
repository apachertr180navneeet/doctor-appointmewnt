@extends('admin.layouts.app')
@section('style')

@endsection
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-2">
        <span class="text-primary fw-light">Doctor</span>
    </h5>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.doctor.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Email">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="" {{ old('gender') == null ? 'selected' : '' }}>Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="education" class="form-label">Education</label>
                                <select class="form-select" id="education" name="education">
                                    <option value="" selected>Select Education</option>
                                    @foreach($educations as $education)
                                        <option value="{{ $education->id }}" {{ old('education') == $education->id ? 'selected' : '' }}>{{ $education->name }}</option>
                                    @endforeach
                                </select>
                                @error('education')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-select" id="department" name="department">
                                    <option value="" {{ old('department') == null ? 'selected' : '' }}>Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>{{ $department->department }}</option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="profile" class="form-label">Profile</label>
                                <input class="form-control" type="file" id="profile" name="profile">
                                @error('profile')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="description" class="form-label">About</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection
