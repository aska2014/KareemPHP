@extends('models.master')

@section('body')
<div class="row-fluid">
	<div class="span12 widget">
        <div class="widget-header">
            <span class="title">ImageSpecs</span>
            <div class="toolbar">
                <div class="btn-group">
                    <span class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-pencil"></i> Action <i class="caret"></i>
                    </span>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="{{ URL::to('model/ImageSpecs/'.$imagespecs->id.'/edit') }}"><i class="icol-pencil"></i> Edit</a></li>
                        <li><a href="{{ URL::to('model/ImageSpecs/'.$imagespecs->id.'/delete') }}"><i class="icol-cross"></i> Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="widget-content table-container">
            <table class="table table-striped table-detail-view">
                <tbody>
                    <tr>
                        <th>Title</th>
                        <td>{{ $imagespecs->title }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="gallery">



</div>
@stop