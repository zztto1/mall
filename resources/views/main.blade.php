@extends("layout.layout_main")

@section('nav')
  @include('layout.nav')
@endsection

@section('css')
    <!-- 이미지 슬라이더 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

    <link rel="stylesheet" href="/css/main.css">
@endsection

@section('contents')
  <div class="contents">
    <div class="slider">
      @foreach ($banner as $key => $value)
        <div class="">
          <img src="{{$value->img_path}}" alt="">
        </div>
      @endforeach
    </div>

    @if (auth()->user())
      <div class="slider-btn-layout">
        <div class="slider-btn" onclick="location.href='/banner'">배너 수정</div>
      </div>
    @endif

    <div class="product">
      <div class="product-header">
        NEW PRODUCTS
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
      @endif
    </div>

    <div class="map">
      <div class="map-header">
        오시는 길
      </div>

      <div id="daumRoughmapContainer1638111760167" class="root_daum_roughmap root_daum_roughmap_landing"></div>
    </div>


    <!-- 3. 실행 스크립트 -->
    <script charset="UTF-8">
    </script>

  </div>
@endsection

@section('js')
  <!-- 이미지 슬라이더 -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

  <!-- 카카오 지도 -->
  <script charset="UTF-8" class="daum_roughmap_loader_script" src="https://ssl.daumcdn.net/dmaps/map_js_init/roughmapLoader.js"></script>


  <script type="text/javascript">
    $(function () {
      $('.slider').bxSlider({
        auto: true,
        speed: 800,
        pause: 2500,
        autoHover: true,
        pager: false
      });

    	new daum.roughmap.Lander({
    		"timestamp" : "1638111760167",
    		"key" : "288qp",
    		"mapWidth" : "1000",
    		"mapHeight" : "500"
    	}).render();
    })
  </script>
@endsection
