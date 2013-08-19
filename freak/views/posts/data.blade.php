@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title">Post</span>
        </div>
        <div class="widget-content table-container">
            <table id="my-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Title</th>
                        <th>State</th>
                        <th>Pages</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td width="20px">{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>
                            {{ strtoupper($post->getState()) }}
                        </td>
                        <td>
                            @foreach($post->pages as $page)
                            <a href="{{ URL::action('PostPageController@edit', $page->id) }}">{{ $page->getOrder() }}</a>
                            @endforeach
                        </td>
                        <td class="action-col" width="10%">
                            <span class="btn-group">
                                <a href="{{ URL::to('model/Post/' . $post->id) }}" class="btn btn-small"><i class="icon-search"></i></a>
		                        <a href="{{ URL::to('model/Post/' . $post->id . '/edit') }}" class="btn btn-small"><i class="icon-pencil"></i></a>
                                <a href="{{ URL::to('model/Post/' . $post->id . '/delete') }}" class="btn btn-small"><i class="icon-trash"></i></a>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>State</th>
                        <th>Pages</th>
                        <th>Tools</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop


@section('scripts')
<script type="text/javascript">
    $(window).load(function()
    {
        $('#my-table').dataTable( {
            "aaSorting": [[ 0, "desc" ]]
        } ).columnFilter();
    });
</script>
@stop