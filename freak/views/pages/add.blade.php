@extends('models.master')

@section('body')
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
                    <label class="control-label">Title</label>
                    <div class="controls">
                        <input name="Page[title]" value="{{ $page->title }}" type="text" id="title" class="span12">
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label">Page description</label>
                    <div class="controls">
                        <textarea id="cleditor" name="Page[description]">{{ $page->description }}</textarea>
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
<script type="text/javascript">

    $(document).ready(function()
    {
        $('#cleditor').cleditor({ width: '100%' });

        var html = new HtmlHandler($("#mainForm"));
        var control_unit = new ControlUnit( [ 'validate', 'save_in_db' ], html, {{ $page->id ? $page->id : 0 }} );

        control_unit.requestUrls( '{{ URL::route("request-urls", "Page") }}' );
        html.addListener( control_unit );
    });

</script>
@stop