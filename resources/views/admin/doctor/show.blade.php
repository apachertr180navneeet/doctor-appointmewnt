@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-2">
        <span class="text-primary fw-light">Doctor</span>
    </h5>
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-6 col-lg-5 col-md-5 order-1 order-md-0">
          <!-- User Card -->
          <div class="card mb-4">
            <div class="card-body">
              <div class="user-avatar-section">
                <div class=" d-flex align-items-center flex-column">
                  <img class="img-fluid rounded my-4" src="{{ asset($doctordata->avatar) }}" height="110" width="110" alt="User avatar" />
                  <div class="user-info text-center">
                    <h4 class="mb-2">{{ $doctordata->full_name }}</h4>
                    <span class="badge bg-label-secondary">{{ $doctordata->role }}</span>
                  </div>
                </div>
              </div>
              <h5 class="pb-2 border-bottom mb-4">Details</h5>
              <div class="info-container">
                <ul class="list-unstyled">
                  <li class="mb-3">
                    <span class="fw-medium me-2">Email:</span>
                    <span>{{ $doctordata->email }}</span>
                  </li>
                  <li class="mb-3">
                    <span class="fw-medium me-2">Contact:</span>
                    <span>{{ $doctordata->phone }}</span>
                  </li>
                  <li class="mb-3">
                    <span class="fw-medium me-2">Gender:</span>
                    <span>{{ $doctordata->gender }}</span>
                  </li>
                  <li class="mb-3">
                    <span class="fw-medium me-2">Department:</span>
                    <span>{{ $doctordata->department }}</span>
                  </li>
                  <li class="mb-3">
                    <span class="fw-medium me-2">Education:</span>
                    <span>{{ $doctordata->name }}</span>
                  </li>
                </ul>
                <div class="d-flex justify-content-center pt-3">
                  <a href="{{ route('admin.doctor.edit', $doctordata->id) }}" class="btn btn-primary me-3">Edit</a>
                </div>
              </div>
            </div>
          </div>
          <!-- /User Card -->
        </div>
        <!--/ User Sidebar -->
      </div>
</div>
@endsection
