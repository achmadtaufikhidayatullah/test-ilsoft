@extends('layout.template')


@section('header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
        </div>

        <div class="col-sm-6 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahdata">Add User</button>
        </div>
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection


@section('content')
<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Last Seen</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
        $nomor = 1;
        @endphp
        @foreach ($user as $data)
        <tr>
            <td>{{ $nomor }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->email }}</td>
            <td>
                @if ($data->last_seen != null)
                {{ Carbon\Carbon::parse($data->last_seen)->diffForHumans() }}
                @else
                -
                @endif
            </td>
            <td>
                @if(Cache::has('is_online' . $data->id))
                <span class="text-success">Online</span>
                @else
                <span class="text-secondary">Offline</span>
                @endif
            </td>
            <td>
                <div class="btn-group">
                    <a href="#!" class="btn btn-success btn-sm ubah-data float-left" data-toggle="modal"
                        data-target="#editdata" data-id="{{ $data->id }}" data-name="{{ $data->name }}"
                        data-email="{{ $data->email }}"><i class="far fa-edit"></i>
                    </a>
                    <form action="{{ route('user.destroy' , $data->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm ml-2 delete" style="margin-right: 5px;"><i class="far fa-trash-alt"></i></button>
                    </form>
                    {{-- <a href="{{ route('user.destroy' , $data->id) }}" class="btn btn-danger btn-sm ml-2 delete" style="margin-right: 5px;" onclick="return confirm('Are you sure to delete this user ?');"><i class="far fa-trash-alt"></i></a> --}}
                </div>
            </td>
        </tr>
        @php
        $nomor++;
        @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Last Seen</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>




<!-- Modal Tambah-->
<div class="modal fade bd-example-modal-lg" id="tambahdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tabahdatalabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- FORM -->
                <form action="{{ route('user.store') }}" method="post">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="User Name" name="name" required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="User Email" name="email"
                            required>
                    </div>


                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" aria-label="password"
                                aria-describedby="pass-eye" id="password" name="password">
                            <div class="input-group-append">
                                <a class="input-group-text btn btn-primary text-white" id="pass-eye">
                                    <i class="far fa-eye-slash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        </form>
        <!-- /FORM -->
    </div>
</div>
<!-- End Modal Tambah-->


<!-- Modal edit-->
<div class="modal fade bd-example-modal-lg" id="editdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tabahdatalabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- FORM -->
                <form id="edit-form" action="{{ route('user.update' , '') }}" method="post">
                    @method('PUT')
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="edit-name" placeholder="User Name" name="name"
                            required>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="edit-email" placeholder="User Email" name="email"
                            required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
            <!-- /FORM -->
        </div>
    </div>
</div>
<!-- End Modal Tambah-->
@endsection

@push('bottom')
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    $('.ubah-data').on('click', function () {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var action = $('#editdata #edit-form').attr('action');
        action += '/' + id;
        // console.log(id_anggota);
        $('#editdata #edit-form').attr('action', action);
        $('#editdata #edit-name').val(name);
        $('#editdata #edit-email').val(email);

    });

    $('#pass-eye').on('click', function () {
        var input = $("#password");
        if (input.attr("type") === "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    })

</script>
@endpush
