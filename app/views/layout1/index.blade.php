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
    Copyright © 2012 JustDevelopWebsites.com · All Rights Reserved - Powered by
    <A id="copyright_services" href="#">JustDevelopWebsites</a>
</div>

@if(in_array('scroll_top', $mainParts))
    @include('parts.scroll_top')
@endif

@if(in_array('modal', $mainParts))
    @include('parts.modal')
@endif

@include('parts.php_javascript');

{{ Asset::scripts() }}

</body>
</html>
