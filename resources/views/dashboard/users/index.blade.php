@extends('layouts.dashboard.app')
@section('page_title')
    @lang('site.users')
@endsection
@section('small_title')
    @lang('site.show')
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 15px">@lang('site.users') <small> ({{$records->total()}})</small></h3>
            @include('flash::message')
            <form action="{{route('dashboard.users.index')}}" method="get" >
                <div class="row" >
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{request()->search}}">

                    </div>
                    <div class="col-md-4 ">
                        <button type="submit" id="search-btn" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                        @if(auth()->user()->hasPermission('create_users'))
                            <a href="{{route('dashboard.users.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                        @else
                            <button class="btn btn-primary disabled">@lang('site.add')</button>
                        @endif
                    </div>
                </div>

            </form>

        </div><!-- /.box-header -->
        <div class="box-body">
            @if($records->count() > 0)
                <table class="table table-hover">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>@lang('site.first_name')</th>
                        <th>@lang('site.last_name')</th>
                        <th>@lang('site.email')</th>
                        <th>@lang('site.image')</th>
                        <th>@lang('site.action')</th>

                    </tr>
                    @foreach($records as $record)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$record->first_name}}</td>
                        <td>{{$record->last_name}}</td>
                        <td>{{$record->email}}</td>
                        <td><img src="{{$record->image_path}}" width="100px" class="image-thumbnail"></td>
                        <td>
                            @if(auth()->user()->hasPermission('update_users'))
                            <a href="{{route('dashboard.users.edit',$record->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                            @else
                                <button class="btn btn-info disabled btn-sm"> <i class="fa fa-edit"></i> @lang('site.edit')</button>
                            @endif
                            @if(auth()->user()->hasPermission('delete_users'))
                                <form action="{{route('dashboard.users.destroy',$record->id)}}" method="post" style="display: inline-block">
                                    {{csrf_field()}}
                                    {{method_field('delete')}}
                                    <button class="btn btn-danger btn-sm delete" type="submit"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                </form>
                            @else
                                <button class="btn btn-danger disabled btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </table>
            @else
                <h3>@lang('site.no_data_found')</h3>
            @endif
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
                {{ $records->appends(request()->serach)->links() }}
            </ul>
        </div>
    </div><!-- /.box -->
@endsection

