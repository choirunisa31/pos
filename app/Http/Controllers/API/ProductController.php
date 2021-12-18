<?php

namespace App\Http\Controllers\API;

use App\Model\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return new ProductCollection(Product::where('name', 'LIKE', "%$request->search%")->where('code', 'LIKE', "%$request->search%")->orderBy('id', 'desc')->paginate(10));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required|exists:category_id',
            'description' => 'required',
            'stock' => 'required',
            'price' => 'required|integer'
            ]);

            if ($request->hasFile('photo') == true) {
                $photo = $request->file('photo');
                $photo_name = date('siHdmY') . '_' . $photo->getClientOriginalName();
                $photo->move('images/products/', $photo_name);
                $image = '/images/products/' . $photo_name;
            } else {
                $image = $request->image;
            }

            $kalimat = explode(" ", $request->name);
            for ($i = 0; $i < count($kalimat); $i++) {
                $str_kode = str_split($kalimat[$i][0]);
                $kode[$i] = strtoupper(implode($str_kode));
            }
            $kode = implode($kode);

            if ($request->id == true) {
                $data_nomor = Product::find($request->id)->first();
                $nomor = $data_nomor->nomor;
            } else {
                $max = Product::max('nomor');
                $angka = $max + 1;
                if (strlen($angka) == 1) {
                    $nomor = "0000" . $angka;
                } else if (strlen($angka) == 2) {
                    $nomor = "000" . $angka;
                } else if (strlen($angka) == 3) {
                    $nomor = "00" . $angka;
                } else if (strlen($angka) == 4) {
                    $nomor = "0" . $angka;
                } else {
                    $nomor = $angka;
                }
            }

            Product::UpdateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'name' => $request->name,
                'nomor' => $nomor,
                'code' => $kode . '-' . $nomor,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $image,
            ]
        );

        return response(['success' => true], 200);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $products = Product::with('discount')->where('name', 'LIKE', "%$search%")->orWhere('code', 'LIKE', "%$search%")->orderBy('name', 'ASC')->limit(5)->get();
        return response()->json($products);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return Product::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        // 
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['status' => true]);
    }
}
