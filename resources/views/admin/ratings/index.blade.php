@extends('admin.layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ratings</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card px-2 px-md-4 py-2 py-md-4">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap table-bordered" id="rating-table">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>Product</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Rated by</th>
                                <th width="100">Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Setup CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize DataTable
            var table = $('#rating-table').DataTable({
                "processing": true,
                "serverSide": true,
                "deferRender": true,
                "ordering": false,
                searchDelay: 2000,
                "ajax": {
                    url: "{{ route('admin.ratings') }}",
                    type: 'GET',
                    dataType: 'JSON'
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'product', // Should match the returned key in the backend
                        name: 'product.title'
                    },
                    {
                        data: 'rating',
                        name: 'rating'
                    },
                    {
                        data: 'comment',
                        name: 'comment'
                    },
                    {
                        data: 'username', // Assuming you store the name of the user as 'username'
                        name: 'username'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return `<i class="far fa-circle-check text-success toggle-status" data-id="${row.id}" style="cursor:pointer"></i>`;
                            } else {
                                return `<i class="far fa-circle-xmark text-danger toggle-status" data-id="${row.id}" style="cursor:pointer"></i>`;
                            }
                        }
                    },

                ],
                "lengthMenu": [
                    [10, 20, 50, -1],
                    [10, 20, 50, "All"]
                ],
                "pagingType": "simple_numbers"
            });


            // Handle status toggle
            $('#rating-table').on('click', '.toggle-status', function() {
                let ratingId = $(this).data('id');

                // Show confirmation alert
                if (confirm("Are you sure you want to change the status?")) {
                    $.ajax({
                        url: "{{ route('ratings.toggle-status') }}",
                        type: 'POST',
                        data: {
                            id: ratingId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                toastify().success(response.message);
                                table.ajax.reload(); // Reload DataTable to reflect the change
                            } else {
                                toastify().error('Failed to update status.');
                            }
                        },
                        error: function(xhr) {
                            toastify().error(`${xhr.responseJSON.message}`);
                        }
                    });
                }
            });
        });
    </script>
@endpush
