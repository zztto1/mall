@extends("layout.layout_main")

@section('nav')
  @include('layout.nav', ['category' => 'notice'])
@endsection

@section('css')
    <link rel="stylesheet" href="/css/notice_write.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('contents')
  <div class="contents">
    <div class="page-nav-wrapper">
      <div class="page-nav">
        HOME > <span>공지사항</span>
      </div>
    </div>

    <div class="contents-header">
      공지사항 작성
    </div>

    <div class="contents-body">
      <form action="/notice" method="post" onsubmit="return formcheck();">
        @csrf
        <div class="contents-content">
          <table>
              <th>제목 <span class="need">*</span></th>
              <td>
                <input type="text" oninput="return check_input(this);" class="form-control-sm form-control" name="title" value="" placeholder="제목을 입력해주세요.">
              </td>
            </tr>
            <tr>
              <th>내용 <span class="need">*</span></th>
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

    $('#summernote').summernote({
      lang: 'ko-KR',
      tabsize: 2,
      height: 400,
    });

    function formcheck() {
      var title = $("input[name=title]").val();
      var content = $("textarea[name=content]").val();

      if(!title){
        alert("제목을 입력해주세요.");
        $("input[name=title]").focus();
        return false;
      }

      if(!content){
        alert("문의내용을 입력해주세요.");
        $("textarea[name=content]").focus();
        return false;
      }
    }

    $("#submit").click(function(){
      $(".contents-body form").submit();
    })



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
