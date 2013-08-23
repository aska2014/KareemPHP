@extends('layout1.index')

@section('content')
<div id="content">

    @include('parts.messages')

    <div class="main_tobic">
        <h1>Get your website Designed, Developed, Published and at the first pages of Google search engine</h1>

        @include('parts.facebook_like')

        <p>
            We are a group of developers, designers and marketers ready to create your idea with the lowest costs and minimum time
            <a href="#contact">Contact Us</a>.<br />
            Bellow are the latest websites we created
        </p>
        <ul class="gallery clearfix">
            @foreach($services as $service)
            @if($image = $service->getMainImage())
            <li>
                <a href="{{ EasyURL::service($service) }}">
                    <img src="{{ $image->getSmallest()->url }}" width="200" height="124">
                </a>
            </li>
            @endif
            @endforeach
        </ul>
        <div class="clr"></div>
        <h3>We promise to</h3>
        <p>
        </p><ol>
            <li>Design an attractive or simple looking website depending on your request.</li>
            <li>Build a high performance website.</li>
            <li>Include a control panel to customize all the content in the website and the design if needed.</li>
            <li>Make a very secure website.</li>
            <li>Optimize the website for search engines (SEO).</li>
            <li>Deploy the website, attract visitors and rank well for Google.</li>
        </ol>
        <p></p>

        <h3 id="contact">Contact Us</h3>
        @include('contact_us.form')

    </div>

</div>
@stop