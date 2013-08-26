<div id="subscribe_title"></div>
<div id="subscribe">
    <div>
        <form action="{{ URL::route('subscribe', 'step1') }}" method="post">
            <input type="text" class="txt" name="Subscribe[email]" value="Your E-mail Address..." onfocus="if(this.value == 'Your E-mail Address...')this.value = '';" onblur="if(this.value == '')this.value = 'Your E-mail Address...';" />
            <input type="submit" class="sbmt" value="" />
            <input type="hidden" name="smsma" value="subscribe" />
        </form>
        <p>Join and get the latest tutorials delivered straight to your inbox.</p>
        <a href="#" id="rss"></a>
        <a href="https://www.facebook.com/JDWebsites" id="facebook"></a>
        <a href="#" id="twitter"></a>
        <div class="clr"></div>
    </div>
</div><!-- END of subscribe -->