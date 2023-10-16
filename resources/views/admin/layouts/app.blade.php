<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
</head>
<body>

{{-- @include('admin.layouts.top-nav') --}}

<main>
    @yield('main')
</main>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="{{ asset('js/jquery.3.6.0.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(function () {
      var table = $('.user_datatable').DataTable({
          processing: true,
        //   serverSide: false,
          ajax: "{{ route('admin.feedback.index') }}",
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
    $(document).on('click', '.delete-record', function() {
    var feedbackId = $(this).data('id');
    var url = $(this).attr('url');
    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {
                // Handle success, e.g., remove the row from the table
                Swal.fire({
            title: data.message,
            // showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Ok',
            // denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                setTimeout(() => {
                    window.location.reload()
                }, 1000);
            }
        })
            },
            error: function (data) {
                table.draw();
                // Handle error, if any
            }
        });
    }
});
$(document).on('click', '.delete-comment', function() {
    var feedbackId = $(this).data('id');
    var url = $(this).attr('url');
    if (confirm('Are you sure you want to delete this commnet?')) {
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {
                // Handle success, e.g., remove the row from the table
                Swal.fire({
            title: data.message,
            // showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Ok',
            // denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                setTimeout(() => {
                    window.location.reload()
                }, 1000);
            }
        })
            },
            error: function (data) {
                // table.draw();
                // Handle error, if any
            }
        });
    }
});

  </script>
</html>
