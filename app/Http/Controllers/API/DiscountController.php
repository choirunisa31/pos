<?php

namespace App\Http\Controllers\API;

use App\Model\Product;
use App\Model\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiscountCollection;

class DiscountController extends Controller
{
    public function index()
    {
        return new DiscountCollection(Discount::with('product')->orderBy('id', 'desc')->paginate(10));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,code',
            'amount' => 'required|gte:1'
        ]);

        $product_id = Product::where('code', $request->product)->first()->id;

        Discount::Create([
            'product_id' => $product_id,
            'amount' => $request->amount,
            'status' => true
        ]);

        return response(['success' => true], 200);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Discount::find($id)->delete();
        return response(['success' => true], 200);
    }

}
