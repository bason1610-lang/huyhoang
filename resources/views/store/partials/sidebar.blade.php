<aside class="sidebar-nav" aria-label="Danh mục">
    <h2>Danh mục</h2>
    <ul class="cat-list">
        @foreach($rootCategories as $cat)
            <li class="cat-item">
                <a href="{{ route('category.show', $cat->slug) }}" class="cat-link">
                    {{ $cat->name }}
                    @if($cat->children->isNotEmpty() || $cat->topProducts->isNotEmpty())
                        <span aria-hidden="true">›</span>
                    @endif
                </a>
                
                {{-- Dropdown sản phẩm --}}
                @if($cat->topProducts->isNotEmpty())
                    <div class="cat-dropdown">
                        <div class="cat-products">
                            @foreach($cat->topProducts as $prod)
                                <a href="{{ route('product.show', $prod->slug) }}" class="cat-product-item">
                                    <img src="{{ $prod->imageUrl() }}" alt="{{ $prod->name }}" style="width:50px;height:50px;object-fit:cover;border-radius:0.25rem;">
                                    <div style="flex:1;min-width:0;">
                                        <div style="font-size:0.85rem;font-weight:500;color:#333;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">{{ $prod->name }}</div>
                                        <div style="font-size:0.8rem;color:var(--ak-red);font-weight:600;">{{ \App\Helpers\Price::format($prod->price) }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div style="padding:0.75rem;border-top:1px solid #e5e7eb;text-align:center;">
                            <a href="{{ route('category.show', $cat->slug) }}" style="font-size:0.9rem;color:var(--ak-red);text-decoration:none;font-weight:500;">Xem tất cả →</a>
                        </div>
                    </div>
                @endif

                {{-- Sub categories --}}
                @if($cat->children->isNotEmpty())
                    <ul class="cat-sub">
                        @foreach($cat->children as $child)
                            <li><a href="{{ route('category.show', $child->slug) }}">{{ $child->name }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>

    <style>
        .cat-item {
            position: relative;
        }

        .cat-dropdown {
            display: none;
            position: absolute;
            top: 0;
            left: 100%;
            min-width: 320px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            margin-left: 0.5rem;
            z-index: 10;
        }

        .cat-item:hover .cat-dropdown {
            display: block;
        }

        .cat-products {
            max-height: 400px;
            overflow-y: auto;
            padding: 0.75rem;
        }

        .cat-product-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 0.25rem;
            text-decoration: none;
            color: inherit;
            transition: background 0.2s;
        }

        .cat-product-item:hover {
            background: #f9fafb;
        }
    </style>
</aside>
