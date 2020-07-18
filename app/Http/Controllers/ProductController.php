<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    private $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware('auth');
        $this->productRepository = $productRepository;

        view()->share(['title' => 'Produk']);
        view()->share(['breadcrumbs' => [
            ['name' => 'Produk', 'url' => 'product'],
        ]]);
    }

    public function index()
    {
        Session::put('menu_active', 'product');
        return view('product.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->has('name') && $request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $products = $this->productRepository->search($parameters, null, 10);
        if ($request->has('ajax')) return $products;
        return view('product._table', compact('products'));
    }

    public function info(Request $request)
    {
        $product = $request->has('id') ?
            $this->productRepository->find($request->get('id')) : [];
        $categories = $this->productRepository->getCategories();
        return view('product.info', compact('product', 'categories'));
    }

    public function save(ProductRequest $request)
    {
        $product = !$request->has('id') ?
            $this->productRepository->save($request) :
            $this->productRepository->update($request->input('id'), $request);
        if ($request->has('ajax')) return $product;
        return redirect()->route('product')
            ->with('succes', 'Produk Berhasil Disimpan!');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $product = $this->productRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $product;
        return redirect()->route('product')
            ->with('succes', 'Produk Berhasil Dihapus!');
    }
}
