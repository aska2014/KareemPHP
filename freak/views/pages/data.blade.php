@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title">Page</span>
        </div>
        <div class="widget-content table-container">
            <table id="demo-dtable-02" class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Link</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                    <tr>

                        <td>{{ $page->title }}</td>
                        <th><a href="http://arrabah.net/public/page/{{ Str::slug(Str::words($page->english_title, 3)) . '-' . $page->id }}.html">http://arrabah.net/public/page/{{ Str::slug(Str::words($page->english_title, 3)) . '-' . $page->id }}.html</a></th>
                        <td class="action-col" width="10%">
                            <span class="btn-group">
                                <a href="{{ URL::to('model/Page/' . $page->id) }}" class="btn btn-small"><i class="icon-search"></i></a>
		                        <a href="{{ URL::to('model/Page/' . $page->id . '/edit') }}" class="btn btn-small"><i class="icon-pencil"></i></a>
                                <a href="{{ URL::to('model/Page/' . $page->id . '/delete') }}" class="btn btn-small"><i class="icon-trash"></i></a>
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