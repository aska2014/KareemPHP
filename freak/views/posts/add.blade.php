@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title"><i class="icon-resize-horizontal"></i> Post form</span>
        </div>
        <div class="widget-content form-container">
            
            <form action="{{ URL::action('PostController@store') }}" method="POST" enctype="multipart/form-data" id="mainForm">

                <div class="control-group">
                    <label class="control-label">Url</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">{{ $baseUrl }}/</span><input name="Post[slug]" value="{{ $post->slug }}" type="text" class="span5">
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="Title">Title</label>
                    <div class="controls">
                        <input type="text" id="input00" name="Post[title]" class="span12" value="{{ $post->title }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="demo-datepicker-01">Posted date</label>
                    <div class="controls">
                        <input id="timepicker-date" type="text" class="span12" name="Post[posted_at]" value="{{ $post->getPostedAt('m/d/Y H:i') }}">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="Title">Description</label>
                    <div class="controls">
                        <textarea name="Post[description]" class="span12">{{ $post->description }}</textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="Title">Tags</label>
                    <div class="controls">
                        <input type="text" id="input00" name="Post[tags]" class="span12" value="{{ $post->tags }}">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="Title">Difficulty</label>
                    <div class="controls">
                        <select name="Post[difficulty]">
                            @foreach($difficulties as $key => $value)
                                @if($post->getDifficulty() == $value)
                                <option value="{{ $key }}" selected="selected">{{ $value }}</option>
                                @else
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="Title">Post state</label>
                    <div class="controls">
                        <select name="Post[state]">
                            @foreach($postStates as $key => $value)
                            @if($post->getState() == $value)
                            <option value="{{ $key }}" selected="selected">{{ $value }}</option>
                            @else
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($post->exists)
                <div class="control-group">
                    <label class="control-label" for="Title">Pages in this post</label>
                    <div class="controls">
                        @foreach($post->pages as $page)
                        <a href="{{ URL::action('PostPageController@edit', $page->id) }}">
                            Page [{{ $page->getOrder() }}]: {{ date('d M H:i:s', strtotime($page->created_at)) }}
                        </a><br />
                        @endforeach
                        <a style="color:#900;" href="{{ URL::action('PostPageController@create') }}?post={{ $post->id }}">Add new Page</a><br />
                    </div>
                </div>
                @endif

                @if($post->exists)
                <div class="control-group">
                    <label class="control-label">Post downloa1d</label>
                    <div class="controls">
                        @if($download = $post->download)
                        <input type="checkbox" name="use_download" checked="checked" />
                        <input type="text" name="Download[link]" class="span8" value="{{ $download->link }}" />
                        @else
                        <input type="checkbox" name="use_download" />
                        <input type="text" name="Download[link]" class="span8" />
                        @endif
                    </div>
                </div>
                @endif

                @if($post->exists)
                <div class="control-group">
                    <label class="control-label">Post demo</label>
                    <div class="controls">
                        @if($demo = $post->demo)
                        <input type="checkbox" name="use_demo" checked="checked" />
                        <input type="text" name="Demo[link]" class="span8" value="{{ $demo->link }}" /><br />
                        @else
                        <input type="checkbox" name="use_demo" />
                        <input type="text" name="Demo[link]" class="span8"/><br />
                        @endif
                        <input type="file" name="demo-zip" />
                    </div>
                </div>
                @endif

                <div class="control-group">
                    <label class="control-label">Post main image</label>
                    <div class="controls">
                        <input type="file" name="main-image">
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

<div class="gallery">
    @if($image = $post->getMainImage())
    <h4>Main image</h4>
    <img src="{{ $image->getSmallest()->url }}"/>
    @endif
</div>

@stop

@section('scripts')
<script type="text/javascript">

    $(document).ready(function()
    {
        $("#timepicker-date").datetimepicker();

        var html = new HtmlHandler($("#mainForm"));
        var control_unit = new ControlUnit( [ 'validate', 'save_in_db', 'upload_images' ], html, {{ $post->id ? $post->id : 0 }} );

        control_unit.requestUrls( '{{ URL::route("request-urls", "Post") }}' );
        html.addListener( control_unit );
    });

</script>
@stop