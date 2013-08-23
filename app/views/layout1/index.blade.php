<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">

    <meta name="description" content="{{ $metaDescription }}" />
    <meta name="keywords" content="{{ $metaKeywords }}" />

    <title>{{ $pageTitle }}</title>

    {{ Asset::styles() }}

</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div id="bgContainer">
    <div id="Container">

        @include('layout1.header')

        <div class="clr"></div>

        <div id="body">

            @include('layout1.rightpanel')

            @yield('content')

            <div class="clr"></div>

            @include('layout1.footer')

        </div><!-- END of body -->
        <div class="clr"></div>
    </div><!-- END of container -->
</div><!-- END of bgContainer -->

<div id="copyright">
    Copyright © 2013 kareemPhp.com · All Rights Reserved - Powered by
    <A id="copyright_services" href="{{ URL::route('services') }}">kareemPhp</a>
</div>

@if(in_array('scroll_top', $mainParts))
    @include('parts.scroll_top')
@endif

@if(in_array('modal', $mainParts))
    @include('parts.modal')
@endif

@include('parts.php_javascript');

{{ Asset::scripts() }}

@yield('scripts')

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-29205808-3', 'kareemphp.com');
    ga('send', 'pageview');

</script>
</body>
</html>
