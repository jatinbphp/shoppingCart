@extends('layouts.app')
@section('content')
@include('common.breadcrumb', ['breadcrumbs' => ['Home', 'Pages', "FAQ's"]])
<section class="middle">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">FAQ's Section</h2>
                    <h3 class="ft-bold pt-3">Frequently Asked Questions</h3>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-10 col-lg-11 col-md-12 col-sm-12">
                <div class="d-block position-relative border rounded py-3 px-3 mb-4">
                    <h4 class="ft-medium">Orders:</h4>
                    <div id="accordion" class="accordion">
                        <div class="card">
                            <div class="card-header" id="h1">
                                <h5 class="mb-0">
                                    {!! Html::tag('button', 'Can I track my order item?', [
                                        'class' => 'btn btn-link',
                                        'data-toggle' => 'collapse',
                                        'data-target' => '#ord1',
                                        'aria-expanded' => 'true',
                                        'aria-controls' => 'ord1'
                                    ]) !!}
                                </h5>
                            </div>
                            <div id="ord1" class="collapse show" aria-labelledby="h1" data-parent="#accordion">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="h2">
                                <h5 class="mb-0">
                                    {!! Html::tag('button', 'Who pays for return postage?', [
                                        'class' => 'btn btn-link collapsed',
                                        'data-toggle' => 'collapse',
                                        'data-target' => '#ord2',
                                        'aria-expanded' => 'false',
                                        'aria-controls' => 'ord2'
                                    ]) !!}
                                </h5>
                            </div>
                            <div id="ord2" class="collapse" aria-labelledby="h2" data-parent="#accordion">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="h3">
                                <h5 class="mb-0">
                                    {!! Html::tag('button', 'How do I apply a promotional code?', [
                                        'class' => 'btn btn-link collapsed',
                                        'data-toggle' => 'collapse',
                                        'data-target' => '#ord3',
                                        'aria-expanded' => 'false',
                                        'aria-controls' => 'ord3'
                                    ]) !!}
                                </h5>
                            </div>
                            <div id="ord3" class="collapse" aria-labelledby="h3" data-parent="#accordion">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-block position-relative border rounded py-3 px-3 mb-4">
                    <h4 class="ft-medium">Shipping & Returns:</h4>
                    <div id="accordion1" class="accordion">
                        <div class="card">
                            <div class="card-header" id="h4">
                                <h5 class="mb-0">
                                    {!! Html::tag('button', 'How long does it take for home delivery?', [
                                        'class' => 'btn btn-link',
                                        'data-toggle' => 'collapse',
                                        'data-target' => '#ord4',
                                        'aria-expanded' => 'true',
                                        'aria-controls' => 'ord4'
                                    ]) !!}
                                </h5>
                            </div>
                            <div id="ord4" class="collapse show" aria-labelledby="h4" data-parent="#accordion1">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="h5">
                                <h5 class="mb-0">
                                    {!! Html::tag('button', 'What courier do you use for deliveries?', [
                                        'class' => 'btn btn-link collapsed',
                                        'data-toggle' => 'collapse',
                                        'data-target' => '#ord5',
                                        'aria-expanded' => 'false',
                                        'aria-controls' => 'ord5'
                                    ]) !!}
                                </h5>
                            </div>
                            <div id="ord5" class="collapse" aria-labelledby="h5" data-parent="#accordion1">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="h6">
                                <h5 class="mb-0">
                                    {!! Html::tag('button', 'Can I collect from a local store?', [
                                        'class' => 'btn btn-link collapsed',
                                        'data-toggle' => 'collapse',
                                        'data-target' => '#ord6',
                                        'aria-expanded' => 'false',
                                        'aria-controls' => 'ord6'
                                    ]) !!}
                                </h5>
                            </div>
                            <div id="ord6" class="collapse" aria-labelledby="h6" data-parent="#accordion1">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-block position-relative border rounded py-3 px-3">
                    <h4 class="ft-medium">Payment:</h4>
                    <div id="accordion2" class="accordion">
                        <div class="card">
                            <div class="card-header" id="h7">
                                <h5 class="mb-0">
                                    {!! Html::tag('button', 'Do you offer a VAT discount to non EU customers?', [
                                        'class' => 'btn btn-link',
                                        'data-toggle' => 'collapse',
                                        'data-target' => '#ord7',
                                        'aria-expanded' => 'true',
                                        'aria-controls' => 'ord7'
                                    ]) !!}

                                </h5>
                            </div>
                            <div id="ord7" class="collapse show" aria-labelledby="h7" data-parent="#accordion2">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="h8">
                                <h5 class="mb-0">
                                    {!! Html::tag('button', 'Why have you not refunded the original delivery charge?', [
                                        'class' => 'btn btn-link collapsed',
                                        'data-toggle' => 'collapse',
                                        'data-target' => '#ord8',
                                        'aria-expanded' => 'false',
                                        'aria-controls' => 'ord8'
                                    ]) !!}

                                </h5>
                            </div>
                            <div id="ord8" class="collapse" aria-labelledby="h8" data-parent="#accordion2">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="h9">
                                <h5 class="mb-0">
                                    {!! Html::tag('button', 'Do you offer a VAT discount to non EU customers?', [
                                        'class' => 'btn btn-link collapsed',
                                        'data-toggle' => 'collapse',
                                        'data-target' => '#ord9',
                                        'aria-expanded' => 'false',
                                        'aria-controls' => 'ord9'
                                    ]) !!}
                                </h5>
                            </div>
                            <div id="ord9" class="collapse" aria-labelledby="h9" data-parent="#accordion2">
                                <div class="card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection