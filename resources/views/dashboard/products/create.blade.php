@extends('layouts.dashboard.app')
@section('page_title')
    @lang('site.products_images')
@endsection
@section('small_title')
    @lang('site.add')
@endsection

@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            @include('partials._errors')
        </div><!-- /.box-header -->
        <!-- form start -->
        <form action="{{route('dashboard.products.store')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            {{method_field('post')}}
            <div class="box-body">
                <div class="form-group">
                    <label for="category">@lang('site.category')</label>
                    <select name="category_id" id="category" class="form-control">
                        <option value="" disabled>@lang('site.all_categories')</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->translate(app()->getLocale())->name}}</option>
                        @endforeach
                    </select>
                </div>
                @foreach(config('translatable.locales') as $locale)
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('site.'.$locale.'.name')</label>
                        <input type="text" class="form-control" name="{{$locale}}[name]" placeholder="" >
                    </div>
                @endforeach
                @foreach(config('translatable.locales') as $locale)
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('site.'.$locale.'.description')</label>
                        <textarea class="form-control" name="{{$locale}}[description]"></textarea>
                    </div>
                @endforeach
                <div class="row">
                    <div class="form-group col-md-10">
                        <label for="exampleInputFile">@lang('site.image')</label>
                        <input type="file" name="image" id="exampleInputFile" class="form-control image">
                    </div>
                    <div class="form-group col-md-2">
                        <img src="{{asset('uploads/products_images/default.png')}}" width="100" class="image-thumbnail image-preview" name="image">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">@lang('site.purchasing_price')</label>
                    <input type="number" class="form-control" name="purchasing_price" placeholder="" >
                </div>
                <div class="form-group">
                    <label for="">@lang('site.selling_price')</label>
                    <input type="number" class="form-control" name="selling_price" placeholder="" >
                </div>
                <div class="form-group">
                    <label for="">@lang('site.stock')</label>
                    <input type="number" class="form-control" name="stock" placeholder="" >
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"> @lang('site.add')</i></button>
                </div>
            </div>
        </form>
    </div><!-- /.box -->
@endsection

