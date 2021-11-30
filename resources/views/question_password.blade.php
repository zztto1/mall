@extends("layout.layout_main")

@section('nav')
  @include('layout.nav', ['category' => 'question'])
@endsection

@section('css')
    <link rel="stylesheet" href="/css/question_password.css">
@endsection

@section('contents')
  <div class="contents">
    <div class="page-nav-wrapper">
      <div class="page-nav">
        HOME > <span>견적문의</span>
      </div>
    </div>

    <div class="contents-header">
      견적문의
    </div>

    <div class="contents-body">
      <form action="/password" method="post" onsubmit="return formcheck();">
        @csrf
        <input type="hidden" name="id" value="{{$_GET['id']}}">
        <div class="contents-content">
          이 글은 비밀글입니다. <br>
          비밀번호를 입력하여 주세요.
          <table>
            <tr>
              <th>비밀번호</th>
              <td>
                <input type="password" maxlength="12" class="form-control-sm form-control" name="password" value="">
              </td>
            </tr>
          </table>
          <div class="contents-btn-layout">
            <div class="contents-btn" id="back" onclick="location.href='/question'; ">목록보기</div>
            <div class="contents-btn" id="submit">확인</div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript">
    function formcheck() {
      var password = $("input[name=password]").val();

      if(!password){
        alert("비밀번호를 입력해주세요.");
        $("input[name=password]").focus();
        return false;
      }
    }

    $("#submit").click(function(){
      $(".contents-body form").submit();
    })
  </script>
@endsection
