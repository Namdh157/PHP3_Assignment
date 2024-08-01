<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link {{$curPage <= 1 ? 'disabled':''}}" href="{{$curPath}}&page={{$curPage > 1 ? $curPage - 1 : $curPage}}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        @foreach ($pageArray as $page)
        <li class="page-item {{$curPage == $page ? 'active':''}}">
            <a class="page-link" href="{{$curPath}}&page={{$page}}">{{$page}}</a>
        </li>
        @endforeach

        <li class="page-item">
            <a class="page-link {{$curPage >= $totalPage ? 'disabled':''}}" href="{{$curPath}}&page={{$curPage < $totalPage ? $curPage + 1 : $curPage}}" aria-label="Previous">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>