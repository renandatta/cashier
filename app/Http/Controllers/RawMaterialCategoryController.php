<?php

namespace App\Http\Controllers;

use App\Http\Requests\RawMaterialCategoryRequest;
use App\Repositories\RawMaterialCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RawMaterialCategoryController extends Controller
{
    private $rawMaterialCategoryRepository;
    public function __construct(RawMaterialCategoryRepository $rawMaterialCategoryRepository)
    {
        $this->middleware('auth');
        $this->rawMaterialCategoryRepository = $rawMaterialCategoryRepository;

        view()->share(['title' => 'Kategori Bahan Baku']);
        view()->share(['breadcrumbs' => [
            ['name' => 'Data Master', 'url' => '#'],
            ['name' => 'Kategori Bahan Baku', 'url' => 'raw_material_category'],
        ]]);
    }

    public function index()
    {
        Session::put('menu_active', 'raw_material_category');
        return view('raw_material_category.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->has('name') && $request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $rawMaterialCategories = $this->rawMaterialCategoryRepository->search($parameters, null, 10);
        if ($request->has('ajax')) return $rawMaterialCategories;
        return view('raw_material_category._table', compact('rawMaterialCategories'));
    }

    public function info(Request $request)
    {
        $rawMaterialCategory = $request->has('id') ?
            $this->rawMaterialCategoryRepository->find($request->get('id')) : [];
        return view('raw_material_category.info', compact('rawMaterialCategory'));
    }

    public function save(RawMaterialCategoryRequest $request)
    {
        $rawMaterialCategory = !$request->has('id') ?
            $this->rawMaterialCategoryRepository->save($request) :
            $this->rawMaterialCategoryRepository->update($request->input('id'), $request);
        if ($request->has('ajax')) return $rawMaterialCategory;
        return redirect()->route('raw_material_category')
            ->with('succes', 'Kategori Bahan Baku Berhasil Disimpan!');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $rawMaterialCategory = $this->rawMaterialCategoryRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $rawMaterialCategory;
        return redirect()->route('raw_material_category')
            ->with('succes', 'Kategori Bahan Baku Berhasil Dihapus!');
    }
}
