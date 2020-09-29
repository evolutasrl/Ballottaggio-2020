@if (request('sort-field') != $field)
    <a href="{{ Request::fullUrlWithQuery(['sort-field' => $field, 'sort-direction' => 'asc']) }}">
        {{$label}} <i class="fas fa-sort"></i></a>
@else
    @if (request('sort-direction', null) == 'asc' || !request('sort-direction', null))
        <a href="{{ Request::fullUrlWithQuery(['sort-field'  => $field, 'sort-direction' => 'desc']) }}">{{$label}} <i
                class="fas fa-sort-down"></i></a>
    @else
        <a href="{{ Request::fullUrlWithQuery(['sort-field'  => $field, 'sort-direction' => 'asc']) }}">{{$label}} <i
                class="fas fa-sort-up"></i></a>
    @endif
@endif

