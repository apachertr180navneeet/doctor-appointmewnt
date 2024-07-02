@extends('admin.layouts.app')
@section('style')

@endsection
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-2">
        <span class="text-primary fw-light">Appointment Add</span>
    </h5>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.doctor.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2 mt-2">
                                <label for="name" class="form-label">Choose Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" placeholder="Enter Date" />
                                @error('date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2 mt-2">
                                <label for="name" class="form-label">Choose AM Time</label>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead></thead>
                                        <tbody class="table-border-bottom-0">
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" name="time[]" value="6am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        6:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" name="time[]" value="6.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        6:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" name="time[]" value="6.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        6:40am
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="7am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        7:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="7.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        7:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="7.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        7:40 am
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="8am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        8:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="8.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        8:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="8.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        8:40 am
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">4</th>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="9am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        9:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="9.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        9:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="9.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        9:40am
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">5</th>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="10am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        10:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="10.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        10:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="10.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        10:40 am
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">6</th>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="11am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        11:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="11.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        11:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="11.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        11:40 am
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12 mb-2 mt-2">
                                <label for="name" class="form-label">Choose PM Time</label>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead></thead>
                                        <tbody class="table-border-bottom-0">
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" name="time[]" value="6am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        6:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" name="time[]" value="6.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        6:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="form-check-input" name="time[]" value="6.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        6:40am
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="7am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        7:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="7.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        7:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="7.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        7:40 am
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="8am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        8:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="8.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        8:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="8.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        8:40 am
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">4</th>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="9am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        9:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="9.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        9:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="9.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        9:40am
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">5</th>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="10am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        10:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="10.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        10:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="10.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        10:40 am
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th scope="row">6</th>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="11am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        11:00 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="11.20am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        11:20 am
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="time[]" class="form-check-input" value="11.40am" />
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        11:40 am
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
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
</script>
<script>

</script>
@endsection
