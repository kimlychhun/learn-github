<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class BrandsController extends Controller
{
    public function index()
    {
        $brands= Brands::paginate(10);
        return response()->json($brands,200);
    }
    public function show($id)
    {
        $brands= Brands::find($id);
        if($brands){
            return response()->json($brands,200);
        }else return response()->json('brand not found');
    }
    public function store(Request $request)
    {
        try{
            $validated= $request->validate([
                'name'=>'required|unique:brands,name'
            ]);
            $brands= new Brands();
            $brands->name=$request->name;
            $brands->save();
            return response()->json('brand added',201);
        }catch(Exception $e){
            return response()->json($e,500);
        }
    }
    public function updated_brand($id,Request $request)
    {
        try{
            $validated = $request->validate([
                'name'=>'required|unique:brands,name'
            ]);
            Brands::where('id',$id)->update(['name'=>$request->name]);
            return response()->json('brand updated',200);
        }catch(Exception $e){
            return response()->json($e,500);
        }
    }
    public function delete_brand($id)
    {
        $brands=Brands::find($id);
        if($brands){
            $brands->delete();
            return Response()->json('brand deleted');
        }
        else return response()->json('brand not found');
    }
}
