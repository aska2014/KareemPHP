@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title"><i class="icon-resize-horizontal"></i> Service form</span>
        </div>
        <div class="widget-content form-container">
            
            <form action="{{ URL::action('ServiceController@store') }}" method="POST" enctype="multipart/form-data" id="mainForm">

                <div class="control-group">
                    <label class="control-label" for="Title">Title</label>
                    <div class="controls">
                        <input type="text" id="input00" name="Service[title]" class="span12" value="{{ $service->title }}">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="Title">Description</label>
                    <div class="controls">
                        <textarea name="Service[description]" id="cleditor">{{ $service->description }}</textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Main image</label>
                    <div class="controls">
                        <input type="file" name="main-image">
                    </div>
                </div>

                <fieldset id="input_cloning" class="sheepit-form">
                    <legend>
                        Service Images
                        <span id="input_cloning_controls" class="pull-right">
                            <span class="btn btn-mini" id="input_cloning_add"><i class="icon-plus"></i></span>
                        </span>
                    </legend>
                    <div id="input_cloning_template" class="control-group">
                        <div class="controls">
                            <input type="file" id="img1[0]" name="gallery-images[#index#]">
                        </div>
                        <span class="close" id="input_cloning_remove_current">&times;</span>
                    </div>
                    <div id="input_cloning_noforms_template" class="control-group">
                        <p class="help-block">Add a new answer by clicking the (+) button above</p>
                    </div>
                </fieldset>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Save changes</button>
                    <button type="reset" class="btn">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>
@include('services.gallery')
@stop

@section('scripts')
<script type="text/javascript">

    $(document).ready(function()
    {
        $('#input_cloning').sheepIt({
            separator: ''
        });
        $('#cleditor').cleditor({ width: '100%', height:500 });

        var html = new HtmlHandler($("#mainForm"));
        var control_unit = new ControlUnit( [ 'validate', 'save_in_db', 'upload_images' ], html, {{ $service->id ? $service->id : 0 }} );

        control_unit.requestUrls( '{{ URL::route("request-urls", "Service") }}' );
        html.addListener( control_unit );
    });

</script>
@stop