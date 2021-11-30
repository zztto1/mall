@extends("layout.layout_main")

@section('nav')
  @include('layout.nav', ['category' => 'question'])
@endsection

@section('css')
    <link rel="stylesheet" href="/css/question_write.css">
@endsection

@section('contents')
  <div class="contents">
    <div class="page-nav-wrapper">
      <div class="page-nav">
        HOME > <span>견적문의</span>
      </div>
    </div>

    <div class="contents-header">
      견적문의 수정
    </div>

    <div class="contents-body">
      <form action="/question/{{$question->id}}" method="post" onsubmit="return formcheck();">
        @method('PUT')
        @csrf
        <div class="contents-content">
          <table>
            <tr>
              <th>제목 <span class="need">*</span></th>
              <td>
                <input type="text" oninput="return check_input(this);" class="form-control-sm form-control" name="title" value="{{$question->title}}" placeholder="제목을 입력해주세요.">
              </td>
            </tr>
            <tr>
              <th>문의내용 <span class="need">*</span></th>
              <td>
                <textarea name="content" rows="8" oninput="return check_input(this);" class="form-control-sm form-control" placeholder="문의내용을 입력해주세요.">{{$question->contents}}</textarea>
              </td>
            </tr>
          </table>
        </div>
        <div class="contents-btn-layout">
          <div class="contents-btn" id="submit">수정 완료</div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript">
    function formcheck() {ㄴ
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
