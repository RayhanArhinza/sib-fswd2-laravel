<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index(Request $request)
{
    $products = Product::with('category')->get();
    $products = Product::with('category')->paginate(10);
    if (Auth::user()->role->name == 'User') {
        // Mengambil data merek (brand)
        $brands = Brand::all();
        
        // Mengambil data kategori
        $categories = Category::all();

        // Inisialisasi query builder untuk produk
        $productsQuery = Product::with('category');

        // Cek apakah ada parameter min dan max pada request
        if ($request->has('min') && $request->has('max')) {
            $minPrice = $request->input('min');
            $maxPrice = $request->input('max');

            // Filter produk berdasarkan harga minimum dan maksimum
            $productsQuery->whereBetween('price', [$minPrice, $maxPrice]);
        }

        // Cek apakah ada parameter brand pada request
        if ($request->has('brand')) {
            $brand = $request->input('brand');

            // Filter produk berdasarkan merek (brand) yang diberikan
            $productsQuery->where('brands', $brand);
        }
        
        // Cek apakah ada parameter category pada request
        if ($request->has('category')) {
            $category = $request->input('category');

            // Filter produk berdasarkan kategori yang diberikan
            $productsQuery->whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            });
        }

        // Ambil data produk yang sudah difilter
        $products = $productsQuery->paginate(10);

        return view('product.card', ['products' => $products, 'brands' => $brands, 'categories' => $categories]);
    } else {
        return view('product.index', ['products' => $products]);
    }
}
    
    public function show($id)
    {
        $product = Product::where('id', $id)->with('category')->first();

        $related = Product::where('category_id', $product->category->id)->inRandomOrder()->limit(4)->get();

        if ($product) {
            return view('product.show', compact('product', 'related'));
        } else {
            abort(404);
        }

    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();

        return view('product.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required|string|min:3',
            'price' => 'required|integer',
            'sale_price' => 'required|integer',
            'stock' => 'required|integer',
            'rating' => 'required|integer',
            'brand' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        // mengubah nama file
        $imageName = time() . '.' . $request->image->extension();
        // simpan file ke folder public/product
        Storage::putFileAs('public/product', $request->image, $imageName);

        $product = Product::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock' => $request->stock,
            'rating' => $request->rating,
            'brands' => $request->brand,
            'image' => $imageName,
        ]);

        return redirect()->route('product.index');
    }
    
    public function edit($id)
    {
        $product = Product::where('id', $id)->with('category')->first();
        
        $brands = Brand::all();
        $categories = Category::all();
        
        return view('product.edit', compact('product', 'brands', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        
        // cek jika user mengupload gambar di form
        if ($request->hasFile('image')) {
            $validator = Validator::make($request->all(), [
                'category' => 'required',
                'name' => 'required|string|min:3',
                'price' => 'required|integer',
                'sale_price' => 'required|integer',
                'stock' => 'required|integer',
                'rating' => 'required|integer',
                'brand' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            // ambil nama file gambar lama dari database
            $old_image = Product::find($id)->image;

            // hapus file gambar lama dari folder slider
            Storage::delete('public/product/'.$old_image);

            // ubah nama file
            $imageName = time() . '.' . $request->image->extension();

            // simpan file ke folder public/product
            Storage::putFileAs('public/product', $request->image, $imageName);

            // update data product
            Product::where('id', $id)->update([
                'category_id' => $request->category,
                'name' => $request->name,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'stock' => $request->stock,
                'rating' => $request->rating,
                'brands' => $request->brand,
                'image' => $imageName,
            ]);

        } else {
            $validator = Validator::make($request->all(), [
                'category' => 'required',
                'name' => 'required|string|min:3',
                'price' => 'required|integer',
                'sale_price' => 'required|integer',
                'stock' => 'required|integer',
                'rating' => 'required|integer',
                'brand' => 'required|string',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }
            // update data product tanpa menyertakan file gambar
            Product::where('id', $id)->update([
                'category_id' => $request->category,
                'name' => $request->name,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'stock' => $request->stock,
                'rating' => $request->rating,
                'brands' => $request->brand,
            ]);
        }

        // redirect ke halaman product.index
        return redirect()->route('product.index');
    }
    
    public function destroy($id)
    {
        $product = Product::find($id);
        
        $product->delete();
        
        return redirect()->route('product.index');
    }
    
}