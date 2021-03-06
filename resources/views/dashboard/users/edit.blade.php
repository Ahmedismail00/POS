@extends('layouts.dashboard.app')
@section('page_title')
    @lang('site.users')
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
        <form action="{{route('dashboard.users.update',$record->id)}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            {{method_field('put')}}
            <div class="box-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">@lang('site.first_name')</label>
                    <input type="text" class="form-control" name="first_name" placeholder="" value="{{$record->first_name}}" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">@lang('site.last_name')</label>
                    <input type="text" class="form-control" name="last_name" placeholder=""  value="{{$record->last_name}}"  required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">@lang('site.email')</label>
                    <input type="email" class="form-control" name="email" placeholder="" value="{{$record->email}}" required>
                </div>
                <div class="row">
                    <div class="form-group col-md-10">
                        <label for="exampleInputFile">@lang('site.image')</label>
                        <input type="file" name="image" id="exampleInputFile" class="form-control image">
                    </div>
                    <div class="form-group col-md-2">
                        <img src="{{asset('uploads/users_images/'.$record->image)}}" width="135" class="image-thumbnail image-preview">
                    </div>
                </div>
                <div class="form-group">
                    <!-- Custom Tabs -->
                    <label for="exampleInputPassword1">@lang('site.permissions')</label>
                    <div class="nav-tabs-custom">
                        @php
                            $models = ['users','categories','products_images'];
                            $permissions =['read','create','update','delete'];
                        @endphp
                        <ul class="nav nav-tabs">
                            @foreach($models as $index=>$model)
                                <li class="{{$index == 0 ? 'active':''}}" ><a href="#{{$model}}" data-toggle="tab" aria-expanded="false">@lang('site.'.$model)</a></li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach($models as $index=>$model)
                                <div class="tab-pane {{$index == 0 ? 'active':''}} " id="{{$model}}">
                                    <div class="checkbox">
                                        @foreach($permissions as $index=>$permission)
                                            <label><input type="checkbox" name="permissions[]" value="{{$permission.'_'.$model}}" {{$record->hasPermission($permission.'_'.$model)?'checked':''}}> @lang('site.'.$permission)</label>
                                        @endforeach
                                    </div>
                                </div><!-- /.tab-pane -->
                            @endforeach
                        </div><!-- /.tab-content -->
                    </div><!-- nav-tabs-custom -->
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"> @lang('site.edit')</i></button>
            </div>
        </form>
    </div><!-- /.box -->
@endsection

