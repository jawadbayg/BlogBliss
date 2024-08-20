@extends('layouts.app')

@section('content')
@if(Auth::check() && !Auth::user()->isFalse)
    <div class="alert alert-warning" role="alert">
        Your application is under review.
    </div>
@endif
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
@include('partials.admin-nav')
<div class="container">
    <div class="row mb-3">
        <div class="col-lg-12 text-center">
            <h2 style="font-family: 'Barlow Semi Condensed', sans-serif;">Users Management</h2>
        </div>
        <div class="col-lg-12">
            <a class="btn btn-success mb-2" href="{{ route('users.create') }}">
                <i class="fa fa-plus"></i> Create New User
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" role="alert"> 
            {{ session('success') }}
        </div>
    @endif
    <!-- <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Total Users
                </div>
                <div class="card-body text-center">
                    <h3>{{ $userCount }}</h3>
                </div>
            </div>
        </div>
    </div> -->
    <div class="table-responsive">
        <table id="usersTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
                <!-- DataTables will populate this -->
            </tbody>
        </table>
    </div>
</div>

<!-- Include the JS for DataTables and other required scripts here -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('users.index') }}",
            type: 'GET',
            data: function (d) {
                d._token = "{{ csrf_token() }}";
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'roles', name: 'roles' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[0, 'desc']],
        paging: true,
        pageLength: 5,
        language: {
            paginate: {
                previous: '&laquo;',
                next: '&raquo;'
            }
        }
    });
});
function confirmDelete(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm' + userId).submit();
        }
    })
}

</script>
@endsection
