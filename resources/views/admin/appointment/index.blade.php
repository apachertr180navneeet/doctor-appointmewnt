@extends('admin.layouts.app')
@section('style')

@endsection
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-2">
        <span class="text-primary fw-light">Appointment List</span>
    </h5>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('admin.appointment.create')}}" class="btn btn-primary">Add Appointment</a>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@section('script')
</script>
<script>

</script>
@endsection
