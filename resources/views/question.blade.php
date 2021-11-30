@extends("layout.layout_main")

@section('nav')
  @include('layout.nav', ['category' => 'question'])
@endsection

@section('css')
    <link rel="stylesheet" href="/css/question.css">
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

      @if (count($question) == 0)
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
        @if (!isset(auth()->user()->id))
          <div class="contents-btn-layout">
            <div class="contents-btn" onclick="location.href='/question/create'">글쓰기</div>
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
            @foreach ($question as $idx => $value)
              <tr>
                <td>{{$question->total() - ($question->perPage() * ( $question->currentPage() - 1 )) - $idx }}</td>
                <td class="text-left cursor-pointer" onclick="location.href='/question/{{$value->id}}'">
                  <i class="fas fa-lock" style="font-size: 13px; padding-right: 5px;"></i>
                  {{$value->title}}
                  @if ($value->cnt > 0)
                    <span class="comment">+{{$value->cnt}}</span>
                  @endif
                </td>
                <td>{{$value->user}}</td>
                <td>{{date('Y.m.d', strtotime($value->created_at))}}</td>
                <td>{{$value->view}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        @if (!isset(auth()->user()->id))
          <div class="contents-btn-layout">
            <div class="contents-btn" onclick="location.href='/question/create'">글쓰기</div>
          </div>
        @endif
        {{ $question->withQueryString()->links() }}
      @endif

    </div>
  </div>
@endsection

@section('js')
@endsection
