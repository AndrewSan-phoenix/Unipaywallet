@extends('backend.layouts.app')
@section('title', 'Admin Users')
@section('admin-user-active', 'mm-active')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
            <img src="{{asset('img/admin.png')}}" alt="" style="width:30px;height:30px;">
                <!-- <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i> -->
            </div>
            <div>Admin Users</div>
        </div>
    </div>
</div>

<div class="pt-3">
    <a href="{{route('admin.admin-user.create')}}" class="btn btn-primary"><img src="{{asset('img/plus.png')}}" alt="" style="width:20px;height:20px;border:2px solid white;border-radius:50px;"> Create Admin User</a>
</div>

<div class="content py-3">
    <div class="card">
        <div class="card-body">
        <div class="container">
        <div id="resize_wrapper">
            
            <table class="table table-bordered Datatable text-nowrap w-100">
                <thead>
                    <tr class="bg-light">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>IP</th>
                        <th>User Agent</th>
                        <th>Created at</th>
                        <th>Updated at</th>
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
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('.Datatable').DataTable({
            scrollResize: true,
					scrollX: true,
					scrollY: 250,
					scrollCollapse: true,
// 					paging: false,
// 					lengthChange: false
            processing: true,
            serverSide: true,
            ajax: "/admin/admin-user/datatable/ssd",
            columns: [
                {
                    data: "name",
                    name: "name",
                },
                {
                    data: "email",
                    name: "email",
                },
                {
                    data: "phone",
                    name: "phone"
                },
                {
                    data: "ip",
                    name: "ip"
                },
                {
                    data: "user_agent",
                    name: "user_agent",
                    searchable: false,
                    sortable: false
                },
                {
                    data: "created_at",
                    name: "created_at"
                },
                {
                    data: "updated_at",
                    name: "updated_at"
                },
                {
                    data: "action",
                    name: "action",
                    searchable: false,
                    sortable: false
                },
            ],
            order: [
                [ 6, "desc" ]
            ],
            columnDefs: [{
                targets: "no-sort",
                sortable: false,
               
            }]
        });

        $(document).on('click', '.delete', function(e){
            e.preventDefault();

            var id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure, you want to delete?',
                showCancelButton: true,
                confirmButtonText: `Confirm`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : '/admin/admin-user/' + id,
                        type : 'DELETE',
                        success: function(){
                            table.ajax.reload();
                        }
                    });
                }
            })
        });
    } );

</script>
@endsection
