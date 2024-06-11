@extends('admin.layouts.app')
@section('style')

@endsection
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h5 class="py-2 mb-2">
        <span class="text-primary fw-light">Department</span>
    </h5>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDepartment">Add Department</button>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered" id="departmentTable">
                            <thead>
                                <tr>
                                    <th>Department</th>
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
<div class="modal fade" id="addDepartment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCenterTitle">Add Department</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="department_name" class="form-label">Name</label>
                    <input type="text" id="department_name" name="department_name" class="form-control" placeholder="Enter Name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addDepartmentsave">Save</button>
            </div>
      </div>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editDepartment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCenterTitle">Edit Department</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col mb-3">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <label for="edit_department_name" class="form-label">Name</label>
                    <input type="text" id="edit_department_name" name="edit_department_name" class="form-control" placeholder="Enter Name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editDepartmentsave">Save</button>
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
        const departmentTable = $('#departmentTable');
        const addDepartmentsaveButton = $('#addDepartmentsave');
        const editDepartmentsaveButton = $('#editDepartmentsave');
        const addDepartmentModal = $('#addDepartment');
        const editDepartmentModal = $('#editDepartment');
        const departmentNameField = $('#department_name');
        const editdepartmentidField = $('#edit_id');
        const editdepartmentNameField = $('#edit_department_name');

        // Define URLs and CSRF token for AJAX requests
        const ajaxUrl = "{{route('admin.department.alldepartment')}}";
        const storeUrl = '{{ route("admin.department.store") }}';
        const statusUrl = "{{route('admin.department.status')}}";
        const deleteUrl = "{{route('admin.department.delete')}}";
        const editUrl = "{{route('admin.department.edit')}}";
        const updateUrl = "{{route('admin.department.update')}}";
        const token = "{{ csrf_token() }}";

        // Initialize DataTable
        function initializeDataTable() {
            if ($.fn.DataTable.isDataTable(departmentTable)) return;

            departmentTable.DataTable({
                processing: true,
                ajax: { url: ajaxUrl },
                columns: [
                    {
                        data: "department",
                    },
                    {
                        data: "status",
                        render: (data,type,row) => {
                            if(row.status == 'active'){
                                return '<span class="badge bg-label-success me-1">Active</span>'
                            }
                            if(row.status == 'inactive'){
                                return '<span class="badge bg-label-danger me-1">Inactive</span>';
                            }
                        }
                    },
                    {
                        data: "action",
                        render: (data,type,row) => {
                            const buttonClass = row.status === 'inactive' ? 'success' : 'danger';
                            const newStatus = row.status === 'inactive' ? 'active' : 'inactive';
                            return `
                                <button type="button" class="btn btn-sm btn-${buttonClass}" onclick="toggleStatus(${row.id}, '${newStatus}')">${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="toggleDelete(${row.id})">Delete</button>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUnit" onclick="toggleEdit(${row.id})">Edit</button>`;
                        }
                    }
                ],
            });
        }

        // Function to toggle the status of a unit
        function toggleStatus(departmentId, newStatus) {
            const message = newStatus === 'active' ? 'Department is activated' : 'Department is deactivated';

            Swal.fire({
                title: 'Are you sure?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Okay'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: statusUrl,
                        data: {
                            departmentId: departmentId,
                            status: newStatus,
                            _token: token
                        },
                        success: function(response) {
                            const messageType = response.success ? 'success' : 'error';
                            setFlash(messageType, response.success ? `Department ${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)} Successfully` : 'Error changing status! Please contact the administrator');
                            departmentTable.DataTable().ajax.reload();
                        },
                        error: function() {
                            setFlash('error', 'An error occurred while changing status! Please contact the administrator.');
                        }
                    });
                }
            });
        }

        // Function to delete a unit
        function toggleDelete(departmentId) {
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
                        url: deleteUrl,
                        data: {
                            departmentId: departmentId,
                            _token: token
                        },
                        success: function(response) {
                            const messageType = response.success ? 'success' : 'error';
                            setFlash(messageType, response.success ? 'Department Deleted Successfully' : 'Error deleting Department! Please contact the administrator');
                            departmentTable.DataTable().ajax.reload();
                        },
                        error: function() {
                            setFlash('error', 'An error occurred while deleting Department! Please contact the administrator.');
                        }
                    });
                }
            });
        }

        // Function to edit a unit
        function toggleEdit(departmentId) {
            $.ajax({
                type: "POST",
                url: editUrl,
                data: {
                    departmentId: departmentId,
                    _token: token
                },
                success: function(response) {
                    editdepartmentidField.val(response.data.id);
                    editdepartmentNameField.val(response.data.department);
                    editDepartmentModal.modal('show');
                },
                error: function() {
                    setFlash('error', 'An error occurred while fetching unit data! Please contact the administrator.');
                }
            });
        }

        // Save new unit
        addDepartmentsaveButton.click(function(event) {
            event.preventDefault();
            addDepartmentsaveButton.prop('disabled', true);

            const departmentName = departmentNameField.val();

            $.ajax({
                type: "POST",
                url: storeUrl,
                data: {
                    _token: token,
                    name: departmentName
                },
                success: function(response) {
                    const messageType = response.success ? 'success' : 'error';
                    setFlash(messageType, response.success ? 'department Added Successfully' : response.errors);
                    departmentTable.DataTable().ajax.reload();
                    addDepartmentModal.modal('hide');
                    departmentNameField.val('');
                },
                complete: function() {
                    addDepartmentsaveButton.prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', error);
                    addDepartmentsaveButton.prop('disabled', false);
                }
            });
        });

        // Save edit unit
        editDepartmentsaveButton.click(function(event) {
            event.preventDefault();
            editDepartmentsaveButton.prop('disabled', true);

            const editdepartmentName = editdepartmentNameField.val();
            const editdepartmentId = editdepartmentidField.val();

            $.ajax({
                type: "POST",
                url: updateUrl,
                data: {
                    _token: token,
                    departmentName: editdepartmentName,
                    departmentId: editdepartmentId
                },
                success: function(response) {
                    const messageType = response.success ? 'success' : 'error';
                    setFlash(messageType, response.success ? 'Unit Edit Successfully' : response.errors);
                    departmentTable.DataTable().ajax.reload();
                    editDepartmentModal.modal('hide');
                    editdepartmentNameField.val('');
                    editdepartmentidField.val('');
                },
                complete: function() {
                    editDepartmentsaveButton.prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', error);
                    editDepartmentsaveButton.prop('disabled', false);
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
    // Helper function to set flash messages
    function setFlash(type, message) {
        // Implement your flash message logic here
    }
</script>
@endsection
