@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-2">
        <span class="text-primary fw-light">Doctor</span>
    </h5>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.doctor.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $doctordata->id }}">
                        <div class="row">
                            @php
                                $fields = [
                                    ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'value' => old('name', $doctordata->full_name)],
                                    ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'value' => old('email', $doctordata->email)],
                                    ['label' => 'Phone Number', 'name' => 'phone', 'type' => 'text', 'value' => old('phone', $doctordata->phone)],
                                ];
                            @endphp

                            @foreach($fields as $field)
                                <div class="col-md-6 mb-2">
                                    <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}</label>
                                    <input type="{{ $field['type'] }}" class="form-control" id="{{ $field['name'] }}" name="{{ $field['name'] }}" value="{{ $field['value'] }}" placeholder="Enter {{ $field['label'] }}">
                                    @error($field['name'])
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach

                            <div class="col-md-6 mb-2">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="" {{ $doctordata->gender == null ? 'selected' : '' }}>Select Gender</option>
                                    <option value="male" {{ $doctordata->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $doctordata->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ $doctordata->gender == 'other' ? 'selected' : '' }}>Other</option>
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
                                        <option value="{{ $education->id }}" {{ $doctordata->education == $education->id ? 'selected' : '' }}>{{ $education->name }}</option>
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
                                        <option value="{{ $department->id }}" {{ $doctordata->department == $department->id ? 'selected' : '' }}>{{ $department->department }}</option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="profile" class="form-label">Profile</label>
                                <input class="form-control" type="file" id="profile" name="profile">
                                @error('profile')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                @if($doctordata->avatar)
                                    <img src="{{ asset($doctordata->avatar) }}" alt="Doctor Avatar" class="img-fluid">
                                @endif
                            </div>

                            <div class="col-md-12 mb-2">
                                <label for="description" class="form-label">About</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $doctordata->description) }}</textarea>
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
