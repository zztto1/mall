<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav navbar-dark">

    <li class="nav-item @if(isset($category) && $category == "notice") active @endif">
      <a class="nav-link" href="/notice">공지사항</a>
    </li>

    @php
      $tag = \DB::select('SELECT tag FROM category where status = 0 and tag is not null group by tag');
      $menu = \DB::select('SELECT * FROM category where status = 0');
    @endphp

    @foreach ($tag as $key => $data)
      <li class="nav-item dropdown  @if(isset($category) && $category == $data->tag) active @endif">
        <a class="nav-link dropdown-toggle" href="javascript::;"> {{$data->tag}} </a>
        <div class="dropdown-menu">
          @foreach ($menu as $key => $value)
            @if ($data->tag == $value->tag)
              <a class="dropdown-item" href="/product?category={{$value->id}}"> {{$value->name}} </a>
            @endif
          @endforeach
        </div>
      </li>
    @endforeach

    @foreach ($menu as $key => $value)
      @if ($value->tag == null)
        <li class="nav-item @if(isset($category) && $category == $value->id) active @endif">
          <a class="nav-link" href="/product?category={{$value->id}}">{{$value->name}}</a>
        </li>
      @endif
    @endforeach

    <li class="nav-item @if(isset($category) && $category == "question") active @endif">
      <a class="nav-link" href="/question">견적문의</a>
    </li>

  </ul>
</nav>
