

@extends('layouts.fblayout')

@section('main')
    @include('layouts.navigation')
<div class="container mt-4">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-bordered user_datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Submited By</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Up Vote</th>
                        <th>Down Vote</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(function () {
      var table = $('.user_datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('feedback.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'user', name: 'submitedid',searchable:true},
              {data: 'title', name: 'title'},
              {data: 'category_id', name: 'cateogry'},
              {data: 'upvotes', name: 'vote'},
              {data: 'downvotes', name: 'vote'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
  </script>
@endsection
