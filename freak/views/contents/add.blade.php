@extends('models.master')

@section('body')
<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title"><i class="icon-resize-horizontal"></i> Content form</span>
        </div>
        <div class="widget-content form-container">
            
            <form action="#" method="POST" enctype="multipart/form-data" id="mainForm">

                <div class="control-group">
                    <label class="control-label">Content title</label>
                    <div class="controls">
                        <input type="text" name="Content[title]" value="{{ $content->title }}" class="span12" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Content body</label>
                    <div class="controls">
                        <textarea id="cleditor" name="Content[description]">{{ $content->description }}</textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Choose place to put this content in</label>
                    <div class="controls">
                        <select name="Content[place]">
                            <option value="">Select place</option>
                            @foreach($places as $place)
                                @if($edit && ($myPlace = $content->places()->first()) && $myPlace->id == $place->id)
                                <option value="{{ $place->id }}" selected>{{ $place->name }}</option>
                                @else
                                <option value="{{ $place->id }}">{{ $place->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Choose page this content will link to</label>
                    <div class="controls">
                        <select name="Content[page]">
                            <option value="">Select page</option>
                            @foreach($pages as $page)
                                @if($edit && $myPlace && $myPlace->page && $myPlace->page->id == $page->id)
                                <option value="{{ $page->id }}" selected>{{ $page->title }}</option>
                                @else
                                <option value="{{ $page->id }}">{{ $page->title }}</option>
                                @endif
                            @endforeach
                        </select>
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
        $( '#cleditor').cleditor({ width: '100%' });
        
        var html = new HtmlHandler($("#mainForm"));
        var control_unit = new ControlUnit( [ 'validate', 'save_in_db' ], html, {{ $content->id ? $content->id : 0 }} );

        control_unit.requestUrls( '{{ URL::route("request-urls", "Content") }}' );
        html.addListener( control_unit );
    });

</script>
@stop