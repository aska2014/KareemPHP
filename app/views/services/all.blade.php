@extends('layout1.index')

@section('content')
<div id="content">

    @include('parts.messages')

    <div class="main_tobic">
        <h1>Get your website Designed, Developed, Managed and At the first pages of Google search engine</h1>
        <p>
            We are a highly qualified expert web development team including creative designers, developers and internet marketers, we have built many websites, these are the latest ones:<br>
        </p>
        <ul class="gallery clearfix">
            @foreach($services as $service)
            @if($image = $service->getMainImage())
            <li>
                <a href="{{ EasyURL::service($service) }}">
                    <img src="{{ $image->getSmallest()->url }}" width="200" height="150">
                </a>
            </li>
            @endif
            @endforeach
        </ul>
        <div class="clr"></div>
        <p>
            To see our projects working <a class="scroll" href="#contact" style="color:#009">please contact us</a>.
        </p><br>
        <h3>We promise to</h3>
        <p>
        </p><ol>
            <li>Design a very attractive looking website.</li>
            <li>Build a high performance website.</li>
            <li>Include a control panel to customize all the content in the website and the design if needed.</li>
            <li>Make a very secure website.</li>
            <li>Optimize the website for search engines.</li>
            <li>Deploy the website, attract visitors and rank well for Google.</li>
        </ol>
        <p></p>

        <h3 id="contact">Contact us</h3>
        @include('contact_us.form')

    </div>

</div>
@stop