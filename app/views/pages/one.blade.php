@extends('layout1.index')

@section('content')
<div id="content">

    @include('parts.messages')

    <div class="main_tobic">
        <!--        <div class="fb-like fb_edge_widget_with_comment fb_iframe_widget" data-send="true" data-width="450" data-show-faces="true" fb-xfbml-state="rendered"><span style="height: 29px; width: 450px;"><iframe id="f3144f4798" name="f3270be1a" scrolling="no" title="Like this content on Facebook." class="fb_ltr" src="http://www.facebook.com/plugins/like.php?api_key=273308966107997&amp;locale=en_US&amp;sdk=joey&amp;channel_url=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter.php%3Fversion%3D24%23cb%3Df24a717b8%26origin%3Dhttp%253A%252F%252Flocalhost%252Ff30d722c3c%26domain%3Dlocalhost%26relation%3Dparent.parent&amp;href=http%3A%2F%2Flocalhost%2FBlogging_website.com%2Ftutorial%2FThis-is-the-title-1-53.html&amp;node_type=link&amp;width=450&amp;layout=standard&amp;colorscheme=light&amp;show_faces=true&amp;send=true&amp;extended_social_context=false" style="border: none; overflow: hidden; height: 29px; width: 450px;"></iframe></span></div>-->

        {{ $page->description }}

        <div class="clr"></div>

        <br>
        <div class="fb-like fb_edge_widget_with_comment fb_iframe_widget" data-send="true" data-width="450" data-show-faces="true" fb-xfbml-state="rendered"><span style="height: 29px; width: 450px;"><iframe id="f22dac9638" name="f21ad81018" scrolling="no" title="Like this content on Facebook." class="fb_ltr" src="http://www.facebook.com/plugins/like.php?api_key=273308966107997&amp;locale=en_US&amp;sdk=joey&amp;channel_url=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter.php%3Fversion%3D24%23cb%3Df2351a7f0c%26origin%3Dhttp%253A%252F%252Flocalhost%252Ff30d722c3c%26domain%3Dlocalhost%26relation%3Dparent.parent&amp;href=http%3A%2F%2Flocalhost%2FBlogging_website.com%2Ftutorial%2FThis-is-the-title-1-53.html&amp;node_type=link&amp;width=450&amp;layout=standard&amp;colorscheme=light&amp;show_faces=true&amp;send=true&amp;extended_social_context=false" style="border: none; overflow: hidden; height: 29px; width: 450px;"></iframe></span></div>
        <div class="clr"></div>
    </div>


</div><!-- END of content -->
@stop