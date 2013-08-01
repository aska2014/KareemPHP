@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title">Content</span>
        </div>
        <div class="widget-content table-container">
            <table id="demo-dtable-02" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content title</th>
                        <th>Content place</th>
                        <th>Content page</th>
                        <th>Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contents as $content)
                    <tr>

                        <td>{{ $content->title }}</td>
                        <td>
                            @if($place = $content->places()->first())
                                {{ $place->name }}
                            @endif
                        </td>
            
                        @if($place && ($page = $place->page))
                        <td><a href="{{ URL::action('PageController@show', $page->id) }}">{{ $page->title }}</a></td>
                        @else
                        <td><span class="label label-important">No page</span></td>                        
                        @endif
                        
                        <td class="action-col" width="10%">
                            <span class="btn-group">
                                <a href="{{ URL::to('model/Content/' . $content->id) }}" class="btn btn-small"><i class="icon-search"></i></a>
                                <a href="{{ URL::to('model/Content/' . $content->id . '/edit') }}" class="btn btn-small"><i class="icon-pencil"></i></a>
                                <a href="{{ URL::to('model/Content/' . $content->id . '/delete') }}" class="btn btn-small"><i class="icon-trash"></i></a>
                            </span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Content title</th>
                        <th>Content place</th>
                        <th>Content page</th>
                        <th>Tools</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop