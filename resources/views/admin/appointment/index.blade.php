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
                    <a href="{{ route('admin.appointment.create', $usersId) }}" class="btn btn-primary">Add Appointment</a>
                    <div class="table-responsive text-nowrap mt-2">
                        <table class="table table-bordered" id="appointmentTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->date }}</td>
                                        <td>
                                            <a href="{{ route('admin.appointment.show', $appointment->id) }}" class="btn btn-sm btn-info">View</a>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="toggleDelete({{ $appointment->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@section('script')
<script>
    $(document).ready(function() {
        // Cache DOM elements for better performance
        const $table = $('#appointmentTable');

        // Define URLs and CSRF token for AJAX requests
        const urls = {
            delete: "{{route('admin.appointment.delete')}}",
        };
        const token = "{{ csrf_token() }}";

        // Initialize DataTable
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable($table)) return;

            $table.DataTable({
                processing: true,
            });
        }


        // Function to delete a unit
        function toggleDelete(Id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Appointment will be deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Okay'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: urls.delete,
                        data: { Id, _token: token },
                        success: (response) => {
                            const messageType = response.success ? 'success' : 'error';
                            setFlash(messageType, response.success ? 'Appointment Deleted Successfully' : 'Error deleting Appointment! Please contact the administrator');
                            location.reload();
                        },
                        error: () => setFlash('error', 'An error occurred while deleting Department! Please contact the administrator.')
                    });
                }
            });
        }

        // Capitalize the first letter of a string
        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
        window.toggleDelete = toggleDelete;

        // Initialize the DataTable on page load
        initializeDataTable();
    });

    // Helper function to set flash messages using Toastr
    function setFlash(type, message) {
        setFlesh(type,message);
    }
</script>
@endsection
