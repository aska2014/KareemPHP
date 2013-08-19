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
    @yield('content')
</div>

</body>
</html>
