<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();

        return view('brand.index', compact('brands'));
    }

    public function create()
    {

        return view('brand.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $brand = Brand::create([
            'name' => $request->name,
        ]);

        return redirect()->route('brand.index');
    }

    public function edit(Request $request, $id)
    {
        $brand = Brand::find($id);
        return view('brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        Brand::where('id', $id)->update([
            'name' => $request->name,
        ]);

        return redirect()->route('brand.index');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);

        $brand->delete();

        return redirect()->route('brand.index');
    }
}