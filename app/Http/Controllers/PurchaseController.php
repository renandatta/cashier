<?php

namespace App\Http\Controllers;

use App\Repositories\RawMaterialPurchaseRepository;
use App\Repositories\RawMaterialRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    private $rawMaterialPurchaseRepository;
    private $rawMaterialRepository;
    public function __construct(RawMaterialPurchaseRepository $rawMaterialPurchaseRepository,
                                RawMaterialRepository $rawMaterialRepository)
    {
        $this->middleware('auth');
        $this->rawMaterialPurchaseRepository = $rawMaterialPurchaseRepository;
        $this->rawMaterialRepository = $rawMaterialRepository;

        view()->share(['title' => 'Pembelian Bahan Baku']);
        view()->share(['breadcrumbs' => [
            ['name' => 'Pembelian Bahan Baku', 'url' => 'purchase'],
        ]]);
    }

    public function index()
    {
        Session::put('menu_active', 'purchase');
        return view('purchase.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->has('name') && $request->input('name') != '')
            array_push($parameters, [
                'column' => 'no_transaction', 'value' => '%' . $request->input('no_transaction') . '%', 'operator' => 'like'
            ]);
        if ($request->has('user_id') && $request->input('user_id') != '')
            array_push($parameters, [
                'column' => 'user_id', 'value' => $request->input('user_id')
            ]);
        if ($request->has('date_start') && $request->input('date_start') != '')
            array_push($parameters, [
                'column' => 'date', 'value' => unformat_date($request->input('date_start')) , 'operator' => '>='
            ]);
        if ($request->has('date_end') && $request->input('date_end') != '')
            array_push($parameters, [
                'column' => 'date', 'value' => unformat_date($request->input('date_end')), 'operator' => '<='
            ]);
        $orders = [];
        array_push($orders, ['column' => 'date', 'direction' => 'asc']);
        $purchases = $this->rawMaterialPurchaseRepository->search($parameters, null, 10);
        if ($request->has('ajax')) return $purchases;
        return view('purchase._table', compact('purchases'));
    }

    public function info(Request $request)
    {
        $purchase = $request->has('id') ?
            $this->rawMaterialPurchaseRepository->find($request->get('id')) : [];
        $rawMaterials = $request->has('id') ? $this->rawMaterialRepository->search() : [];
        return view('purchase.info', compact('purchase', 'rawMaterials'));
    }

    public function save(Request $request)
    {
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['date' => unformat_date($request->input('date'))]);

        $rawMaterialPurchase = !$request->has('id') ?
            $this->rawMaterialPurchaseRepository->save($request) :
            $this->rawMaterialPurchaseRepository->update($request->input('id'), $request);
        if ($request->has('ajax')) return $rawMaterialPurchase;
        return redirect()->route('purchase.info', 'id=' . $rawMaterialPurchase->id)
            ->with('succes', 'Pembelian Bahan Baku Berhasil Disimpan!');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $rawMaterialPurchase = $this->rawMaterialPurchaseRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $rawMaterialPurchase;
        return redirect()->route('purchase')
            ->with('succes', 'Pembelian Bahan Baku Berhasil Dihapus!');
    }

    public function detail_save(Request $request)
    {
        $request->merge(['price' => unformat_number($request->input('price'))]);
        $request->merge(['qty' => unformat_number($request->input('qty'))]);

        $rawMaterialPurchaseDetail = !$request->has('id') ?
            $this->rawMaterialPurchaseRepository->save_detail($request) : [];
        if ($request->has('ajax')) return $rawMaterialPurchaseDetail;
        return redirect()->route('purchase')
            ->with('succes', 'Bahan Baku Berhasil Disimpan!');
    }

    public function detail_delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $rawMaterialPurchaseDetail = $this->rawMaterialPurchaseRepository->delete_detail($request->input('id'));
        if ($request->has('ajax')) return $rawMaterialPurchaseDetail;
        return redirect()->route('purchase')
            ->with('succes', 'Bahan Baku Berhasil Dihapus!');
    }
}
