<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = Category::when($request->search ,function ($q) use( $request){
            return $q->whereTranslationLike('name','%'.$request->search.'%');
        })->paginate(20);
        return view('dashboard.categories.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {

            $rules  += [$locale.'.name' =>['required',Rule::unique('category_translations','name')]];
        }

        $request->validate($rules);
        $data = [
            'ar' => ['name' => $request->input('ar.name')],
            'en' => ['name' => $request->input('en.name')],
        ];
        $record = Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success',__('site.added_successfully'));
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
        $record = Category::findOrFail($id);
        return view('dashboard.categories.edit',compact('record'));
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
        $rules = [];
        foreach (config('translatable.locales') as $locale)
        {
            $rules  += [$locale.'.name' =>['required',Rule::unique('category_translations','name')->ignore($id,'category_id')]];
        }
        $request->validate($rules);
        $data = [
            'ar' => ['name' => $request->input('ar.name')],
            'en' => ['name' => $request->input('en.name')],
        ];
        $record = Category::findOrFail($id);
        $record->update($data);
        return redirect()->route('dashboard.categories.index')->with('success',__('site.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Category::findOrFail($id);
        $record->delete();
        return redirect()->route('dashboard.categories.index')->with('error',__('site.deleted_successfully'));
    }
}
