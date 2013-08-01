@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title">Content</span>
            <div class="toolbar">
                <div class="btn-group">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-pencil"></i> Action <i class="caret"></i>
                    </span>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ URL::to('model/Content/'.$content->id.'/edit') }}"><i class="icol-pencil"></i> Edit</a></li>
                        <li><a href="{{ URL::to('model/Content/'.$content->id.'/delete') }}"><i class="icol-cross"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="widget-content table-container">
            <table class="table table-striped table-detail-view">
                <tbody>
                    <tr>
                        <th>Content title</th>
                        <td>{{ $content->title }}</td>
                    </tr>
                    <tr>
                        <th>Content description</th>
                        <td>{{ $content->description }}</td>
                    </tr>
                    @if($place = $content->places()->first())
                    <tr>
                        <th>Place for this content</th>
                        <td>{{ $place->name }}</td>
                    </tr>
                    @endif

                    @if($place && $page = $place->page)
                    <tr>
                        <th>Page for this content</th>
                        <td><a href="{{ $page->url }}">{{ $page->title }}</a></td>
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