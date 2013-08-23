@extends('layout1.index')

@section('content')
<div id="content">

    @include('parts.messages')

    <div class="main_tobic">
        <span class="datetime">Written by <a href="{{ URL::to('about-me.html') }}">kareem mohamed</a> on 20 Jan 2013. You can find him on <a rel="author" href="https://plus.google.com/u/0/112390694177730751935?rel=author">Google+</a></span>
        <h1>{{ $mainPost->title }}</h1>

        @include('parts.facebook_like')

        @if($mainPost->download || $mainPost->demo)
        <div class="download">
            @if($download = $mainPost->download)
            <a href="{{ EasyURL::download($download) }}" target="_blank" class="download">Download Source Files</a>
            @endif
            @if($demo = $mainPost->demo)
            <a href="{{ $demo->getLink() }}" target="_blank" class="download">View It Online</a>
            @endif
        </div>
        @endif

        <div class="clr"></div>

        {{ $postPage[0]->getReadyBody() }}

        <div class="clr"></div>

        <div class="tutorial_pages">
            {{ $postPage->links() }}
        </div>

        <br />
        @include('parts.facebook_like')
        <div class="clr"></div>
        <br />

        @if(! $relatedPosts->isEmpty())
        <div id="related_tobics">
            <h3>Related tutorials you may like</h3>
            <ul>
                @foreach($relatedPosts as $post)
                <li><a id="related_{{ $post->id }}" href="{{ EasyURL::post($post) }}" title="{{ $post->getTitle() }}">{{ $post->getTitle() }}</a><br></li>
                @endforeach
            </ul>
        </div>
        @endif

        <!--
        <div id="social">
            <div id="share"></div>
            <ul class="sharing-cl" id="s_text">
                <li><a class="sh-google" href="">Google</a></li>
                <li><a class="sh-tweet" href="">twitter</a></li>
                <li><a class="sh-face" href="">facebook</a></li>
            </ul>
        </div> -->
    </div>


</div><!-- END of content -->



<div id="tobic_comments" style="margin:0px;">
    <div id="comments" style="">
        <div class="comments_title">Comments <a class="scroll" href="#theAddComment">Add comment?</a></div>

        @if($postComments->isEmpty())
        <div class="comments_title">No Comments</div>
        @endif

        @foreach($postComments as $comment)
        <div id="comment{{ $comment->id }}" class="comment">
            @if($image = $comment->user->getProfileImage())
            <img src="{{ $image->getSmallest()->url }}" />
            @else
            <img src="@todo:: Default image" />
            @endif
            <div class="comment_info">
                <div class="name"><span>{{ $comment->user->getName() }}</span> says:</div>
                <span class="datetime">{{ $comment->getCreatedAt('Y-m-d H:i:s') }}</span>
                <div class="c_body">{{ $comment->getDescription() }}</div>
                <div class="grey"></div>
            </div>
            <div class="clr"></div>
            @foreach($comment->getAcceptedReplies() as $reply)
                <div id="reply_comment{{ $reply->id }}" class="reply_comment">
                    @if($image = $reply->user->getProfileImage())
                        <img src="{{ $image->getSmallest()->url }}" />
                    @else
                        <img src="@todo:: Default image" />
                    @endif
                    <div class="comment_info">
                        <div class="name"><span>{{ $reply->user->getName() }}</span> replays:</div>
                        <span class="datetime">{{ $reply->getCreatedAt('Y-m-d H:i:s') }}</span>
                        <div class="c_body">{{ $reply->getDescription() }}</div>
                    </div>
                </div>
                <div class="clr"></div>
            @endforeach
        </div>
        @endforeach
    </div>

    <div id="theAddComment">
        <div id="addCommentTitle" class="comments_title">Add Comment</div>
        <div id="addComment">

            <form action="" method="POST" class="forms" id="commentForm">
                <div class="c_row"><input type="text" class="txt" name="User[name]" id="comment_name" /><span>Name* </span></div>
                <div class="c_row"><input type="text" class="txt" name="User[email]" id="comment_email" /><span>Email* </span></div>
<!--                <input type="hidden" name="comment_email" id="comment_email" value='' /></span>-->
<!--                <input type="hidden" name="comment_img" id="comment_img" value="https://graph.facebook.com/picture" />-->
<!--                <input type="hidden" name="comment_name" id="comment_name" value="" />-->
                <div class="c_row"><textarea onfocus="if(this.value == 'Add your comment...')this.value ='';" onblur="if(this.value=='')this.value ='Add your comment...';" name="Comment[description]" class="txtarea" id="comment_body">Add your comment...</textarea></div>
                <input type="submit" class="sbmt" style="background:#333" value="Add Comment" />
                <div id="comment_error"></div>
                <div id="comment_success"></div>
            </form>
        </div>
    </div>

</div>
@stop

@section('scripts')
<script type="text/javascript">

$(document).ready(function()
{
    var options = {
        beforeSubmit:  showRequest,
        success:       showResponse,

        dataType:  'json',
        clearForm: true
    };

    // bind form using 'ajaxForm'
    $('#commentForm').ajaxForm(options);

    $(".comment").hover(
        function()
        {
            var reply_id = $(this).attr('id').replace('comment','');
            $(this).find('.grey').html('<a class="scroll" href="#addCommentTitle" onclick="replyComment(' + reply_id + ');">Reply</a>');
            makeAScroll();
        },
        function()
        {
            $(this).find('.grey').html('');
        }
    );

    SyntaxHighlighter.all();
});

function showRequest(formData, jqForm, options)
{
    var name = $("#comment_name").val();
    var body = $("#comment_body").val();
    var email = $("#comment_email").val();

    var stringReg = new RegExp(/^[a-zA-Z ]*$/i);
    var emailReg = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

    if(body == '' || name == '' || email == '')
    {
        showCommentErrors('Please make sure you entered all fields')
        return false;
    }

    if(name.length > 30 || (!emailReg.test(email) && email != ''))
    {
        showCommentErrors('Please make sure you entered a valid name and/or valid email address')
        return false;
    }

    $("#commentForm").fadeTo(200,'0.2');
    $("#commentForm > .sbmt").attr('disabled','disabled');

    return true;
}

function showResponse(responseText, statusText, xhr, $form)
{
    if(responseText.message.indexOf('error') > -1)
    {
        showCommentErrors(responseText.body);
    }
    else
    {
        showCommentSuccess(responseText.body);
    }

    $("#commentForm").fadeTo(500,'1');
    $("#commentForm > .sbmt").removeAttr('disabled');
}


function showCommentErrors( errors )
{
    $("#comment_error").html(getTextFromBody(errors)).slideDown('fast').delay(5000).slideUp('slow');
}

function showCommentSuccess( success )
{
    $("#comment_success").html(getTextFromBody(success)).slideDown('fast').delay(5000).slideUp('slow');
}


function getTextFromBody( body )
{
    if(body instanceof Array)

        return body.join("<br />");

    return body;
}


function replyComment(commentID)
{
    var commentName = $("#comment" + commentID + " > .comment_info > .name > span").html();
    if($("#reply_row").length > 0)
    {
        $("#reply_row > span").html('Replay to ' + commentName);
        $("#reply_id").val(commentID);
    }
    else
    {
        $("#commentForm").prepend('<div class="c_row" id="reply_row"><span style="color:#666">Reply to ' + commentName + '</span></div>');
        $("#commentForm").append('<input type="hidden" name="Comment[parent_id]" id="reply_id" value = "' + commentID + '" />');
    }
}

</script>
@stop