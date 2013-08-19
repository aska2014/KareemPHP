@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title">ImageSpecs</span>
        </div>
        <div class="widget-content form-container">
            <form>
                <div class="control-group">
                    <label class="control-label" for="Title">Image group</label>
                    <div class="controls">
                        <select id="image-group">
                            @foreach($imageGroups as $imageGroup)
                            <option value="{{ $imageGroup->id }}">{{ $imageGroup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="imageSpecsRedirect()" class="btn btn-primary" id="submitBtn">Go</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('scripts')

<script type="text/javascript">
    function imageSpecsRedirect()
    {
//        console.log("{{ URL::to('model/ImageSpecs') }}/" + $("#image-group").val());
        window.location.href = "{{ URL::to('model/ImageSpecs') }}/" + $("#image-group").val() + "/edit";
    }
</script>

@stop