<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('update');
        $this->middleware(['permission:delete_users'])->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = User::when($request->search ,function ($q) use ($request){
           return $q->where('first_name','like','%'.$request->search.'%')
               ->orWhere('last_name','like','%'.$request->search.'%');
        })->whereRoleIs('admin')->paginate(1);
        return view('dashboard.users.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|unique:users',
            'image'=>'image',
            'password'=>'required|confirmed|min:8',
            'permissions'=>'required|array',
        ]);
        $request_data = $request->except(['permissions','image']);
        if ($request->image)
        {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/'.$request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }

        $user = User::create($request_data);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);
        return redirect()->route('dashboard.users.index')->with('success',__('site.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = User::findOrFail($id);
        return view('dashboard.users.edit',compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required', Rule::unique('users')->ignore($id),],
            'image'=>'image',
            'permissions'=>'required|array',
        ]);
        $user = User::findOrFail($id);
        $request_data = $request->except(['permissions','image']);
        if ($request->image)
        {
            if ($user->image != 'default.png')
            {
                Storage::disk('public_uploads')->delete('users_images/'.$user->image);
            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/'.$request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }
        $user->update($request_data);
        $user->syncPermissions($request->permissions);
        return redirect()->route('dashboard.users.index')->with('success',__('site.updated_successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = User::findOrFail($id);
        if ($record->iamge != 'default.png')
        {
            Storage::disk('public_uploads')->delete('users_images/'.$record->image);
        }
        $record->delete();
        return redirect(route('dashboard.users.index'))->with('error',__('site.deleted_successfully'));
    }
}
