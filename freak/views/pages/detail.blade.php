@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title">Page</span>
            <div class="toolbar">
                <div class="btn-group">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-pencil"></i> Action <i class="caret"></i>
                    </span>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ URL::to('model/Page/'.$page->id.'/edit') }}"><i class="icol-pencil"></i> Edit</a></li>
                        <li><a href="{{ URL::to('model/Page/'.$page->id.'/delete') }}"><i class="icol-cross"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="widget-content table-container">
            <table class="table table-striped table-detail-view">
                <tbody>
                    <tr>
                        <th>Parent page</th>
                        @if($page->parent)
                        <td>{{ $page->parent->title }}</td>
                        @else
                        <td>None</td>
                        @endif
                    </tr>
                    <tr>
                        <th>English Title</th>
                        <td>{{ $page->english_title }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $page->title }}</td>
                    </tr>
                    <tr>
                        <th>Page Description</th>
                        <td>{{ $page->description }}</td>
                    </tr>
                    <tr>
                        <th>Page Url</th>
                        <td>
                            <a href="{{ $baseUrl . '/' . $page->uri }}">
                                {{ $baseUrl . '/' . $page->uri }}
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="gallery">



</div>
@stop