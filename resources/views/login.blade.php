@extends("layout.layout_main")

@section('nav')
  @include('layout.nav')
@endsection

@section('css')
    <link rel="stylesheet" href="/css/question_password.css">
@endsection

@section('contents')
  <div class="contents">
    <div class="page-nav-wrapper">
      <div class="page-nav">
        HOME > <span>로그인</span>
      </div>
    </div>

    <div class="contents-header">
      로그인
    </div>

    <div class="contents-body">
      <form action="/login" method="post" onsubmit="return formcheck();">
        @csrf
        <div class="contents-content">
          <table>
            <tr>
              <th>아이디</th>
              <td>
                <input type="text"class="form-control-sm form-control" name="id" value="" placeholder="관리자 아이디를 입력해주세요.">
              </td>
            </tr>
            <tr>
              <th>비밀번호</th>
              <td>
                <input type="password" maxlength="12" class="form-control-sm form-control" name="password" value="" placeholder="관리자 비밀번호를 입력해주세요.">
              </td>
            </tr>
          </table>
          <div class="contents-btn-layout">
            <div class="contents-btn" id="submit">로그인</div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('js')
  <script type="text/javascript">
    var lock = false;
    const csrf = '{{ csrf_token() }}';

    function formcheck() {
      var id = $("input[name=id]").val();
      var password = $("input[name=password]").val();

      if(!id){
        alert("아이디를 입력해주세요.");
        $("input[name=id]").focus();
        return false;
      }

      if(!password){
        alert("비밀번호를 입력해주세요.");
        $("input[name=password]").focus();
        return false;
      }

      if(!lock){
        lock = true;
        $.ajax({
            url: "/login",
            type: "POST",
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            data: {
              id: id,
              pw: password
            },
            success : function(d) {
              const data = d.result;

              if(data == 200){
                location.reload();
              }else{
                alert("아이디 혹은 비밀번호를 확인해주세요.");
              }

              lock = false;
            },
            error: function(e) {
              console.log(e)
              lock = false;
            }
        });
      }
      return false;
    }

    $("#submit").click(function(){
      $(".contents-body form").submit();
    })
  </script>
@endsection
