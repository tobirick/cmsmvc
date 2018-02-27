<ul class="pagination">
    @if($currentpage > 1)
        <li class="pagination__item pagination__item--previous"><a href="{{getURL()}}?p={{$currentpage - 1}}" class="pagination__item-link">Previous</a></li>
    @endif
    @for($i = 1; $i <= $numberofpages; $i++)
        <li class="pagination__item {{$i == $currentpage ? 'active' : ''}}"><a href="{{getURL()}}?p={{$i}}" class="pagination__item-link">{{$i}}</a></li>
    @endfor
    @if($currentpage < $numberofpages)
        <li class="pagination__item pagination__item--next"><a href="{{getURL()}}?p={{$currentpage + 1}}" class="pagination__item-link">Next</a></li>
    @endif
</ul>