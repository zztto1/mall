<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}

        <title>내음</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">
        <!-- 부트스트랩 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>

        <link rel="stylesheet" href="/css/common.css">

        @yield('css')

    </head>
    <body>
      <div class="wrapper">
        <header>
          <div class="row">
            <div class="header-left">
              <a href="/">Naeeum</a>
            </div>
            <div class="header-center">
              <!-- Search -->
              <form class="form-inline" action="/search" method="get" onsubmit="return searchForm();">
                <input name="search" oninput="return check_input(this);"class="form-control mr-sm-2" type="text" value="{{isset($_GET['search']) ? $_GET['search'] : ""}}" placeholder="찾으시는 상품을 입력해주세요" autocomplete="off">
                <button class="search-btn" type="submit"><i class="fas fa-search"></i></button>
              </form>
            </div>
            <div class="header-right">
              @if (!isset(auth()->user()->id))
                <div class="" onclick="location.href='/login';">
                    <i class="fas fa-sign-in-alt"></i> 로그인
                </div>
              @else
                <div class="" onclick="location.href='/product/create';">
                    <i class="fas fa-shopping-bag"></i> 상품등록
                </div>
                <div class="" onclick="location.href='/logout';">
                    <i class="fas fa-sign-out-alt"></i> 로그아웃
                </div>
              @endif
            </div>
          </div>
        </header>

        @yield('nav')

        @yield('contents')

        <footer>
          <div class="">
            Copyright @내음  All rights reserved.
          </div>



        </footer>
      </div>
    </body>

    <!-- jQuery -->
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- 부트스트랩 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <script type="text/javascript">
      var msg = '{{Session::get('alert')}}';
      var exist = '{{Session::has('alert')}}';
      if(exist){
        alert(msg);
      }

      function searchForm() {
        var val = $("input[name=search]").val();

        if(val.length < 2){
          alert("검색어를 두글자 이상 입력해주세요.");
          return false;
        }
      }

      function check_input(data){
        var pattern = /[^(ㄱ-힣0-9A-Za-z\s<>?~!@#$%^&/“”＂:.「」\-·_\[\],+\u318D\u119E\u11A2\u2022\u2025a\u00B7\uFE55)]/gi;

        var val = data.value;
        val = val.replace(pattern,"");

        $(data).val(val);
      }

      $('input[type="text"]').keydown(function() {
        if (event.keyCode === 13) {
          event.preventDefault();
        };
      });

    </script>
    @yield('js')
</html>
