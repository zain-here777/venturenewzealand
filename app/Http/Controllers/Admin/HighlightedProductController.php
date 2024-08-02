<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HighlightedProduct;
use App\Models\PlaceProduct;

class HighlightedProductController extends Controller
{
    private $product;

    public function __construct(HighlightedProduct $product)
    {
        $this->product = $product;
    }

    /**
     * Get list Product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        try {
            $products = $this->product->getFullList();
            $productsId = $products->pluck('id')->toArray() ?? [];
            $placeproducts = PlaceProduct::whereNotIn('id',$productsId)
                ->has('place')
                ->with(['place' => function ($q) {
                    $q->select('id', 'name');
                }])
                ->select('id', 'name', 'place_id')
                ->get();
            return view('admin.product.product_highlight_list', [
                'products' => $products,
                'placeproducts' => $placeproducts,
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('admin_highlighted_product_list')->with('error', 'Something went wrong');
        }
    }

    /**
     * Create Product
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'place_product_id' => 'required|exists:place_products,id',
            ]);
            $productCount = $this->product->has('product')->count();
            if($productCount > 10){
                return redirect()->route('admin_highlighted_product_list')->with('error', 'You cannot add more than 10 products');
            }
            $this->product->firstOrCreate($data);
            return redirect()->route('admin_highlighted_product_list')->with('success', 'Record added successfully!');
        } catch (\Throwable $th) {
            return redirect()->route('admin_highlighted_product_list')->with('error', 'Something went wrong');
        }
    }

    /**
     * Delete country
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $this->product->destroy($id);
            return redirect()->route('admin_highlighted_product_list')->with('success', 'Record deleted successfully!');
        } catch (\Throwable $th) {
            return redirect()->route('admin_highlighted_product_list')->with('error', 'Something went wrong');
        }
    }
}
