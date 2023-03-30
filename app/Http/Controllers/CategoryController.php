<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource as CatResource;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CatResource::collection(Category::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $imgName = \Str::random().'.'.$request->image->getClientOriginalExtension();
            \Storage::disk('public')->putFileAs('category/image',$request->image,$imgName);
            Category::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imgName
            ]);

            return response()->json([
                'message' => 'Successfully category created'
            ],200);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something goes wrong while creating a category'
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $check = Category::where('id',$id)->first();
        try{
            if($check->image){
                $exists = \Storage::disk('public')->exists('category/image/'.$check->image);
                if($exists){
                    \Storage::disk('public')->delete('category/image/'.$check->image);
                }
            }
            $check->delete();
            return response()->json([
                'message' => "Category Deleted Successfully!!",
                'status' => 200
            ]);
        } catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message' => "Something goes wrong while deleting a category!!",
                'status' => 400
            ]);
        }
    }
}
