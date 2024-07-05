@extends('admin.layouts.app')

@section('style')
<!-- Add custom styles here if necessary -->
@endsection
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-2">
        <span class="text-primary fw-light">Appointment Show</span>
    </h5>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4>
                        @if(isset($date))
                            Your timetable for:
                            {{$date}}
                        @endif
                    </h4>
                    <form action="{{ route('admin.appointment.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="userid" value="{{ $appointmentdata->user_id }}">
                        <div class="row">
                            <div class="col-md-12 mb-2 mt-2">
                                <label for="date" class="form-label">Choose Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" placeholder="Enter Date" />
                                @error('date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">check</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>

</script>
@endsection
