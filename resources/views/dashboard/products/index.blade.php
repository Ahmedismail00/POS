@extends('layouts.dashboard.app')
@section('page_title')
    @lang('site.products')
@endsection
@section('small_title')
    @lang('site.show')
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-bottom: 15px">@lang('site.products') <small> ({{$records->total()}})</small></h3>
            @include('flash::message')
            <form action="{{route('dashboard.products.index')}}" method="get" >
                <div class="row" >
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{request()->search}}">

                    </div>
                    <div class="col-md-4">
                        <select name="category_id" id="category" class="form-control">
                            <option value="" disabled selected>@lang('site.all_categories')</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{request()->category_id == $category->id ? 'selected' : ''}} >{{$category->translate(app()->getLocale())->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 ">
                        <button type="submit" id="search-btn" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                        @if(auth()->user()->hasPermission('create_products'))
                            <a href="{{route('dashboard.products.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
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
                        <th>@lang('site.description')</th>
                        <th>@lang('site.category')</th>
                        <th>@lang('site.image')</th>
                        <th>@lang('site.purchasing_price')</th>
                        <th>@lang('site.selling_price')</th>
                        <th>@lang('site.profit_percent') %</th>
                        <th>@lang('site.stock')</th>
                        <th>@lang('site.action')</th>

                    </tr>
                    @foreach($records as $record)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$record->translate(app()->getLocale())->name}}</td>
                        <td>{{$record->translate(app()->getLocale())->description}}</td>
                        <td>{{$record->category->translate(app()->getLocale())->name}}</td>
                        <td><img src="{{$record->image_path}}" class="image-thumbnail" width="100px"></td>
                        <td>{{$record->purchasing_price}}</td>
                        <td>{{$record->selling_price}}</td>
                        <td>{{$record->profit_percent}} %</td>
                        <td>{{$record->stock}}</td>

                        <td>
                            @if(auth()->user()->hasPermission('update_products'))
                            <a href="{{route('dashboard.products.edit',$record->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                            @else
                                <button class="btn btn-info disabled btn-sm"> <i class="fa fa-edit"></i> @lang('site.edit')</button>
                            @endif
                            @if(auth()->user()->hasPermission('delete_products'))
                                <form action="{{route('dashboard.products.destroy',$record->id)}}" method="post" style="display: inline-block">
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

