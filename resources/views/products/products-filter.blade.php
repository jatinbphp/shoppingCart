<style>
    [type="checkbox"]:checked, [type="checkbox"]:not(:checked) {
        position: absolute;    left: -9999px;
    }
</style>
<div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-xl-0">
    <div class="search-sidebar sm-sidebar border">
        <div class="search-sidebar-body">
            @if (!empty($filter_categories))
                <div class="single_search_boxed d-none d-lg-block">
                    <div class="widget-boxed-header px-3">
                        <h4 class="mt-3">Categories</h4>
                    </div>
                    <div class="widget-boxed-body">
                        <div class="side-list no-border">
                            <div class="filter-card" id="shop-categories">
                                @foreach ($filter_categories as $key => $category)
                                    <div class="single_filter_card mb-2">
                                        <h5><a onclick="setCategory(event)" href="#{{$category->slug}}" data-id="{{ $category->id }}" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">{{ $category->name ?? "-" }}<i class="accordion-indicator ti-angle-down"></i></a></h5>
                                        <div class="collapse {{ request()->is('category/*/' . $category->slug . '/*') ? 'show' : '' }}" id="{{$category->slug}}" data-parent="#shop-categories">
                                            <div class="card-body">
                                                <div class="inner_widget_link">
                                                    <ul>
                                                        @if (isset($category->children) && !empty($category->children))
                                                            @foreach ($category->children as $subKey => $subCategory)
                                                                <li>
                                                                    <a class="sub-category category-{{ $category->id }}" data-category="{{ $subCategory->id }}" href="javascript:void(0)" onclick="setSubCategory(event)">
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
                            </div>
                        </div>
                    </div>
                </div>
            @endif

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

            @if(!empty(getProductSizesForFilter()))
                <div class="single_search_boxed">
                    <div class="widget-boxed-header">
                        <h4><a href="#size" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Size</a></h4>
                    </div>
                    <div class="widget-boxed-body collapse" id="size" data-parent="#size">
                        <div class="side-list no-border">
                            <div class="single_filter_card">
                                <div class="card-body pt-0">
                                    <div class="text-left pb-0 pt-2">
                                        @foreach(getProductSizesForFilter() as $key => $value)
                                            <div class="form-check form-option form-check-inline mb-2">
                                                {!! Form::checkbox('sizes[]', $value ?? null, false, ['class' => 'form-check-input product-size', 'id' => 'size-' . $value, 'onchange' => 'setSize(event)']) !!}
                                                <label class="form-option-label" for="{{ 'size-' . $value }}">{{ $value }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>