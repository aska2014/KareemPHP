@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title">Comment</span>
        </div>
        <div class="widget-content table-container">
            <table id="demo-dtable-02" class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Description</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                    <tr>
                        <td width="20px">{{ $comment->id }}</td>
                        <td>{{ $comment->description }}</td>
                        <td class="action-col" width="10%">
                            <span class="btn-group">
                                <a href="{{ URL::to('model/Comment/' . $comment->id) }}" class="btn btn-small"><i class="icos-check"></i></a>
                                <a href="{{ URL::to('model/Comment/' . $comment->id . '/delete') }}" class="btn btn-small"><i class="icon-trash"></i></a>
                            </span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Description</th>
                        <th>Tools</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop