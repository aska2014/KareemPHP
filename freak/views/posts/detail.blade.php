@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title">Post</span>
            <div class="toolbar">
                <div class="btn-group">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-pencil"></i> Action <i class="caret"></i>
                    </span>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ URL::to('model/Post/'.$post->id.'/edit') }}"><i class="icol-pencil"></i> Edit</a></li>
                        <li><a href="{{ URL::to('model/Post/'.$post->id.'/delete') }}"><i class="icol-cross"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="widget-content table-container">
            <table class="table table-striped table-detail-view">
                <tbody>
                    <tr>
                        <th>Title</th>
                        <td>{{ $post->getTitle() }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $post->getDescription() }}</td>
                    </tr>
                    <tr>
                        <th>Tags</th>
                        <td>{{ $post->getTags() }}</td>
                    </tr>
                    <tr>
                        <th>Url</th>
                        <td>{{ $baseUrl . '/' . $post->getSlug() }}</td>
                    </tr>
                    <tr>
                        <th>Difficulty</th>
                        <td>{{ $post->getDifficulty() }}</td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>{{ $post->getState() }}</td>
                    </tr>
                    @if($post->copy_of_id)
                    <tr>
                        <th>Copy of id</th>
                        <td><a href="{{ URL::action('PostController@edit', $post->copyOf->id) }}">{{ $post->copyOf->title }}</a></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="gallery">



</div>
@stop