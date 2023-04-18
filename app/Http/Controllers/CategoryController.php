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
    public function show($id)
    {
        return new CatResource(Category::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {

        $updateCategory = Category::where('id',$id)->first();
        $updateCategory->title = $request->title;
        $updateCategory->description = $request->description;
        try{
            if($request->hasFile('image')){
                $newImgName = \Str::random().'.'.$request->image->getClientOriginalExtension();
                $exists = \Storage::disk('public')->exists('category/image/'.$updateCategory->image);
                if($exists){
                    \Storage::disk('public')->delete('category/image/'.$updateCategory->image);
                }
                \Storage::disk('public')->putFileAs('category/image/',$request->image,$newImgName);
                $updateCategory->image = $newImgName;
            }
        }catch(\Exception $e){
            \Log::error($e->getMessage());
        }
        if($updateCategory->save()){
            return response()->json([
                'message' => 'Data Successfully Updated',
                'status' => true
            ]);
        }
        return response()->json([
            'message' => 'Failed to Update',
            'status' => false
        ]);
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
