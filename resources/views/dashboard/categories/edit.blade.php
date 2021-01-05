@extends('layouts.dashboard.app')
@section('page_title')
    @lang('site.categories')
@endsection
@section('small_title')
    @lang('site.edit')
@endsection

@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            @include('partials._errors')
        </div><!-- /.box-header -->
        <!-- form start -->
        <form action="{{route('dashboard.categories.update',$record->id)}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            {{method_field('put')}}
            <div class="box-body">
                <div class="form-group">
                    @foreach(config('translatable.locales') as $locale)
                        <label for="exampleInputEmail1">@lang('site.'.$locale.'.name')</label>
                        <input type="text" class="form-control" name="{{$locale}}[name]" placeholder="" value="{{$record->translate($locale)->name}}" required>
                    @endforeach
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"> @lang('site.edit')</i></button>
            </div>
        </form>
    </div><!-- /.box -->
@endsection

