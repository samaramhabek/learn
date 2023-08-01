<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Tag;
use App\Models\Product;
use App\Models\ImageProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $product= Product::all();
     
    }

    public function test(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required',
            'saleprice' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    // Custom validation logic
                    $price = $request->input('price');
                    if ($value >= $price) {
                        $fail('The sale price must be smaller than the regular price.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            // Handle validation failure
            // Redirect back or return a response with error messages
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->desc = $request->desc;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->saleprice = $request->saleprice;
            $product->quantity = $request->quantity;
            $product->brand = $request->brand;
            $product->status = $request->status;
            $product->save();


            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $imagefile = new ImageProduct();

                    $imagefile->product_id = $product->id;
                    $path = public_path('imagesproduct/');
                    $filename = $image->getClientOriginalName();
                    $image->move($path, $filename);
                    $imagefile->image = $filename;
                    $imagefile->save();
                }
            }
           
             $tags = $request->input('tags');
       //   dd(json_decode($tags));
            
           
           if($tags){
            foreach (json_decode($tags) as $key => $tag) {
                $tagssave=Tag::where('title', $tag->value)->first();
                      if($tagssave){
                        $product->tags()->attach($tagssave->id);
                      }

                    $tagsnew = new Tag();
                    $tagsnew->title = $tag->value;
                    $tagsnew->save();
                    $product->tags()->attach($tagsnew->id);
                      
                
            }
           }
           
            

            DB::commit();
            return $product->refresh();
        } catch (Exception $exception) {

            DB::rollBack();
            return $exception->getMessage();
        }
     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required',
            'saleprice' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    // Custom validation logic
                    $price = $request->input('price');
                    if ($value >= $price) {
                        $fail('The sale price must be smaller than the regular price.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return 'no';
            // Handle validation failure
            // Redirect back or return a response with error messages
            //return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->desc = $request->desc;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->saleprice = $request->saleprice;
            $product->quantity = $request->quantity;
            $product->brand = $request->brand;
            $product->status = $request->status;
            $product->save();


            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $imagefile = new ImageProduct();

                    $imagefile->product_id = $product->id;
                    $path = public_path('imagesproduct/');
                    $filename = $image->getClientOriginalName();
                    $image->move($path, $filename);
                    $imagefile->image = $filename;
                    $imagefile->save();
                }
            }
           
             $tags = $request->input('tags');
       //   dd(json_decode($tags));
            
           
           if($tags){
            foreach (json_decode($tags) as $key => $tag) {
                $tagssave=Tag::where('title', $tag->value)->first();
                      if($tagssave){
                        $product->tags()->attach($tagssave->id);
                      }

                    $tagsnew = new Tag();
                    $tagsnew->title = $tag->value;
                    $tagsnew->save();
                    $product->tags()->attach($tagsnew->id);
                      
                
            }
           }
           
            

            DB::commit();
            return $product->refresh();
        } catch (Exception $exception) {

            DB::rollBack();
            return $exception->getMessage();
        }
        // return redirect()->back()->with('success', 'successed create product!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findorfail($id);
        $product->update($request->except('images','tags'));
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $imageproduct =  new  ImageProduct();
                $filename =  $image->getClientOriginalName();
                $path = public_path('imagesproduct/');
                $image->move($path, $filename);
                $imageproduct->image = $filename;
                $imageproduct->product_id = $product->id;
                $imageproduct->save();
            }
        }
        $tags = $request->input('tags');
        //   dd(json_decode($tags));
             if($tags){
            
             foreach (json_decode($tags) as $key => $tag) {
                 $tagssave=Tag::where('title', $tag->value)->first();
                       if($tagssave){
                         $product->tags()->attach($tagssave->id);
                       }
 
                     $tagsnew = new Tag();
                     $tagsnew->title = $tag->value;
                     $tagsnew->save();
                     $product->tags()->attach($tagsnew->id);
                       
                    }
             }

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findorfail($id);
        $product->delete();
        return Response::json([
            'message'=>'delete',
           'data'=> $product,
       ]);
    }
}
