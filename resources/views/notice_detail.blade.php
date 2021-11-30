@extends("layout.layout_main")

@section('nav')
  @include('layout.nav', ['category' => 'notice'])
@endsection

@section('css')
    <link rel="stylesheet" href="/css/notice_detail.css">
@endsection

@section('contents')
  <div class="contents">
    <div class="page-nav-wrapper">
      <div class="page-nav">
        HOME > <span>공지사항</span>
      </div>
    </div>

    <div class="contents-header">
      공지사항
    </div>

    <div class="contents-body">
      <div class="contents-title">
        {{$notice->title}}
      </div>
      <div class="contents-info">
        <div>
          <small style="padding-right: 7px;"><i class="fas fa-shield-alt"></i></small>관리자
        </div>
        <div class="float-right"><small style="padding-right: 7px;"><i class="fas fa-eye"></i></small>{{$notice->view}}</div>
        <div class="float-right" style="padding-right: 30px;">
          <small style="padding-right: 7px"><i class="fas fa-clock"></i></small>
          {{date('Y.m.d H:i', strtotime($notice->created_at))}}
        </div>
      </div>
      <div class="contents-content">
        {!! $notice->contents !!}
      </div>

      @if (auth()->user())
        <div class="contents-btn-layout">
          <div class="contents-btn" onclick="noticeDelete();">삭제</div>
          <div class="contents-btn" onclick="location.href='/notice/{{$notice->id}}/edit';">수정</div>
        </div>
      @endif
    </div>
  </div>


  <form action="/notice/{{$notice->id}}" method="post" id="del_form">
    @method('delete')
    @csrf
  </form>
@endsection

@section('js')
  <script type="text/javascript">
    function noticeDelete(){
      var con = confirm("해당 공지사항을 삭제하시겠습니까?");

      if(con) $("#del_form").submit();
    }
  </script>
@endsection
