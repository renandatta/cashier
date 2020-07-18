<?php

namespace App\Http\Controllers;

use App\Repositories\ProductTransactionRepository;
use App\Repositories\RawMaterialRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    private $productTransactionRepository;
    private $rawMaterialRepository;
    public function __construct(ProductTransactionRepository $productTransactionRepository,
                                RawMaterialRepository $rawMaterialRepository)
    {
        $this->middleware('auth');
        $this->productTransactionRepository = $productTransactionRepository;
        $this->rawMaterialRepository = $rawMaterialRepository;
    }

    public function index()
    {
        return view('dashboard.index');
    }

    public function transaction(Request $request)
    {
        if (!$request->has('month')) return abort(404);
        $month = date('Y-m', strtotime('01-' . $request->input('month')));

        $result = [];
        for($i = 1; $i <= date('t', strtotime('01-' . $request->input('month'))); $i++) {
            $transactions = $this->productTransactionRepository->search(array([
                'column' => 'date', 'value' => date('Y-m-d', strtotime($month . '-' . $i))]
            ));
            $total = 0;
            foreach ($transactions as $transaction) {
                $total += $transaction->product_transaction_details->sum('total');
            }
            $item['date'] = $i . '-' . $request->input('month');
            $item['count'] = count($transactions);
            $item['total'] = $total;
            array_push($result, $item);
        }
        return $result;
    }

    public function popular_product(Request $request)
    {
        if (!$request->has('month')) return abort(404);
        $month = date('Y-m', strtotime('01-' . $request->input('month')));
        $transactions = $this->productTransactionRepository->popular_product($month);
        return $request->has('ajax') ? $transactions : view('dashboard._popular_product', compact('transactions'));
    }

    public function warning_raw_material(Request $request)
    {
        $parameters = [];
        array_push($parameters, ['column' => 'stock', 'value' => 10, 'operator' => '<=']);
        $orders = [];
        array_push($orders, ['column' => 'stock', 'direction' => 'asc']);
        $rawMaterials = $this->rawMaterialRepository->search($parameters, $orders, 10);
        return $request->has('ajax') ? $rawMaterials : view('dashboard._warning_raw_material', compact('rawMaterials'));
    }
}
