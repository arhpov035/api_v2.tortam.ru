<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\ProductShowResourse;
use App\Mail\MailNotify;
use App\Models\Product;
use Illuminate\Http\Request;
use Mail;
use Carbon\Carbon;

//use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($skip = 0)
    {
        $products = Product::where('published', true)->with(['user', 'category'])->skip($skip)->take(8)->orderBy('created_at', 'desc')->get();
        $productCollection = ProductIndexResource::collection($products);
        return response($productCollection);
    }

    public function mail(Request $request)
    {

        $data = [
            'subject' => 'Заказан торт',
            'nameProduct' => $request->nameProduct,
            'weightProduct' => $request->weightProduct,
            'priceProduct' => $request->priceProduct,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date' => $request->date
        ];


//        return response()->json($request);
        try {
            Mail::to('arhipov035@gmail.com')->send(new MailNotify($data));
            return response()->json(['Great check you ']);
        } catch (Exception $th) {
            return response()->json(['Sorry Error']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $product = new Product([
            'user_id' => $request->input('user_id'),
            'category_id' => $request->input('category_id'),
            'slug' => $request->input('slug'),
            'name' => $request->input('name'),
            'image' => $request->input('image'),
            'intro_text' => $request->input('intro_text'),
            'description' => $request->input('description'),
            'published' => $request->input('published'),
        ]);

        return response($product->save());
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
//        $product = Product::where('published', true)->with(['user', 'category'])->findOrFail($id);
        $product = Product::whereSlug($slug)->where('published', true)->firstOrFail();
        return response(new ProductShowResourse($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
//    public function update(ProductUpdateRequest $request, $slug)
    public function update(Request $request, $slug)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Perform some validation on the file if needed
            $file->store('nuxt3');

            return response()->json(['message' => 'File uploaded successfully']);
        }
//        $product = Product::findOrFail(1);
//        $product = Product::whereSlug($slug)->firstOrFail();
//        $product = Product::where('published', true)->whereSlug($slug)->with(['category'])->firstOrFail();
//        $product = Product::where('published', true)->whereSlug($slug)->firstOrFail();
//        $product->category_id = $request->input('category_id');

//        $product->slug = $request->input('slug');
//        $product->name = $request->input('name');
//        $product->published = $request->input('published');

//        $product->image = $request->input('image');
//        $product->intro_text = $request->input('intro_text');
//        $product->description = $request->input('description');

//        return response($product->save());
    }

    public function udateproduct(Request $request, $slug)
    {
        $product = Product::where('published', true)->whereSlug($slug)->firstOrFail();
        $product->category_id = $request->input('category_id');
        $product->slug = $request->input('slug');
        $product->name = $request->input('name');
//        $product->published = $request->input('published');
//        $product->intro_text = $request->input('intro_text');
        $product->description = $request->input('description');


//        if ($request->hasFile('file')) {
//            $file = $request->file('file');
//            $fileName = $file->getClientOriginalName();
//            $file->store('products');
//            $product->image = $request->input('image');
//        }
        if ($request->hasFile('file')) {

            // создаем путь к папке с текущим месяцем и годом
            $currentMonth = Carbon::now()->format('Y-m');
            $path = 'products/' . $currentMonth;

            // сохраняем файл в указанную папку с уникальным именем
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs($path, $fileName, 'public');

            // сохраняем относительный путь к файлу в базу данных
            $product->image = $path . '/' . $fileName;
        }



        return response($product->save());
        return response()->json(['otvet' => $fileName], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        return response($product->delete());
    }
}
