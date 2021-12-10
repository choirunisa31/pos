<?php

namespace App\Http\Controllers\API;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return new CategoryCollection(Category::where('name', 'LIKE', "%$request->search%")->orderBy('id', 'desc')->paginate(10));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Category::UpdateOrCreate(
            [
                'id' => $request->id,
            ],
            [
                'name' => $request->name,
                'slug' => Str::slug($request->name)
            ]
        );

        return response(['success' => true], 200);
    }

     public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return Category::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        // 
    }

    public function destroy($id)
    {
        Category::find($id)->delete();
        return response(['success' => true], 200);
    }
}