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
            <h3 class="box-title"> @lang('site.users')</h3>

            <form action="#" method="get" >
                <div class="row" >
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search...">

                    </div>
                    <div class="col-md-4 ">
                        <button type="submit" name="search" id="search-btn" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                        <a href="{{route('dashboard.users.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                    </div>
                </div>

            </form>

        </div><!-- /.box-header -->
        <div class="box-body">
            @if($records->count()>0)
            <table class="table table-hover">
                <tr>
                    <th style="width: 10px">#</th>
                    <th>@lang('site.first_name')</th>
                    <th>@lang('site.last_name')</th>
                    <th>@lang('site.email')</th>
                    <th>@lang('site.action')</th>

                </tr>
                <tr>
                    @foreach($records as $record)
                    <td>{{$loop->iteration}}</td>
                    <td>{{$record->first_name}}</td>
                    <td>{{$record->last_name}}</td>
                    <td>{{$record->email}}</td>
                    <td>

                        <a href="{{route('dashboard.users.edit',$record->id)}}" class="btn btn-info">@lang('site.edit')</a>
                        <form action="{{route('dashboard.users.destroy',$record->id)}}" method="post" style="display: inline-block">
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <button class="btn btn-danger" type="submit">@lang('site.delete')</button>
                        </form>


                    </td>

                    @endforeach
                </tr>

            </table>
            @else
                <h3>@lang('no_data_found')</h3>
            @endif
        </div><!-- /.box-body -->
        @include('partials._pagination')
    </div><!-- /.box -->
@endsection

