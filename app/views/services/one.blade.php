@extends('layout1.index')

@section('content')
<div id="content">

    @include('parts.messages')

    <div class="main_tobic">

        <h1>{{ $mainService->title }}</h1>

        @include('parts.facebook_like')

        <div style="margin-left:45px; margin-top:20px;">
            @if($gallery = $mainService->gallery)
                @if($gallery->hasImages())
                <div id="slideshow">
                    <ul>
                        @foreach($gallery->images as $image)
                        <li>
                            <img src="{{ $image->getLargest()->url }}" />
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            @endif
        </div>

        <div class="clr"></div><br />

        {{ $mainService->getDescription() }}

        <div class="clr"></div>

        <br>

        @include('parts.facebook_like')

        <div class="clr"></div>


        <!--
        <div id="social">
            <div id="share"></div>
            <ul class="sharing-cl" id="s_text">
                <li><a class="sh-google" href="">Google</a></li>
                <li><a class="sh-tweet" href="">twitter</a></li>
                <li><a class="sh-face" href="">facebook</a></li>
            </ul>
        </div> -->
    </div>


</div><!-- END of content -->
@stop


@section('scripts')
<script type="text/javascript">

    $(document).ready(function()
    {
        $("#slideshow").craftyslide({
            width: 640,
            height:500
        });
    });

</script>
@stop