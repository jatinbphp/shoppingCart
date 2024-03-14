<style>
    [type="checkbox"]:checked, [type="checkbox"]:not(:checked) {
        position: absolute;    left: -9999px;
    }
</style>
<div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-xl-0">
    <div class="search-sidebar sm-sidebar border">
        <div class="search-sidebar-body">
            <div class="single_search_boxed d-none d-lg-block">
                <div class="widget-boxed-header px-3">
                    <h4 class="mt-3">Categories</h4>
                </div>
                <div class="widget-boxed-body">
                    <div class="side-list no-border">
                        <div class="filter-card" id="shop-categories">
                            {{-- category section --}}
                            @if (isset($categories) && !empty($categories))
                                @foreach ($categories as $key => $category)
                                    <div class="single_filter_card">
                                        <h5><a href="#{{ strtolower($category->name ?? "") }}" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">{{ $category->name ?? "-" }}<i class="accordion-indicator ti-angle-down"></i></a></h5>
                                        <div class="collapse {{ request()->is('category/*/' . strtolower($category->name) . '/*') ? 'show' : '' }}" id="{{ strtolower($category->name ?? '') }}" data-parent="#shop-categories">
                                            <div class="card-body">
                                                <div class="inner_widget_link">
                                                    <ul>
                                                        @if (isset($category->children) && !empty($category->children))
                                                            @foreach ($category->children as $subKey => $subCategory)
                                                                @if (count($subCategory->products ?? []) == 0)
                                                                    @continue
                                                                @endif
                                                                <li>
                                                                    <a href="{{ route('products.filter', ['category_id' => ($subCategory->id ?? null), 'category_name' => strtolower($category->name), 'sub_category_name' => strtolower(str_replace(" ", "-", ($subCategory->name ?? '')))]) }}">
                                                                        {{ $subCategory->name ?? "-" }}
                                                                        <span>{{ count($subCategory->products ?? []) }}</span>
                                                                    </a>
                                                                </li>
                                                            @endforeach    
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            {{-- category section --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_search_boxed">
                <div class="widget-boxed-header">
                    <h4><a href="#pricing" data-toggle="collapse" aria-expanded="false" role="button">Pricing</a></h4>
                </div>
                <div class="widget-boxed-body collapse show" id="pricing" data-parent="#pricing">
                    <div class="side-list no-border mb-4">
                        <div class="rg-slider">
                            <input type="text" class="js-range-slider" name="my_range" category="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_search_boxed">
                <div class="widget-boxed-header">
                    <h4><a href="#size" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Size</a></h4>
                </div>
                <div class="widget-boxed-body collapse" id="size" data-parent="#size">
                    <div class="side-list no-border">
                        <div class="single_filter_card">
                            <div class="card-body pt-0">
                                <div class="text-left pb-0 pt-2">
                                    @if(isset($sizes) && !empty($sizes))
                                        {!! Form::open(['url' => route('products'), 'id' => 'product-filter-form', 'class' => 'form-horizontal']) !!}
                                            @foreach($sizes as $key => $value)
                                                <div class="form-check form-option form-check-inline mb-2">
                                                    {!! Form::checkbox('sizes[]', $value ?? null, false, ['class' => 'form-check-input', 'id' => 'size-' . $value, 'onchange' => 'handleProductFilter()']) !!}
                                                    <label class="form-option-label" for="{{ 'size-' . $value }}">{{ $value }}</label>
                                                </div>
                                            @endforeach
                                        {!! Form::close() !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- <div class="single_search_boxed">
                <div class="widget-boxed-header">
                    <h4><a href="#colors" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Colors</a></h4>
                </div>
                <div class="widget-boxed-body collapse" id="colors" data-parent="#colors">
                    <div class="side-list no-border">
                        <div class="single_filter_card">
                            <div class="card-body pt-0">
                                <div class="text-left">
                                    @if(isset($colors) && !empty($colors))
                                        @foreach($colors as $key => $value)
                                            <div class="form-check form-option form-check-inline mb-1">
                                                {!! Form::checkbox('colors', $value ?? null, false, ['class' => 'form-check-input', 'id' => $value]) !!}
                                                <label class="form-option-label rounded-circle" for="{{ $value }}"><span class="form-option-color rounded-circle" style="background: {{ $value }};"></span></label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>