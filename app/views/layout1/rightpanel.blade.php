<div id="right_panel">

    @if(in_array('subscribe', $rightParts))
        @include('rightpanel.subscribe')
    @endif


    @if(in_array('popular', $rightParts))
        @include('rightpanel.popular')
    @endif


    @if(in_array('archive', $rightParts))
        @include('rightpanel.archive')
    @endif

</div>