@extends('models.master')

@section('body')
<div class="uploader">
    <div class="rightBtn"></div>

    <form action="{{ URL::action('PostPageController@upload', 0) }}" method="POST" id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="normal-image" />
        <input type="submit" value="U"/>
    </form>
</div>

<div class="uploader" style="bottom:200px;" id="addCodeDialog">
    <div class="rightBtn"></div>

    <div style="width:400px; height:400px; display:none">
        <br />
        <textarea id="myModel_txt" cols="50" rows="20" style="width:350px; height:300px;"></textarea><br />
        <select id="myModel_slct">
            <option value="php">php</option>
            <option value="css">css</option>
            <option value="js">js</option>
            <option value="sql">sql</option>
        </select><br />
        <input type="button" value="Add code" onclick="javascript:addCode($('#myModel_slct').val(), false)"/>
    </div>
</div>

<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title"><i class="icon-resize-horizontal"></i> PostPage form</span>
            @if($postpage->exists)
            <div class="toolbar">
                <div class="btn-group">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-pencil"></i> Action <i class="caret"></i>
                    </span>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ URL::to('model/PostPage/'.$postpage->id.'/delete') }}"><i class="icol-cross"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
        <div class="widget-content form-container">

            @if(! $postpage->exists)
            <form action="{{ URL::action('PostPageController@store') }}" method="POST" enctype="multipart/form-data" id="mainForm">
            @else
            <form action="{{ URL::action('PostPageController@update', $postpage->id) }}" method="POST" enctype="multipart/form-data" id="mainForm">
            @endif

                <div class="control-group">
                    <label class="control-label" for="Title">Page number</label>
                    <div class="controls">
                        <input name="PostPage[order]" value="{{ $postpage->getOrder() }}" type="text" class="span3">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="Title">Post</label>
                    <div class="controls">
                        <select name="PostPage[post_id]" class="span5">
                            <option value="0">None</option>
                            @foreach($posts as $post)
                                @if(Input::get('post') == $post->id || $postpage->post_id == $post->id)
                                <option value="{{ $post->id }}" selected="selected">{{ $post->title }}</option>
                                @else
                                <option value="{{ $post->id }}">{{ $post->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @if(($post_id = Input::get('post')) || ($post_id = $postpage->post_id))
                    <p class="help-block"><a href="{{ URL::action('PostController@edit', $post_id) }}">Go to post</a></p>
                    @endif
                </div>

                <div class="control-group">
                    <label class="control-label" for="editor">Body</label>
                    <div class="controls">
                        <textarea name="PostPage[body]" id="editor1">{{ $postpage->body }}</textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Save changes</button>
                    <button type="reset" class="btn">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>
@stop

@section('scripts')
<style type="text/css">
    .uploader{position: fixed; bottom:30px; right:0px; z-index: 5555555000; background:#FFF; border:1px solid #BBB;}
    #uploadForm{display:none;}
    .rightBtn{padding:10px; background:#333; cursor: pointer}
</style>

<script type="text/javascript">
    $(document).ready(function()
    {
        $(".rightBtn").click(function(){
            var elem = $(this).next();
            if(elem.is(":visible")) elem.hide();
            else elem.show();
        });

        $("#uploadForm").ajaxForm({
            success: copyToClipboard
        });

        // Replace the <textarea id="editor1"> with an CKEditor instance.
        CKEDITOR.replace( 'editor1', {
            allowedContent: true
        });
    });

    function copyToClipboard (text) {
        window.prompt ("Copy to clipboard: Ctrl+C, Enter", text);
    }

    function getEditor()
    {
        return CKEDITOR.instances.editor1;
    }

    function closeAddCodeDialog()
    {
        $("#addCodeDialog").find('.rightBtn').trigger('click');
    }

    function insertHTML( html ) {
        // Get the editor instance that we want to interact with.
        var editor = getEditor();

        console.log(html);

        // Check the active editing mode.
        if ( editor.mode == 'wysiwyg' )
        {
            // Insert HTML code.
            editor.insertHtml( html );
        }
        else
            alert( 'You must be in WYSIWYG mode!' );
    }

    function addCode(type,set)
    {
        var mytxt = htmlEncode($("#myModel_txt").val());

        if(type == "js")
            insertHTML('<pre class="brush:js;">' + mytxt + '</pre><br />');
        else if(type == "php")
            insertHTML('<pre class="brush:php;">' + mytxt + '</pre><br />');
        else if(type == "xml")
            insertHTML('<pre class="brush:xml;">' + mytxt +  '</pre><br />');
        else if(type == "sql")
            insertHTML('<pre class="brush:sql;">' + mytxt + '</pre><br />');
        else if(type == "css")
            insertHTML('<pre class="brush:css;">' + mytxt + '</pre><br />');

        SyntaxHighlighter.highlight();

        closeAddCodeDialog();
    }

    function htmlEncode(value){
        return $('<div/>').text(value).html();
    }

    SyntaxHighlighter.all();

</script>
@stop