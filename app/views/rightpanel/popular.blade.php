<h2 id="popular_title">Popular Tutorials</h2>
<div id="popular">
    @foreach($popularPosts as $post)
    <div class="section">
        <img src="{{ URL::asset('my_assets/css/images/tutorials_icon.jpg') }}" />
        <div class="info">
            <h2>
                <a href="{{ EasyURL::post($post) }}" title="{{ $post->getTitle() }}">{{ $post->getTitle() }}</a>
            </h2>
            <span class="datetime">{{ $post->getPostedAt('d M Y') }}</span></div>
        <div class="clr"></div>
    </div>
    @endforeach
</div>