<div id="header">
    <div id="bottom">
        <a href="{{ URL::route('home') }}" id="logo_link" title="@kareemphp"><div id="logo"></div></a>
    </div>
    <div id="languages">
    </div>
</div><!-- END of header -->
<div class="clr"></div>

<div id="menu">
    <ul>
        <li{{ EasyRoute::is('home')     ? ' class="active"' : '' }}><a id="menu_home" href="{{ URL::route('home') }}">Home</a></li>
        <li{{ EasyRoute::is('services') ? ' class="active"' : '' }}><a id="menu_services" href="{{ URL::route('services') }}">Services</a></li>
        @foreach($menuPages as $page)
        <li{{ EasyRoute::is($page->slug)? ' class="active"' : '' }}><a id="menu_services" href="{{ URL::to($page->slug) }}">{{ $page->title }}</a></li>
        @endforeach
    </ul>
    <div id="search">
        <form action="{{ URL::route('search') }}" method="get">
            <input type="submit" class="smbt" VALUE="" />
            <input type="text" class="txt" id="search_txt" value="Search tutorials..." onfocus="if(this.value == 'Search tutorials...')this.value = '';" onblur="if(this.value == '')this.value = 'Search tutorials...';" name="keyword" />
        </form>
    </div>
</div>