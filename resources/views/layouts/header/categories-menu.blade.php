@php
    $menuIsAvailableForHeader = false;
@endphp

@auth
    @if(count(get_categories_by_ids(2))>0)
        @foreach(get_categories_by_ids(2) as $categoryHeader)
            <li>
                <a href="{{ route('products.filter', ['category_id' => $categoryHeader->id, 'category_name' => $categoryHeader->slug]) }}">
                    {{ $categoryHeader->name }}
                </a>

                @if($categoryHeader->children)
                    <ul class="nav-dropdown nav-submenu">
                        @foreach($categoryHeader->children as $subCategory)
                            <li>
                                <a href="{{ route('products.filter', ['category_id' => $subCategory->id, 'category_name' => $categoryHeader->slug, 'sub_category_name' => $subCategory->slug]) }}">
                                    {{ $subCategory->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach

        @php $menuIsAvailableForHeader = true; @endphp
    @endif
@endauth

@if(!$menuIsAvailableForHeader)
    @php
        $defaultCategories = getHeaderCategoriesMenu();
    @endphp

    @foreach($defaultCategories as $categoryHeader)
        <li>
            <a href="{{ route('products.filter', ['category_id' => $categoryHeader->id, 'category_name' => $categoryHeader->slug]) }}">
                {{ $categoryHeader->name }}
            </a>

            @if($categoryHeader->children)
                <ul class="nav-dropdown nav-submenu">
                    @foreach($categoryHeader->children as $subCategory)
                        <li>
                            <a href="{{ route('products.filter', ['category_id' => $subCategory->id, 'category_name' => $categoryHeader->slug, 'sub_category_name' => $subCategory->slug]) }}">
                                {{ $subCategory->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
@endif