@extends("layout.layout_main")

@section('nav')
  @include('layout.nav', ['category' => 'question'])
@endsection

@section('css')
    <link rel="stylesheet" href="/css/question_detail.css">
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
      <div class="contents-title">
        {{$question->title}}
      </div>
      <div class="contents-info">
        <div><small style="padding-right: 7px;"><i class="fas fa-pen"></i></small>{{$question->user}} ({{preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/","\\1-\\2-\\3" ,$question->phone)}})</div>
        <div class="float-right"><small style="padding-right: 7px;"><i class="fas fa-eye"></i></small>{{$question->view}}</div>
        <div class="float-right" style="padding-right: 30px;">
          <small style="padding-right: 7px"><i class="fas fa-clock"></i></small>
          {{date('Y.m.d H:i', strtotime($question->created_at))}}
        </div>
      </div>
      <div class="contents-content" style="white-space:pre-line;">{!! $question->contents !!}</div>
      <div class="contents-btn-layout">

        @if (!isset(auth()->user()->id))
          <div class="contents-btn" onclick="$('#del_form').submit();">삭제</div>
          <div class="contents-btn" onclick="location.href='/question/{{$question->id}}/edit';">수정</div>
        @endif
      </div>

      @if (count($comment) > 0)
        <div class="comment-header">댓글 <span class="cnt">+ {{count($comment)}}</span></div>
      @endif

      <div class="comment-layout">
        @foreach ($comment as $key => $value)
          <div class="comment @if ($value->user == "관리자") active @endif">
            @if ($value->user == "관리자")
              <div class="comment-user">
                <small style="font-size: 11px;"><i class="fas fa-shield-alt"></i></small>
                {{$value->user}}
              </div>
            @else
              <div class="comment-user">{{$value->user}}</div>
            @endif
            <textarea class="comment-body" readonly>{!!$value->contents!!}</textarea>
            <div class="comment-setting">
              @if ($value->user != "관리자" || isset(auth()->user()->id))
                <button type="button" name="button" onclick="comDel({{$value->id}});">삭제</button>
              @endif

              <small style="padding-right: 3px"><i class="fas fa-clock"></i></small>
              {{date('Y.m.d  H:i', strtotime($value->created_at))}}
            </div>
          </div>
        @endforeach

        <div class="comment-write-form">
          <div class="comment-write-header">댓글 작성</div>
          <div class="comment-write-layout">
            <form id="comment" action="/comment" method="post">
              @csrf
              <input type="hidden" name="question_id" value="{{$question->id}}">
              <textarea name="comment" class="comment-write" rows="5"></textarea>
              <div class="comment-write-btn" id="comment_btn">등록</div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



  @if (!isset(auth()->user()->id))
    <form action="/question/{{$question->id}}" method="post" id="del_form" onsubmit="return formCheck();">
      @method('delete')
      @csrf
    </form>
  @endif

  <form action="/comment/del" method="post" id="comment_del">
    @csrf
    <input type="hidden" name="question_id" value="{{$question->id}}">
    <input type="hidden" name="comment_id" value="">
  </form>

@endsection

@section('js')
  <script type="text/javascript">
    $(document).ready(function() {
      $("body").on("keyup", ".comment-body", function(e) {
        $(this).css("height", "auto");
        $(this).height(this.scrollHeight);
      });
      $("body").find(".comment-body").keyup();
    })

    $("#comment_btn").click(function() {
      $("#comment").submit();
    })

    function comDel(id) {
      var con = confirm("해당 댓글을 삭제하시겠습니까?");

      if(con){
        $("input[name=comment_id]").val(id);
        $("#comment_del").submit();
      }
    }

    function formCheck() {
      var con = confirm("해당 게시글을 삭제하시겠습니까?");
      if(!con) return false;
    }
  </script>
@endsection
