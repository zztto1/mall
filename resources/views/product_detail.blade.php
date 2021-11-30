@extends("layout.layout_main")

@section('nav')
  @if ($category->tag == null)
    @include('layout.nav', ['category' => $category->id])
  @else
    @include('layout.nav', ['category' => $category->tag])
  @endif
@endsection

@section('css')
    <link rel="stylesheet" href="/css/product_detail.css">
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
      @if (isset(auth()->user()->id))
        <div class="contents-btn-layout">
          <div class="contents-btn-delete" onclick="btnDelete();">삭제</div>
          <div class="contents-btn" onclick="location.href='/product/{{$product->id}}/edit'">수정</div>
        </div>
      @endif
      <div class="product-info-layout">
        <div class="product-header-img">
          <div class="product-header-img-select">
            <img class="product_img_selected" src="{{$product->header_img_1}}" alt="">
          </div>
          <div class="product-header-img-list">
            @if ($product->header_img_1)
              <div class="product_img_list_layout selected">
                <img class="product_img_list" src="{{$product->header_img_1}}" alt="">
              </div>
            @endif
            @if ($product->header_img_2)
              <div class="product_img_list_layout">
                <img class="product_img_list" src="{{$product->header_img_2}}" alt="">
              </div>
            @endif
            @if ($product->header_img_3)
              <div class="product_img_list_layout">
                <img class="product_img_list" src="{{$product->header_img_3}}" alt="">
              </div>
            @endif
          </div>
        </div>
        <div class="product-info">
          <div class="product-name">
            {{$product->product_name}}
          </div>
          <div class="product-price">
            주문제작
          </div>

          @if (isset($product->product_code))
            <div class="product-info-detail">
              <div class="product-label">상품번호</div>
              <div class="product-txt">{{$product->product_code}}</div>
            </div>
          @endif

          @if (isset($product->product_size))
            <div class="product-info-detail">
              <div class="product-label">사이즈</div>
              <div class="product-txt">{{$product->product_size}}</div>
            </div>
          @endif

          @if (isset($product->product_desc))
            <div class="product-info-detail">
              <div class="product-label">상품설명</div>
              <div class="product-txt">{{$product->product_desc}}</div>
            </div>
          @endif
        </div>
      </div>

      <div class="product-detail-layout">
        <div class="product-detail-btn">상품 상세정보</div>
        <div class="product-detail-contents">
          {!! $product->contents !!}
        </div>
      </div>

    </div>
  </div>


  @if (isset(auth()->user()->id))
    <form action="/product/{{$product->id}}" method="post" id="del_form">
      @method('delete')
      @csrf
    </form>
  @endif

@endsection

@section('js')
  <script type="text/javascript">
    $(".product_img_list_layout").mouseenter(function(e){
      var target = e.currentTarget;

      $(".product_img_list_layout").removeClass("selected");
      $(target).addClass("selected");

      var src = $(target).children('img').attr('src');
      $(".product_img_selected").attr("src", src);
    })

    function btnDelete(id){
      var con = confirm("해당 상품을 삭제하시겠습니까?");

      if(con){
        $("#del_form").submit();
      }
    }
  </script>
@endsection
