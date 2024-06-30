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
                    <a href="{{route('admin.doctor.create')}}" class="btn btn-primary">Add Doctor</a>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" id="doctorTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $users as $user)
                                    <tr>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @if($user->status == "active")
                                                <span class="badge bg-label-success me-1">Active</span>
                                            @else
                                                <span class="badge bg-label-danger me-1">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.doctor.show', $user->id) }}" class="btn btn-sm btn-info">View</a>
                                            @if($user->status == "active")
                                                <button type="button" class="btn btn-sm btn-danger" onclick="toggleStatus({{ $user->id }}, 'inactive')">Inactive</button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-success" onclick="toggleStatus({{ $user->id }}, 'active')">Active</button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-danger" onclick="toggleDelete({{ $user->id }})">Delete</button>
                                            <a href="{{ route('admin.doctor.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
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
        const $table = $('#doctorTable');

        // Define URLs and CSRF token for AJAX requests
        const urls = {
            status: "{{route('admin.doctor.status')}}",
            delete: "{{route('admin.doctor.delete')}}",
        };
        const token = "{{ csrf_token() }}";

        // Initialize DataTable
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable($table)) return;

            $table.DataTable({
                processing: true,
            });
        }

        // Function to toggle the status of a unit
        function toggleStatus(id, newStatus) {
            Swal.fire({
                title: 'Are you sure?',
                text: newStatus === 'active' ? 'Doctor is activated' : 'Doctor is deactivated',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Okay'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: urls.status,
                        data: { id: id, status: newStatus, _token: token },
                        success: (response) => {
                            const messageType = response.success ? 'success' : 'error';
                            setFlash(messageType, response.success ? `Doctor ${capitalize(newStatus)} Successfully` : 'Error changing status! Please contact the administrator');
                            location.reload();
                        },
                        error: () => setFlash('error', 'An error occurred while changing status! Please contact the administrator.')
                    });
                }
            });
        }

        // Function to delete a unit
        function toggleDelete(Id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Doctor will be deleted!',
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
                            setFlash(messageType, response.success ? 'Doctor Deleted Successfully' : 'Error deleting Doctor! Please contact the administrator');
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

        // Attach toggle functions to the window object
        window.toggleStatus = toggleStatus;
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
