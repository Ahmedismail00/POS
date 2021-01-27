@extends('layouts.dashboard.app')
@section('page_title')
    @lang('site.categories')
@endsection
@section('small_title')
    @lang('site.show')
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 15px">@lang('site.categories') <small> ({{$records->total()}})</small></h3>
            @include('flash::message')
            <form action="{{route('dashboard.categories.index')}}" method="get" >
                <div class="row" >
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{request()->search}}">

                    </div>
                    <div class="col-md-4 ">
                        <button type="submit" id="search-btn" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                        @if(auth()->user()->hasPermission('create_categories'))
                            <a href="{{route('dashboard.categories.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
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
                        <th>@lang('site.name')</th>
                        <th>@lang('site.products_count')</th>
                        <th>@lang('site.related_products')</th>
                        <th>@lang('site.action')</th>

                    </tr>
                    @foreach($records as $record)
                    <tr>
                        <td>{{$record->id}}</td>
                        <td>{{$record->translate(app()->getLocale())->name}}</td>
{{--                        <td>{{$record->products->count()}}</td>--}}
                        <td><a href="{{route('dashboard.products.index',['category_id' => $record->id])}}" class="btn btn-sm btn-info">@lang('site.related_products')</a></td>
                        <td>
                            @if(auth()->user()->hasPermission('update_categories'))
                            <a href="{{route('dashboard.categories.edit',$record->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                            @else
                                <button class="btn btn-info disabled btn-sm"> <i class="fa fa-edit"></i> @lang('site.edit')</button>
                            @endif
                            @if(auth()->user()->hasPermission('delete_categories'))
                                <form action="{{route('dashboard.categories.destroy',$record->id)}}" method="post" style="display: inline-block">
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

