<div class="gallery">
    @if($image = $service->getMainImage())
        <h4>Main image</h4>
        <img src="{{ $image->getSmallest()->url }}"/>
    @endif
</div>

<div class="clear" style="height:60px;"></div>

<h4>Gallery images</h4>
@if($service->gallery)
<div class="gallery">
    <ul>
        @foreach($service->gallery->images as $image)
            @if($url = $image->getSmallest()->url)
            <li>
                    <span class="thumbnail">
                        <img alt="" src="{{ $url }}">
                    </span>
                    <span class="actions">
                        <a href="{{ $image->getLargest()->url }}" rel="prettyPhoto[nature]"><i class="icon-search"></i></a>
                        <a href="{{ URL::route('delete-image', $image->id) }}"><i class="icon-remove"></i></a>
                    </span>
            </li>
            @endif
        @endforeach
    </ul>
</div>
@endif