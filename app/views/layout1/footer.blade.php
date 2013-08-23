<div id="footer">
    <div id="top_footer">
        <div class="box">
            <div>
                <h4>About blogger</h4>
                <p>Hi, I’m Kareem Mohamed, I am a back-end web developer and this is my personal
                    blog. In this blog I will post tutorials about web design and development <a href="{{ URL::to('about-me.html') }}" id="footer_about">more about me</a>.</p>
            </div>
        </div>
        <div class="box">
            <div>
                <h4>Services</h4>
                <p>Have an idea? Get it developed, published and visible to search engines now. <a id="footer_services" href="{{ URL::route('services') }}">CLICK HERE</a>.</p>
            </div>
        </div>
        <div class="box" style="width:160px;">
            <h4>Links</h4>
            <ul>
<!--                <li><a id="footer_advertise" href="http://localhost/Blogging_website.com/advertise-with-us.html"><div class="arrow"></div>Advertise With Us</a></li>-->
                <!-- <li><a id="footer_donate" href="<=base_url('donate.html');?>"><div class="arrow"></div>Share Love</a></li> -->
                <li><a id="footer_privacy" href="{{ URL::to('privacy-policy.html') }}"><div class="arrow"></div>Privacy Policy</a></li>
                <li><a id="footer_suggestions" href="{{ URL::route('services') }}#contact"><div class="arrow"></div>Suggestions</a></li>
            </ul>
        </div>
    </div>
    <div class="clr"></div>
</div><!-- END of footer