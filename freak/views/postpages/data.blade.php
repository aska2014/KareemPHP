@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title">PostPage</span>
        </div>
        <div class="widget-content table-container">
            <table id="demo-dtable-02" class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($postpages as $postpage)
                    <tr>
                        <td>{{ $postpage->title }}</td>
                        <td class="action-col" width="10%">
                            <span class="btn-group">
                                <a href="{{ URL::to('model/PostPage/' . $postpage->id) }}" class="btn btn-small"><i class="icon-search"></i></a>
		                        <a href="{{ URL::to('model/PostPage/' . $postpage->id . '/edit') }}" class="btn btn-small"><i class="icon-pencil"></i></a>
                                <a href="{{ URL::to('model/PostPage/' . $postpage->id . '/delete') }}" class="btn btn-small"><i class="icon-trash"></i></a>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Tools</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop