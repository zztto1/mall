@extends("layout.layout_main")

@section('nav')
  @include('layout.nav')
@endsection

@section('css')
    <link rel="stylesheet" href="/css/banner.css">
@endsection

@section('contents')
  <div class="contents">
    <div class="page-nav-wrapper">
      <div class="page-nav">
        HOME > <span>배너 수정</span>
      </div>
    </div>

    <div class="contents-header">
      배너 수정
    </div>

    <div class="contents-body">
      <form action="/banner" method="post" onsubmit="return formcheck();" enctype="multipart/form-data">
        @csrf
        <div class="contents-content">
          <table>
            @if (count($banner) == 0)
              <tr class="banner">
                <th>배너 이미지 1</th>
                <td>
                  <input type="hidden" name="image_id[]" value="0">
                  <input type="hidden" name="image_check[]" value="N">
                  <input type="file" class="form-control-sm form-control hide" name="image[]" accept="image/*" onchange="fileChange(this);">

                  <div class="file_layout">
                    <div class="file_btn" onclick="imgClick(this);">이미지 업로드</div>
                    <div class="file_name">이미지를 선택해주세요.</div>
                    <div class="file_del">
                      <button type="button" class="btn btn-sm btn-danger banner-del" onclick="bannerDel(this);">삭제</button>
                    </div>
                    <div class="product_img_layout"></div>
                  </div>
                </td>
              </tr>
            @else
              @foreach ($banner as $key => $value)
                <tr class="banner">
                  <th>배너 이미지 {{$key+1}}</th>
                  <td>
                    <input type="hidden" name="image_id[]" value="{{$value->id}}">
                    <input type="hidden" name="image_check[]" value="D">
                    <input type="file" class="form-control-sm form-control hide" name="image[]" accept="image/*" onchange="fileChange(this);">

                    <div class="file_layout">
                      <div class="file_btn" onclick="imgClick(this);">이미지 업로드</div>

                      <div class="file_name">{{str_replace("/storage/product/", "", $value->img_path)}}</div>

                      <div class="file_del">
                        <button type="button" class="btn btn-sm btn-danger banner-del" onclick="bannerDel(this);">삭제</button>
                      </div>

                      <div class="product_img_layout">
                        <img class="product_img" src="{{$value->img_path}}">
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            @endif
          </table>
          <div class="banner-append-layout">
            <button type="button" class="btn btn-success banner-append" onclick="bannerAppend();">배너 이미지 추가</button>
          </div>
        </div>
        <div class="contents-btn-layout">
          <div class="contents-btn" id="submit">적용하기</div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript">

    function bannerDel(e){
      if($("input[name='image_id[]']").length <= 1){
        alert("최소 한개의 배너이미지는 존재해야합니다.");
        return false;
      }

      var idx = $(e).parents('.banner').index();

      $(".banner").eq(idx).remove();

      var length = $('.banner').length;

      for (var i = idx; i < length; i++) {
        $(".banner:eq("+i+") th").text("배너 이미지 "+(i+1));
      }
    }

    function bannerAppend(){
      var idx = $(".banner").length + 1;
      var temp = `
        <tr class="banner">
          <th>배너 이미지 ${idx}</th>
          <td>
            <input type="hidden" name="image_id[]" value="0">
            <input type="hidden" name="image_check[]" value="N">
            <input type="file" class="form-control-sm form-control hide" name="image[]" accept="image/*" onchange="fileChange(this);">

            <div class="file_layout">
              <div class="file_btn" onclick="imgClick(this);">이미지 업로드</div>
              <div class="file_name">이미지를 선택해주세요.</div>
              <div class="file_del">
                <button type="button" class="btn btn-sm btn-danger banner-del" onclick="bannerDel(this);">삭제</button>
              </div>
              <div class="product_img_layout"></div>
            </div>
          </td>
        </tr>
      `;

      $("table tbody").append(temp);
    }

    function imgClick(e){
      var idx = $(e).parents('.banner').index();

      $("input[name='image[]']").eq(idx).click();
    }

    function fileChange(e){

      var idx = $(e).parents('.banner').index();


      if(!e.value){
        $("input[name='image_check[]']").eq(idx).val("N");
        $(".banner:eq("+idx+") .file_name").text("이미지를 선택해주세요.");
        $(".banner:eq("+idx+") .product_img_layout").empty();
      }else{
        $("input[name='image_check[]']").eq(idx).val("Y");
        $(".banner:eq("+idx+") .file_name").text(e.value);
        $(".banner:eq("+idx+") .product_img_layout").empty();
        $(".banner:eq("+idx+") .product_img_layout").append(`<img class="product_img" src="">`);


        const reader = new FileReader()
        // 이미지가 로드가 된 경우
        reader.onload = e => {
            $(".banner:eq("+idx+") .product_img").attr('src', e.target.result);
        }
        // reader가 이미지 읽도록 하기
        if(e.files[0].type.indexOf("image") == -1){
          $("input[name='image_check[]']").eq(idx).val("N");
          $(".banner:eq("+idx+") .file_name").text("이미지를 선택해주세요.");
          $(".banner:eq("+idx+") .product_img_layout").empty();
          alert("이미지 파일만 업로드 할 수 있습니다.");
          return false;
        }else{
          reader.readAsDataURL(e.files[0])
          $(".banner:eq("+idx+") .file_name").text(e.files[0].name);
        }
      }
    }

    function formcheck() {

      var length = $('.banner').length;

      for (var i = 0; i < length; i++) {
        var val = $("input[name='image_check[]']").eq(i).val();
        if(val == "N"){
          alert("배너 이미지"+(i+1)+" 를 업로드해주세요.");
          $("input[name='image_check[]']").eq(i).focus();
          return false;
        }
      }
    }

    $("#submit").click(function(){
      $(".contents-body form").submit();
    })
  </script>
@endsection
