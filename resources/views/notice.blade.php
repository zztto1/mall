@extends("layout.layout_main")

@section('nav')
  @include('layout.nav', ['category' => 'notice'])
@endsection

@section('css')
    <link rel="stylesheet" href="/css/notice.css">
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

      @if (count($notice) == 0)
        <table>
          <thead>
            <th width="8%">번호</th>
            <th width="57%">제목</th>
            <th width="10%">작성자</th>
            <th width="15%">날짜</th>
            <th width="10%">조회수</th>
          </thead>
          <tbody>
            <tr>
              <td colspan="5">
                <div class="contents-none">
                    <i class="fas fa-exclamation-triangle"></i>
                    등록된 글이 없습니다.
                </div>
              </td>
              </tr>
          </tbody>
        </table>
        @if (auth()->user())
          <div class="contents-btn-layout">
            <div class="contents-btn" onclick="location.href='/notice/create'">글쓰기</div>
          </div>
        @endif
      @else
        <table>
          <thead>
            <th width="8%">번호</th>
            <th width="57%">제목</th>
            <th width="10%">작성자</th>
            <th width="15%">날짜</th>
            <th width="10%">조회수</th>
          </thead>
          <tbody>
            @foreach ($notice as $idx => $value)
              <tr>
                <td>{{$notice->total() - ($notice->perPage() * ( $notice->currentPage() - 1 )) - $idx }}</td>
                <td class="text-left cursor-pointer" onclick="location.href='/notice/{{$value->id}}'">{{$value->title}}</td>
                <td>
                  <small style="font-size: 11px;"><i class="fas fa-shield-alt"></i></small>
                  관리자
                </td>
                <td>{{date('Y.m.d', strtotime($value->created_at))}}</td>
                <td>{{$value->view}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        @if (auth()->user())
          <div class="contents-btn-layout">
            <div class="contents-btn" onclick="location.href='/notice/create'">글쓰기</div>
          </div>
        @endif
        {{ $notice->withQueryString()->links() }}
      @endif

    </div>
  </div>
@endsection

@section('js')
@endsection
