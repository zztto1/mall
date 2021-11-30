@extends("layout.layout_main")

@section('nav')
  @include('layout.nav')
@endsection

@section('css')
    <link rel="stylesheet" href="/css/search.css">
@endsection

@section('contents')
  <div class="contents">
    <div class="page-nav-wrapper">
      <div class="page-nav">
        HOME > <span>상품 검색</span>
      </div>
    </div>

    <div class="product">
      <div class="product-header">
        상품 검색
      </div>
      <div class="product-search">
        "{{isset($_GET['search']) ? $_GET['search'] : ""}}"
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
  <script type="text/javascript">
  </script>
@endsection
