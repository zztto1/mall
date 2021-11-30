@extends("layout.layout_main")

@section('nav')
  @include('layout.nav', ['category' => 'product'])
@endsection

@section('css')
    <link rel="stylesheet" href="/css/product_write.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('contents')
  <div class="contents">
    <div class="page-nav-wrapper">
      <div class="page-nav">
        HOME > <span>상품 등록</span>
      </div>
    </div>

    <div class="contents-header">
      상품 등록
    </div>

    <div class="contents-body">
      <form action="/product" method="post" onsubmit="return formcheck();" enctype="multipart/form-data">
        @csrf
        <div class="contents-content">
          <table>
            <tr>
              <th>상품 이름 <span class="need">*</span></th>
              <td>
                <input type="text" oninput="return check_input(this);" class="form-control-sm form-control" name="name" value="" placeholder="(필수) 상품 이름을 입력해주세요.">
              </td>
            </tr>
            <tr>
              <th>상품 카테고리 <span class="need">*</span></th>
              <td>
                <select  class="form-control-sm form-control" name="category" value="">
                  <option value="">(필수) 상품 카테고리를 선택해주세요.</option>
                  @foreach ($category as $key => $value)
                    @if (isset($value->tag))
                      <option value="{{$value->id}}">{{$value->tag." - ".$value->name}}</option>
                    @else
                      <option value="{{$value->id}}">{{$value->name}}</option>
                    @endif
                  @endforeach
                </select>
              </td>
            </tr>
          </table>
          <hr>
          <table>
            <tr>
              <th>상품 메인 이미지 <span class="need">*</span></th>
              <td>
                <input type="file" class="form-control-sm form-control hide" id="header_img_1" name="header_img_1" accept="image/*" placeholder="상품 서브 이미지를 선택해주세요." onchange="fileChange(this);">

                <div class="file_layout" id="header_img_1_layout">
                  <div class="file_btn" onclick="document.getElementById('header_img_1').click();">이미지 업로드</div>

                  <div class="file_name">이미지를 선택해주세요.</div>

                  <div class="product_img_layout"></div>
                </div>
              </td>
            </tr>
            <tr>
              <th>상품 서브 이미지 <br><small>(선택)</small></th>
              <td>
                <input type="file" class="form-control-sm form-control hide" id="header_img_2" name="header_img_2" accept="image/*" placeholder="상품 서브 이미지를 선택해주세요." onchange="fileChange(this);">

                <div class="file_layout" id="header_img_2_layout">
                  <div class="file_btn" onclick="document.getElementById('header_img_2').click();">이미지 업로드</div>

                  <div class="file_name">이미지를 선택해주세요.</div>

                  <div class="product_img_layout"></div>
                </div>
              </td>
            </tr>
            <tr>
              <th>상품 서브 이미지 <br><small>(선택)</small></th>
              <td>
                <input type="file" class="form-control-sm form-control hide" id="header_img_3" name="header_img_3" accept="image/*" placeholder="상품 서브 이미지를 선택해주세요." onchange="fileChange(this);">

                <div class="file_layout" id="header_img_3_layout">
                  <div class="file_btn" onclick="document.getElementById('header_img_3').click();">이미지 업로드</div>

                  <div class="file_name">이미지를 선택해주세요.</div>

                  <div class="product_img_layout"></div>
                </div>
              </td>
          </table>
          <hr>
          <table>
            <tr>
              <th>상품 코드 <br><small>(선택)</small></th>
              <td>
                <input type="text" maxlength="10" oninput="return check_code(this);" class="form-control-sm form-control" name="code" value="" placeholder="(선택) 상품 코드를 입력해주세요. ">
              </td>
            </tr>
            <tr>
              <th>상품 사이즈 <br><small>(선택)</small></th>
              <td>
                <input type="text" maxlength="20"  oninput="return check_size(this);" class="form-control-sm form-control" name="size" value="" placeholder="(선택) 상품 사이즈를 입력해주세요. ">
              </td>
            </tr>
            <tr>
              <th>상품 설명 <br><small>(선택)</small></th>
              <td>
                <input type="text" oninput="return check_input(this);" class="form-control-sm form-control" name="desc" value="" placeholder="(선택) 상품 설명을 입력해주세요. ">
              </td>
            </tr>
          </table>
          <hr>
          <table>
            <tr>
              <th>상품 상세정보 <span class="need">*</span></th>
              <td>
                <textarea id="summernote" name="content" oninput="return check_input(this);" rows="8" class="form-control-sm form-control"></textarea>
              </td>
            </tr>
          </table>
        </div>
        <div class="contents-btn-layout">
          <div class="contents-btn" id="submit">작성 완료</div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-ko-KR.min.js"></script>
  <script type="text/javascript">

    function imgReset(id) {
      $("#"+id).val("");
      $("#"+id+"_layout .file_name").text("이미지를 선택해주세요.");
      $("#"+id+"_layout .product_img_layout").empty();
    }

    function fileChange(e){
      var tar = e.id;
      if(!e.value){
        $("#"+tar+"_layout .file_name").text("이미지를 선택해주세요.");
        $("#"+tar+"_layout .product_img_layout").empty();
      }else{

        $("#"+tar+"_layout .product_img_layout").empty();
        $("#"+tar+"_layout .product_img_layout").append(`
            <img class="product_img" src="">
            <div class="product_img_del" onclick="imgReset('${tar}')">삭제</div>`);

        const reader = new FileReader()
        // 이미지가 로드가 된 경우
        reader.onload = e => {
            $("#"+tar+"_layout .product_img").attr('src', e.target.result);
        }
        // reader가 이미지 읽도록 하기
        if(e.files[0].type.indexOf("image") == -1){
          imgReset(tar);
          alert("이미지 파일만 업로드 할 수 있습니다.");
          return false;
        }else{
          reader.readAsDataURL(e.files[0])
          $("#"+tar+"_layout .file_name").text(e.files[0].name);
        }

      }
    }

    $('#summernote').summernote({
      lang: 'ko-KR',
      tabsize: 2,
      height: 400,
    });

    function formcheck() {
      var name = $("input[name=name]").val();
      var category = $("select[name=category]").val();
      var header_img_1 = $("input[name=header_img_1]").val();
      var title = $("input[name=title]").val();
      var content = $("textarea[name=content]").val();

      if(!name){
        alert("상품 이름을 입력해주세요.");
        $("input[name=name]").focus();
        return false;
      }

      if(!category){
        alert("상품 카테고리를 선택해주세요.");
        $("select[name=category]").focus();
        return false;
      }

      if(!header_img_1){
        alert("상품 메인 이미지를 업로드해주세요.");
        $("input[name=header_img_1]").focus();
        return false;
      }

      if(!content){
        alert("상품 상제정보를 입력해주세요.");
        $("textarea[name=content]").focus();
        return false;
      }
    }

    $("#submit").click(function(){
      $(".contents-body form").submit();
    })

    function check_code(data){
      var pattern = /[^(0-9A-Za-z<>?~!@#$%^&/“”＂:.「」\-·_\[\],+\u318D\u119E\u11A2\u2022\u2025a\u00B7\uFE55)]/gi;

      var val = data.value;
      val = val.replace(pattern,"");

      $(data).val(val);
    }

    function check_size(data){
      // var pattern = /[^(0-9xX)]/gi;
      //
      // var val = data.value;
      // val = val.replace(pattern,"");
      //
      // $(data).val(val);
    }

    function check_num(data){
      var pattern = /[^(0-9)]/gi;

      var val = data.value;
      val = val.replace(pattern,"");

      $(data).val(val);
    }


    function check_input(data){
      var pattern = /[^(ㄱ-힣0-9A-Za-z\s<>?~!@#$%^&/“”＂:.「」\-·_\[\],+\u318D\u119E\u11A2\u2022\u2025a\u00B7\uFE55)]/gi;

      var val = data.value;
      val = val.replace(pattern,"");

      $(data).val(val);
    }
  </script>
@endsection
