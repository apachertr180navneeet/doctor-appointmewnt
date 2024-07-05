@extends('doctor.layouts.app')

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
            <div class="card mt-2 mb-2">
                <div class="card-body">
                    <h4>
                        @if(isset($date))
                            Your timetable for:
                            {{$date}}
                        @endif
                    </h4>
                    <form action="{{ route('doctor.appointment.check') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="appointmentid" value="{{ $appointmentdata->id }}">
                        <input type="hidden" name="userid" value="{{ $appointmentdata->user_id }}">
                        <div class="row">
                            <div class="col-md-12 mb-2 mt-2">
                                <label for="date" class="form-label">Choose Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{$date}}" placeholder="Enter Date" />
                                @error('date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">check</button>
                    </form>
                </div>
            </div>
            <div class="card mt-2 mb-2">
                <div class="card-body">
                    <div class="row">
                        <form action="{{ route('doctor.appointment.update.time') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="appoinmentId" value="{{ $appointmentdata->id }}">
                            <div class="col-md-12 mb-2 mt-2">
                                <label for="am-times" class="form-label">Choose AM Time</label>
                                <span class="float-end">
                                    Select All
                                    <input type="checkbox" class="form-check-input" id="select-all-am" />
                                </span>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead></thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach (['6am' => '6:00 am', '6.20am' => '6:20 am', '6.40am' => '6:40 am', '7am' => '7:00 am', '7.20am' => '7:20 am', '7.40am' => '7:40 am', '8am' => '8:00 am', '8.20am' => '8:20 am', '8.40am' => '8:40 am', '9am' => '9:00 am', '9.20am' => '9:20 am', '9.40am' => '9:40 am', '10am' => '10:00 am', '10.20am' => '10:20 am', '10.40am' => '10:40 am', '11am' => '11:00 am', '11.20am' => '11:20 am', '11.40am' => '11:40 am'] as $value => $label)
                                                @if ($loop->index % 3 === 0)
                                                <tr>
                                                @endif
                                                <td>
                                                    <input type="checkbox" class="form-check-input" name="time[]" id="time-{{ $value }}" value="{{ $value }}" @if(isset($times)){{$times->contains('time',$value )?'checked':''}}@endif />
                                                    <label class="form-check-label" for="time-{{ $value }}">
                                                        {{ $label }}
                                                    </label>
                                                </td>
                                                @if ($loop->index % 3 === 2)
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12 mb-2 mt-2">
                                <label for="pm-times" class="form-label">Choose PM Time</label>
                                <span class="float-end">
                                    Select All
                                    <input type="checkbox" class="form-check-input" id="select-all-pm" />
                                </span>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead></thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach (['12pm' => '12:00 pm', '12.20pm' => '12:20 pm', '12.40pm' => '12:40 pm', '1pm' => '1:00 pm', '1.20pm' => '1:20 pm', '1.40pm' => '1:40 pm', '2pm' => '2:00 pm', '2.20pm' => '2:20 pm', '2.40pm' => '2:40 pm', '3pm' => '3:00 pm', '3.20pm' => '3:20 pm', '3.40pm' => '3:40 pm', '4pm' => '4:00 pm', '4.20pm' => '4:20 pm', '4.40pm' => '4:40 pm', '5pm' => '5:00 pm', '5.20pm' => '5:20 pm', '5.40pm' => '5:40 pm'] as $value => $label)
                                                @if ($loop->index % 3 === 0)
                                                <tr>
                                                @endif
                                                <td>
                                                    <input type="checkbox" class="form-check-input" name="time[]" id="time-{{ $value }}" value="{{ $value }}" @if(isset($times)){{$times->contains('time',$value )?'checked':''}}@endif/>
                                                    <label class="form-check-label" for="time-{{ $value }}">
                                                        {{ $label }}
                                                    </label>
                                                </td>
                                                @if ($loop->index % 3 === 2)
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Update</button>
                        </form>
                    </div>
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
