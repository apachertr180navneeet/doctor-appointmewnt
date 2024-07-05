@extends('doctor.layouts.app')
@section('style')
<style>
 .user-image{
    height: 70px;
    width: auto;
    border:1px dotted lightgray;
    padding:4px;
    margin: 0 auto;
 }
</style>
@endsection
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-2">
        <span class="text-primary fw-light">My Profile</span>
    </h5>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card profile-card">
                <div class="card-body  pb-5">
                    <form action="{{ route('doctor.update.profile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">First Name*</label>
                                    <input type="text" id="" name="first_name" class="form-control" placeholder="Enter First Name" value="{{old('first_name',$user->first_name)}}" required>
                                    @error('first_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Last Name*</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" value="{{ old('last_name',$user->last_name)}}" required>
                                    @error('last_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number*</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{ old('phone',$user->phone) }}" required>
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email Address*</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email Address" value="{{ old('email',$user->email) }}" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Profile Picture</label>

                                    <div class="input-group">
                                        <input type="file" name="avatar" accept="image/*" class="form-control" id="avatar" aria-describedby="inputGroupFileAddon04" aria-label="Upload" onchange="document.getElementById('user-image').src = window.URL.createObjectURL(this.files[0])">
                                    </div>

                                    @error('avatar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if($user->avatar)
                                    <img src="{{asset($user->avatar)}}" class="user-image" id="user-image">
                                @else
                                    <img src="{{asset('assets/admin/img/avatars/1.png')}}" class="user-image" id="user-image">
                                @endif
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="" {{ $user->gender == null ? 'selected' : '' }}>Select Gender</option>
                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="education" class="form-label">Education</label>
                                <select class="form-select" id="education" name="education">
                                    <option value="" selected>Select Education</option>
                                    @foreach($educations as $education)
                                        <option value="{{ $education->id }}" {{ $user->education == $education->id ? 'selected' : '' }}>{{ $education->name }}</option>
                                    @endforeach
                                </select>
                                @error('education')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-select" id="department" name="department">
                                    <option value="" {{ old('department') == null ? 'selected' : '' }}>Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ $user->department == $department->id ? 'selected' : '' }}>{{ $department->department }}</option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-4">
                            <div class="col-md-12 submit-btn">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(".timezone").select2().on('select2:opening', function(e) {
        $(this).data('select2').$dropdown.find(':input.select2-search__field').attr('placeholder', 'Search your timezone')
    })
</script>
@endsection
