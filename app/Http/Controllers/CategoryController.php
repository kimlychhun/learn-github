<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\FileException;
class CategoryController extends Controller
{
    public function index()
    {
        $categories= Categories::paginate(10);
        return response()->json($categories,200);
    }
    public function show($id)
    {
        $category= Categories::find($id);
        if($category){
            return response()->json($category,200);
        }else return response()->json('category not found');
    }
    public function store(Request $request)
    {
        try{
            $validated= $request->validate([
                'name'=>'required|unique:category,name',
                'image'=>'nullable'
            ]);
            $category= new Categories();
            $category->name=$request->name;
            $category->image = $request->image ?? ''; 
            $category->save();
            return response()->json('category added',201);
        }catch(Exception $e){
            return response()->json($e,500);
        }
    }
    public function updated_category($id,Request $request)
    {
        try{
            $validated = $request->validate([
                'name'=>'required|unique:brands,name',
                'image'=>'required'
            ]);
           $category=Categories::find($id);
           if($request->hasFile('image')){
                $path = 'assets/uploads/category/' . $category->images;
                if (File::exists($path)) {
                    File::delete($path);
                }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'. $ext;
            try{
                $file->move('assets/uploads/catgory', $filename);
            }catch(Exception $e){
                dd($e);
            }
            $category->image=$filename;
            }
           $category->name=$request->name;
           $category->update();
            return response()->json('category updated',200);
        }catch(Exception $e){
            return response()->json($e,500);
        }
    }
    
    public function delete_category($id)
    {
        $category=Categories::find($id);
        if($category){
            $category->delete();
            return Response()->json('category deleted');
        }
        else return response()->json('category not found');
    }
}
