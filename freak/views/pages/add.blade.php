@extends('models.master')

@section('body')
<div class="uploader">
    <div class="rightBtn"></div>

    <form action="{{ URL::action('PostPageController@upload', 0) }}" method="POST" id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="normal-image" />
        <input type="submit" value="U"/>
    </form>
</div>
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title"><i class="icon-resize-horizontal"></i> Page form</span>
        </div>
        <div class="widget-content form-container">
            
            <form action="{{ URL::action('PageController@store') }}" method="POST" enctype="multipart/form-data" id="mainForm">


                <div class="control-group">
                    <label class="control-label" for="Title">Parent page</label>
                    <div class="controls">
                        <select id="parent-slct" name="Page[parent]" class="span5">
                            <option value="">None</div>
                            @foreach($parentPages as $parentPage)
                            @if($page->id != $parentPage->id)
                            <option value="{{ $parentPage->id }}" <? if($page->parent && $page->parent->id == $parentPage->id) echo 'selected="selected"' ?>>{{ $parentPage->title }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <p class="help-block">Used for organizing menu</p>
                </div>

                <div class="control-group">
                    <label class="control-label">Url</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">{{ $baseUrl }}</span><input name="Page[slug]" value="{{ $page->slug }}" type="text" id="english_title" class="span5">
                        </div>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label">Show in menu</label>
                    <div class="controls">
                        @if($page->doesItShowInMenu())
                            Yes<input type="radio" name="Page[show_in_menu]" value="1" checked="checked" />
                            No<input type="radio" name="Page[show_in_menu]" value="0"/>
                        @else
                            Yes<input type="radio" name="Page[show_in_menu]" value="1" />
                            No<input type="radio" name="Page[show_in_menu]" value="0" checked="checked" />
                        @endif
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label">Title</label>
                    <div class="controls">
                        <input name="Page[title]" value="{{ $page->title }}" type="text" id="title" class="span12">
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label">Page description</label>
                    <div class="controls">
                        <textarea id="editor1" name="Page[description]">{{ $page->description }}</textarea>
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
        CKEDITOR.replace( 'editor1', {
            allowedContent: true
        });

        var html = new HtmlHandler($("#mainForm"));
        var control_unit = new ControlUnit( [ 'validate', 'save_in_db' ], html, {{ $page->id ? $page->id : 0 }} );

        control_unit.requestUrls( '{{ URL::route("request-urls", "Page") }}' );
        html.addListener( control_unit );

        $(".rightBtn").click(function(){
            var elem = $(this).next();
            if(elem.is(":visible")) elem.hide();
            else elem.show();
        });

        $("#uploadForm").ajaxForm({
            success: copyToClipboard
        });

        $("#submitBtn").click(function()
        {
            console.log("refreshed");
            refreshCkeditor();
        });
    });

    function copyToClipboard (text) {
        window.prompt ("Copy to clipboard: Ctrl+C, Enter", text);
    }

    function getEditor()
    {
        return CKEDITOR.instances.editor1;
    }

    function refreshCkeditor()
    {
        $('#editor1').val(getEditor().getData());
    }

</script>
@stop