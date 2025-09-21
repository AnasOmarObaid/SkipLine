<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\ImageService;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['image', 'favoredBy'])
            ->withCount('favoredBy')
            ->orderBy('created_at', 'desc') // Latest products first
            ->get();

        return view('dashboard.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $locale, ProductStoreRequest $request, ImageService $image)
    {
        try {

            // validate the request
            $data = $request->safe()->except(['image', 'is_active']);

            // set active for product
            $data['is_active'] = $request->safe()->has('is_active') ? true : false;

            // store the product
            $product = Product::create($data);

            // handel the image
            if (request()->hasFile('image'))
                $image->store($request, $product, 'products');

            return redirect()->back()->with('success', trans('app.create_product_successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', trans('app.create_product_failed').$e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $locale, Product $product)
    {
        return view('dashboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $locale, ProductUpdateRequest $request, Product $product, ImageService $image)
    {
        try
        {
            // validate the data
            $data = $request->safe()->except(['image', 'is_active']);

            // get is active
            $data['is_active'] = $request->safe()->has('is_active') ?? $product->is_active;

            // update the product
            $product->update($data);

            // handel the image if isset
            if(request()->hasFile('image'))
                $image->update($request, $product, 'products');

            return redirect()->back()->with('success', trans('app.edit_product_successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', trans('app.edit_product_failed').$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $locale, Product $product, ImageService $image)
    {
        // check if the product has image
        if($product->hasImage())
            $image->delete($product);

        // delete the product
        return $product->delete() ?
            $this->successResponse(trans('app.delete_product_successfully'), null, 200) :
            $this->errorResponse(trans('app.delete_product_failed'), null, 500);
    }
}
