@extends('layout1.index')

@section('content')
<div id="content">

    @include('parts.messages')

    <div class="sep">
        <h4>{{ $homeTitle }}<span>>></span> </h4>
    </div>
    @foreach($posts as $post)
    <div class="tobic">
        <h2>
            <a id='home_{{ $post->id }}' href="{{ EasyURL::post($post) }}" title="{{ $post->getTitle() }}">
                {{ $post->getTitle() }}
            </a>
        </h2>
        <span class="datetime">Posted on {{ $post->getPostedAt('d M Y at H:i') }}</span>
        &nbsp-&nbsp
        <span class="difficulty">Difficulty : <span class="{{ $post->getDifficulty() }}"> {{ $post->getDifficulty() }} </font></span>

        <div class="clr"></div>
        <div class="tobic_info">
            <a href="{{ EasyURL::post($post) }}" id="imghome_{{ $post->id }}">
                @if($mainImage = $post->mainImage)
                <img class="mainImg" alt="{{ $post->getTitle() }}" src="{{ $mainImage->getNearest(150, 150)->getUrl() }}" />
                @endif
            </a>
            <p class="home_p">{{ $post->getDescription() }}</p>
        </div>
        <div class="clr"></div>

        <div class="more_div">
            <a id="morehome_{{ $post->id }}" href="{{ EasyURL::post($post) }}" class="more">READ MORE</a>
        </div>
        <div class="clr"></div>
    </div>
    <hr />
    @endforeach

    <div class="pages">
        {{ $posts->links() }}
    </div>

</div><!-- END of content -->
@stop