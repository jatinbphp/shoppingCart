@php
    $menuIsAvailableForFooter = false;
@endphp

@auth
    @if(count(get_categories_by_ids(5))>0)
        @foreach(get_categories_by_ids(5) as $categoryFooter)
            <li>
                <a href="{{ route('products.filter', ['category_id' => $categoryFooter->id, 'category_name' => $categoryFooter->slug]) }}">
                    {{ $categoryFooter->name }}
                </a>

                @if($categoryFooter->children)
                    <ul class="nav-dropdown nav-submenu">
                        @foreach($categoryFooter->children as $subCategory)
                            <li>
                                <a href="{{ route('products.filter', ['category_id' => $subCategory->id, 'category_name' => $categoryFooter->slug, 'sub_category_name' => $subCategory->slug]) }}">
                                    {{ $subCategory->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach

        @php $menuIsAvailableForFooter = true; @endphp
    @endif
@endauth

@if(!$menuIsAvailableForFooter)
    @if(!empty(getFooterCategoriesMenu()))
        @foreach(getFooterCategoriesMenu() as $keyMenu => $valueMenu)
            <li>
                <a href="{{ route('products.filter', ['category_id' => ($valueMenu->id ?? null), 'category_name' => $valueMenu->slug]) }}">{{$valueMenu->name}}</a>
            </li>
        @endforeach
    @endif
@endif