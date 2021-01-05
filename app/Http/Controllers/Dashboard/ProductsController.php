<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Product::when($request->search ,function ($q) use( $request){
            return $q->whereTranslationLike('name','%'.$request->search.'%');
        })->when($request->category_id,function ($q) use ($request){
            return $q->where('category_id',$request->category_id);
        })->latest()->paginate(2);
        $categories = Category::all();
        return view('dashboard.products.index',compact('records'),compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'category_id'=>'required',
            'purchasing_price' => 'required',
            'selling_price' => 'required',
            'stock' =>'required'
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules  += [$locale.'.name' =>'required'];
            $rules  += [$locale.'.description' =>'required'];
        }

        $request->validate($rules);
        $request_data = $request->all();
        if ($request->image)
        {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/'.$request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }

        Product::create($request_data);
        return redirect()->route('dashboard.products.index')->with('success',__('site.added_successfully'));
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
        $record = Product::findOrFail($id);
        $categories = Category::all();
        return view('dashboard.products.edit',compact('record'),compact('categories'));
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
        $rules = [
            'category_id'=>'required',
            'purchasing_price' => 'required',
            'selling_price' => 'required',
            'stock' =>'required'
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules  += [$locale.'.name' =>'required'];
            $rules  += [$locale.'.description' =>'required'];
        }
        $request->validate($rules);

        $request_data = $request->all();
        $record = Product::findOrFail($id);
        if ($request->image)
        {
            if ($request->image != 'default.png')
            {
                Storage::disk('public_uploads')->delete('products_images/'.$record->image);
            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/'.$request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }

        $record->update($request_data);
        return redirect()->route('dashboard.products.index')->with('success',__('site.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Product::findOrFail($id);
        if ($record->iamge != 'default.png')
        {
            Storage::disk('public_uploads')->delete('products_images/'.$record->image);
        }
        $record->delete();
        return redirect()->route('dashboard.products.index')->with('error',__('site.deleted_successfully'));
    }
}
