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
                                        <div class="collapse {{ request()->is('shop/*/' . strtolower($category->name)) ? 'show' : '' }}" id="{{ strtolower($category->name ?? "-") }}" data-parent="#shop-categories">
                                            <div class="card-body">
                                                <div class="inner_widget_link">
                                                    <ul>
                                                        @if (isset($category->children) && !empty($category->children))
                                                            @foreach ($category->children as $subKey => $subCategory)
                                                                <li>
                                                                    <a href="{{ route('shop.filter', ['category_id' => ($subCategory->id ?? null), 'category_name' => strtolower(str_replace(" ", "-", ($subCategory->name ?? '')))]) }}">
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
                                    <div class="form-check form-option form-check-inline mb-2">
                                        <input class="form-check-input" type="radio" name="sizes" id="26s">
                                        <label class="form-option-label" for="26s">26</label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-2">
                                        <input class="form-check-input" type="radio" name="sizes" id="28s">
                                        <label class="form-option-label" for="28s">28</label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-2">
                                        <input class="form-check-input" type="radio" name="sizes" id="30s" checked>
                                        <label class="form-option-label" for="30s">30</label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-2">
                                        <input class="form-check-input" type="radio" name="sizes" id="32s">
                                        <label class="form-option-label" for="32s">32</label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-2">
                                        <input class="form-check-input" type="radio" name="sizes" id="34s">
                                        <label class="form-option-label" for="34s">34</label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-2">
                                        <input class="form-check-input" type="radio" name="sizes" id="36s">
                                        <label class="form-option-label" for="36s">36</label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-2">
                                        <input class="form-check-input" type="radio" name="sizes" id="38s">
                                        <label class="form-option-label" for="38s">38</label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-2">
                                        <input class="form-check-input" type="radio" name="sizes" id="40s">
                                        <label class="form-option-label" for="40s">40</label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-2">
                                        <input class="form-check-input" type="radio" name="sizes" id="42s">
                                        <label class="form-option-label" for="42s">42</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_search_boxed">
                <div class="widget-boxed-header">
                    <h4><a href="#brands" data-toggle="collapse" aria-expanded="false" role="button">Brands</a></h4>
                </div>
                <div class="widget-boxed-body collapse show" id="brands" data-parent="#brands">
                    <div class="side-list no-border">
                        <div class="single_filter_card">
                            <div class="card-body pt-0">
                                <div class="inner_widget_link">
                                    <ul class="no-ul-list">
                                        <li>
                                            <input id="b1" class="checkbox-custom" name="b1" type="checkbox">
                                            <label for="b1" class="checkbox-custom-label">Sumsung<span>142</span></label>
                                        </li>
                                        <li>
                                            <input id="b2" class="checkbox-custom" name="b2" type="checkbox">
                                            <label for="b2" class="checkbox-custom-label">Apple<span>652</span></label>
                                        </li>
                                        <li>
                                            <input id="b3" class="checkbox-custom" name="b3" type="checkbox">
                                            <label for="b3" class="checkbox-custom-label">Nike<span>232</span></label>
                                        </li>
                                        <li>
                                            <input id="b4" class="checkbox-custom" name="b4" type="checkbox">
                                            <label for="b4" class="checkbox-custom-label">Reebok<span>192</span></label>
                                        </li>
                                        <li>
                                            <input id="b5" class="checkbox-custom" name="b5" type="checkbox">
                                            <label for="b5" class="checkbox-custom-label">Hawai<span>265</span></label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_search_boxed">
                <div class="widget-boxed-header">
                    <h4><a href="#colors" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Colors</a></h4>
                </div>
                <div class="widget-boxed-body collapse" id="colors" data-parent="#colors">
                    <div class="side-list no-border">
                        <div class="single_filter_card">
                            <div class="card-body pt-0">
                                <div class="text-left">
                                    <div class="form-check form-option form-check-inline mb-1">
                                        <input class="form-check-input" type="radio" name="colora8" id="whitea8">
                                        <label class="form-option-label rounded-circle" for="whitea8"><span class="form-option-color rounded-circle blc7"></span></label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-1">
                                        <input class="form-check-input" type="radio" name="colora8" id="bluea8">
                                        <label class="form-option-label rounded-circle" for="bluea8"><span class="form-option-color rounded-circle blc2"></span></label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-1">
                                        <input class="form-check-input" type="radio" name="colora8" id="yellowa8">
                                        <label class="form-option-label rounded-circle" for="yellowa8"><span class="form-option-color rounded-circle blc5"></span></label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-1">
                                        <input class="form-check-input" type="radio" name="colora8" id="pinka8">
                                        <label class="form-option-label rounded-circle" for="pinka8"><span class="form-option-color rounded-circle blc3"></span></label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-1">
                                        <input class="form-check-input" type="radio" name="colora8" id="reda">
                                        <label class="form-option-label rounded-circle" for="reda"><span class="form-option-color rounded-circle blc4"></span></label>
                                    </div>
                                    <div class="form-check form-option form-check-inline mb-1">
                                        <input class="form-check-input" type="radio" name="colora8" id="greena">
                                        <label class="form-option-label rounded-circle" for="greena"><span class="form-option-color rounded-circle blc6"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>