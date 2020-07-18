<?php

namespace App\Http\Controllers;

use App\Http\Requests\RawMaterialRequest;
use App\Repositories\RawMaterialRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RawMaterialController extends Controller
{
    private $rawMaterialRepository;
    public function __construct(RawMaterialRepository $rawMaterialRepository)
    {
        $this->middleware('auth');
        $this->rawMaterialRepository = $rawMaterialRepository;

        view()->share(['title' => 'Bahan Baku']);
        view()->share(['breadcrumbs' => [
            ['name' => 'Bahan Baku', 'url' => 'raw_material'],
        ]]);
    }

    public function index()
    {
        Session::put('menu_active', 'raw_material');
        return view('raw_material.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->has('name') && $request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $rawMaterials = $this->rawMaterialRepository->search($parameters, null, 10);
        if ($request->has('ajax')) return $rawMaterials;
        return view('raw_material._table', compact('rawMaterials'));
    }

    public function info(Request $request)
    {
        $rawMaterial = $request->has('id') ?
            $this->rawMaterialRepository->find($request->get('id')) : [];
        $categories = $this->rawMaterialRepository->getCategories();
        return view('raw_material.info', compact('rawMaterial', 'categories'));
    }

    public function save(RawMaterialRequest $request)
    {
        $rawMaterial = !$request->has('id') ?
            $this->rawMaterialRepository->save($request) :
            $this->rawMaterialRepository->update($request->input('id'), $request);
        if ($request->has('ajax')) return $rawMaterial;
        return redirect()->route('raw_material')
            ->with('succes', 'Bahan Baku Berhasil Disimpan!');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $rawMaterial = $this->rawMaterialRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $rawMaterial;
        return redirect()->route('raw_material')
            ->with('succes', 'Bahan Baku Berhasil Dihapus!');
    }
}
