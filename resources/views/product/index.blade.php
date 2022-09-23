@extends('layout.template')


@section('header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
        </div>

        <div class="col-sm-6 text-right">
            <button class="btn btn-primary">Tambah User</button>
        </div>
    </div><!-- /.row -->
</div><!-- /.container-fluid -->
@endsection


@section('content')
<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Nick Name</th>
            <th>Url</th>
        </tr>
    </thead>
    <tbody>
       @foreach ($data as $data)
        <tr>
            <td>{{ $data['name'] }}</td>
            <td>{{ $data['nickname'] }}</td>
            <td>{{ $data['url'] }}</td>
         </tr>
         @endforeach
    </tbody>
    <tfoot>
        <th>Name</th>
        <th>Nick Name</th>
        <th>Url</th>
    </tfoot>
</table>
@endsection

@push('bottom')
<script>
    $(function () {
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

</script>
@endpush
