@extends('admin.layouts.app')
@section('style')

@endsection
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-2">
        <span class="text-primary fw-light">Role</span>
    </h5>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRole">Add Role</button>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" id="roleTable">
                            <thead>
                                <tr>
                                    <th>Role</th>
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

<!-- Add Modal -->
<div class="modal fade" id="addRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCenterTitle">Add Education</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="role_name" class="form-label">Name</label>
                    <input type="text" id="role_name" name="role_name" class="form-control" placeholder="Enter Name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addRolesave">Save</button>
            </div>
      </div>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCenterTitle">Edit Education</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <label for="edit_role_name" class="form-label">Name</label>
                    <input type="text" id="edit_role_name" name="edit_role_name" class="form-control" placeholder="Enter Name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editRolesave">Save</button>
            </div>
      </div>
    </div>
  </div>
</div>



@endsection
@section('script')
</script>
<script>
    $(document).ready(function() {
        // Cache DOM elements for better performance
        const $table = $('#roleTable');
        const $addSaveButton = $('#addRolesave');
        const $editSaveButton = $('#editRolesave');
        const $addModal = $('#addRole');
        const $editModal = $('#editRole');
        const $nameField = $('#role_name');
        const $editIdField = $('#edit_id');
        const $editNameField = $('#edit_role_name');

        // Define URLs and CSRF token for AJAX requests
        const urls = {
            ajax: "{{route('admin.role.alllist')}}",
            store: '{{ route("admin.role.store") }}',
            status: "{{route('admin.role.status')}}",
            delete: "{{route('admin.role.delete')}}",
            edit: "{{route('admin.role.edit')}}",
            update: "{{route('admin.role.update')}}"
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

        // Function to edit a unit
        function toggleEdit(Id) {
            $.ajax({
                type: "POST",
                url: urls.edit,
                data: { Id, _token: token },
                success: (response) => {
                    $editIdField.val(response.data.id);
                    $editNameField.val(response.data.name);
                    $editModal.modal('show');
                },
                error: () => setFlash('error', 'An error occurred while fetching unit data! Please contact the administrator.')
            });
        }

        // Save new unit
        $addSaveButton.click((event) => {
            event.preventDefault();
            $addSaveButton.prop('disabled', true);

            $.ajax({
                type: "POST",
                url: urls.store,
                data: { _token: token, name: $nameField.val() },
                success: (response) => {
                    const messageType = response.success ? 'success' : 'error';
                    setFlash(messageType, response.success ? 'Department Added Successfully' : response.errors);
                    $table.DataTable().ajax.reload();
                    $addModal.modal('hide');
                    $nameField.val('');
                },
                complete: () => $addSaveButton.prop('disabled', false),
                error: (xhr, status, error) => {
                    console.error('An error occurred:', error);
                    $addSaveButton.prop('disabled', false);
                }
            });
        });

        // Save edit unit
        $editSaveButton.click((event) => {
            event.preventDefault();
            $editSaveButton.prop('disabled', true);

            $.ajax({
                type: "POST",
                url: urls.update,
                data: { _token: token, roleName: $editNameField.val(), roleId: $editIdField.val() },
                success: (response) => {
                    const messageType = response.success ? 'success' : 'error';
                    setFlash(messageType, response.success ? 'Department Edited Successfully' : response.errors);
                    $table.DataTable().ajax.reload();
                    $editModal.modal('hide');
                    $editNameField.val('');
                    $editIdField.val('');
                },
                complete: () => $editSaveButton.prop('disabled', false),
                error: (xhr, status, error) => {
                    console.error('An error occurred:', error);
                    $editSaveButton.prop('disabled', false);
                }
            });
        });

        // Attach toggle functions to the window object
        window.toggleStatus = toggleStatus;
        window.toggleDelete = toggleDelete;
        window.toggleEdit = toggleEdit;

        // Initialize the DataTable on page load
        initializeDataTable();
    });

    // Helper function to set flash messages using Toastr
    function setFlash(type, message) {

    }

</script>
@endsection
