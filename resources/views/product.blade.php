@extends("layout.layout_main")

@section('nav')
  @if ($category->tag == null)
    @include('layout.nav', ['category' => $category->id])
  @else
    @include('layout.nav', ['category' => $category->tag])
  @endif
@endsection

@section('css')
    <link rel="stylesheet" href="/css/product.css">
@endsection

@section('contents')
  <div class="contents">
    <div class="page-nav-wrapper">
      <div class="page-nav">
        @if ($category->tag == null)
          HOME > <span>{{$category->name}}</span>
        @else
          HOME > {{$category->tag}} > <span>{{$category->name}}</span>
        @endif
      </div>
    </div>

    <div class="product">
      <div class="product-header">
        {{$category->name}}
      </div>

      <div class="product-total">
        전체 상품 : <big><b>{{ $product->total() }}</b></big> 개
      </div>

      @if (count($product) == 0)
        <div class="product-none">
            <i class="fas fa-exclamation-triangle"></i>
            등록된 상품이 없습니다.
        </div>
      @else
        <div class="product-list">
          @foreach ($product as $key => $value)
            <div class="product-li">
              <a href="/product/{{$value->id}}">
                <div class="product-img">
                    <img src="{{$value->header_img_1}}">
                </div>
                <div class="product-name">{{$value->product_name}}</div>
              </a>
              <div class="product-text">주문제작</div>
            </div>
          @endforeach
        </div>
        {{ $product->withQueryString()->links() }}
      @endif
    </div>
  </div>
@endsection

@section('js')
@endsection
