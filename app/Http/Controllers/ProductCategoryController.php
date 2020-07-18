<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Repositories\ProductCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductCategoryController extends Controller
{
    private $productCategoryRepository;
    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->middleware('auth');
        $this->productCategoryRepository = $productCategoryRepository;

        view()->share(['title' => 'Kategori Produk']);
        view()->share(['breadcrumbs' => [
            ['name' => 'Data Master', 'url' => '#'],
            ['name' => 'Kategori Produk', 'url' => 'product_category'],
        ]]);
    }

    public function index()
    {
        Session::put('menu_active', 'product_category');
        return view('product_category.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->has('name') && $request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $productCategories = $this->productCategoryRepository->search($parameters, null, 10);
        if ($request->has('ajax')) return $productCategories;
        return view('product_category._table', compact('productCategories'));
    }

    public function info(Request $request)
    {
        $productCategory = $request->has('id') ?
            $this->productCategoryRepository->find($request->get('id')) : [];
        return view('product_category.info', compact('productCategory'));
    }

    public function save(ProductCategoryRequest $request)
    {
        $productCategory = !$request->has('id') ?
            $this->productCategoryRepository->save($request) :
            $this->productCategoryRepository->update($request->input('id'), $request);
        if ($request->has('ajax')) return $productCategory;
        return redirect()->route('product_category')
            ->with('succes', 'Kategori Produk Berhasil Disimpan!');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $productCategory = $this->productCategoryRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $productCategory;
        return redirect()->route('product_category')
            ->with('succes', 'Kategori Produk Berhasil Dihapus!');
    }
}
