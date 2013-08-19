@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title"><i class="icon-resize-horizontal"></i> ImageSpecs form</span>
        </div>
        <div class="widget-content form-container">

            <form action="{{ URL::action('ImageSpecsController@update', $imageGroup->id) }}" method="POST" enctype="multipart/form-data" id="mainForm">


                <fieldset id="input_cloning" class="sheepit-form">
                    <legend>
                        Specifications
                        <span id="input_cloning_controls" class="pull-right">
                            <span class="btn btn-mini" id="input_cloning_add"><i class="icon-plus"></i></span>
                        </span>
                    </legend>
                    <div id="input_cloning_template" class="control-group">
                        <div class="controls">
                            <input type="text" name="ImageSpecs[#index#][uri]" id="uri_#index#" class="span12">
                            <input type="text" name="ImageSpecs[#index#][operations]" id="operations_#index#" class="span12">
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
@stop

@section('scripts')
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#input_cloning').sheepIt({
            separator: '',
            data: [
                @foreach($imageGroup->specs as $spec)
                {
                    'uri_#index#': '{{ $spec->uri }}',
                    'operations_#index#': '@foreach($spec->operations as $operation){{ $operation->getCodeFormat() . ";" }}@endforeach'
                },
                @endforeach
            ]
        });
    });
</script>
@stop