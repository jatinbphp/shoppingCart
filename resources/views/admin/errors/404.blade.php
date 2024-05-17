@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row pt-5">
            <div class="col-8 offset-2">
                <div class="card card-info card-outline">
                    <div class="card-body table-responsive">
                        <h2 class="headline text-warning">
                            404
                        </h2>
                        <div class="error-content">
                            <h3>
                                <i class="fas fa-exclamation-triangle text-warning">
                                </i>
                                Oops! Page not found.
                            </h3>
                            <p>
                                We could not find the page you were looking for. Meanwhile, you may
                                <a href="{{route('admin.dashboard')}}">
                                    return to dashboard
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection