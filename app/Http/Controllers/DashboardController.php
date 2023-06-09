<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
class DashboardController extends Controller
{
    public function index()
    {
        $totalProduct = Product::count(); // Mengambil jumlah total produk dari tabel 'products'
        $totalBrand = Brand::count(); // Mengambil jumlah total brand dari tabel 'brands'
        $totalUser = User::count(); // Mengambil jumlah total User dari tabel 'users'
        $totalCategory = Category::count(); // Mengambil jumlah total User dari tabel 'users'
        // mengambil 8 data produk secara acak
        $products = Product::inRandomOrder(8)->get();
        $users = User::all();
        
        return view('dashboard', compact('products','totalProduct', 'totalUser', 'totalBrand', 'totalCategory', 'users'));
    }
    }
