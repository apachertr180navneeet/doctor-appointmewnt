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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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
            ajax: "{{route('admin.education.alllist')}}",
            status: "{{route('admin.education.status')}}",
            delete: "{{route('admin.education.delete')}}",
        };
        const token = "{{ csrf_token() }}";

        // Initialize DataTable
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable($table)) return;

            $table.DataTable({
                processing: true,
                ajax: { url: urls.ajax },
                columns: [
                    { data: "name" },
                    {
                        data: "status",
                        render: (data, type, row) => {
                            return row.status === 'active' ?
                                '<span class="badge bg-label-success me-1">Active</span>' :
                                '<span class="badge bg-label-danger me-1">Inactive</span>';
                        }
                    },
                    {
                        data: "action",
                        render: (data, type, row) => {
                            const buttonClass = row.status === 'inactive' ? 'success' : 'danger';
                            const newStatus = row.status === 'inactive' ? 'active' : 'inactive';
                            return `
                                <button type="button" class="btn btn-sm btn-${buttonClass}" onclick="toggleStatus(${row.id}, '${newStatus}')">${capitalize(newStatus)}</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="toggleDelete(${row.id})">Delete</button>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUnit" onclick="toggleEdit(${row.id})">Edit</button>`;
                        }
                    }
                ],
            });
        }

        // Capitalize the first letter of a string
        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        // Function to toggle the status of a unit
        function toggleStatus(id, newStatus) {
            Swal.fire({
                title: 'Are you sure?',
                text: newStatus === 'active' ? 'Department is activated' : 'Department is deactivated',
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
                            setFlash(messageType, response.success ? `Department ${capitalize(newStatus)} Successfully` : 'Error changing status! Please contact the administrator');
                            $table.DataTable().ajax.reload();
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
                text: 'Department will be deleted!',
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
                            setFlash(messageType, response.success ? 'Department Deleted Successfully' : 'Error deleting Department! Please contact the administrator');
                            $table.DataTable().ajax.reload();
                        },
                        error: () => setFlash('error', 'An error occurred while deleting Department! Please contact the administrator.')
                    });
                }
            });
        }

        // Attach toggle functions to the window object
        window.toggleStatus = toggleStatus;
        window.toggleDelete = toggleDelete;

        // Initialize the DataTable on page load
        initializeDataTable();
    });

    // Helper function to set flash messages using Toastr
    function setFlash(type, message) {

    }

</script>
@endsection
