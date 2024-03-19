@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h3 align="center" style="color: #007bff;">Product Review Page</h3>

        <div class="content-wrapper">
            <!-- Main content -->
            @include('common.error')
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-body table-responsive">
                            <table id="reviewTable" class="table table-bordered table-striped datatable-dynamic">
                                <thead>
                                    <tr>
                                        <th>User Image</th>
                                        <th>User Name</th>
                                        <th>Rating</th>
                                        <th>Description</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jquery')
<script type="text/javascript">
    $(function () {
        var table = $('#reviewTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('review-detail', ['productId' => $productId]) }}",
            columns: [
                { 
                    data: 'user_image', 
                    name: 'user_image',
                    render: function(data, type, row) {
                        return '<img src="' + data + '" width="250" alt="User Image">';
                    },
                    orderable: false,
                },
                { data: 'full_name', name: 'full_name', orderable: true },
                { 
                    data: 'rating', 
                    name: 'rating',
                    render: function(data, type, row) {
                        var stars = '';
                        for (var i = 1; i <= 5; i++) {
                            if (i <= data) {
                                stars += '<i class="fa fa-star text-warning"></i>'; // Full star
                            } else {
                                stars += '<i class="far fa-star text-warning"></i>'; // Empty star
                            }
                        }
                        return stars;
                    }
                },
                { 
                    data: 'description', 
                    name: 'description',
                    render: function(data, type, row) {
                        var truncatedDescription = data.length > 200 ? data.substring(0, 200) + '...' : data;
                        return '<div style="white-space: normal;"><span class="truncated">' + truncatedDescription + '</span><span class="more" style="display: none;">' + data + '</span><button class="btn btn-link btn-sm toggle-more" data-toggle="more">More</button></div>';
                    }
                },
                { data: 'created_at', width: '15%', name: 'created_at' }
            ],
        });
        $(document).on('click', '.toggle-more', function() {
            var $this = $(this);
            var $parent = $this.closest('div');
            var $truncated = $parent.find('.truncated');
            var $more = $parent.find('.more');

            $truncated.toggle();
            $more.toggle();
            $this.text(function(i, text) {
                return text === 'More' ? 'Less' : 'More';
            });
        });
    });
</script>
@endsection
