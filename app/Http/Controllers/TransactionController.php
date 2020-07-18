<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    private $productTransactionRepository;
    private $productRepository;
    private $customerRepository;
    public function __construct(ProductTransactionRepository $productTransactionRepository,
                                ProductRepository $productRepository, CustomerRepository $customerRepository)
    {
        $this->middleware('auth');
        $this->productTransactionRepository = $productTransactionRepository;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;

        view()->share(['title' => 'Penjualan']);
        view()->share(['breadcrumbs' => [
            ['name' => 'Penjualan', 'url' => 'transaction'],
        ]]);
    }

    public function index()
    {
        Session::put('menu_active', 'transaction');
        $customers = $this->customerRepository->search();
        return view('transaction.index', compact('customers'));
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->has('name') && $request->input('name') != '')
            array_push($parameters, [
                'column' => 'no_transaction', 'value' => '%' . $request->input('no_transaction') . '%', 'operator' => 'like'
            ]);
        if ($request->has('customer_id') && $request->input('customer_id') != '')
            array_push($parameters, [
                'column' => 'customer_id', 'value' => $request->input('customer_id')
            ]);
        if ($request->has('status') && $request->input('status') != '')
            array_push($parameters, [
                'column' => 'status', 'value' => $request->input('status')
            ]);
        if ($request->has('date_start') && $request->input('date_start') != '')
            array_push($parameters, [
                'column' => 'date', 'value' => unformat_date($request->input('date_start')) , 'operator' => '>='
            ]);
        if ($request->has('date_end') && $request->input('date_end') != '')
            array_push($parameters, [
                'column' => 'date', 'value' => unformat_date($request->input('date_end')), 'operator' => '<='
            ]);
        if ($request->has('date') && $request->input('date') != '')
            array_push($parameters, [
                'column' => 'date', 'value' => unformat_date($request->input('date'))
            ]);
        $orders = [];
        array_push($orders, ['column' => 'date', 'direction' => 'asc']);
        $transactions = $this->productTransactionRepository->search($parameters, null, 10);
        if ($request->has('ajax')) return $transactions;
        return view('transaction._table', compact('transactions'));
    }

    public function info(Request $request)
    {
        $transaction = $request->has('id') ?
            $this->productTransactionRepository->find($request->get('id')) : [];
        if (!empty($transaction) && $transaction->status == 'Selesai')
            return redirect()->route('transaction.print', 'id=' . $transaction->id);
        $orders = [];
        array_push($orders, ['column' => 'product_category_id', 'direction' => 'asc']);
        $products = $request->has('id') ? $this->productRepository->search(null, $orders) : [];
        $customers = $this->customerRepository->search();
        return view('transaction.info', compact('transaction', 'products', 'customers'));
    }

    public function save(Request $request)
    {
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['date' => unformat_date($request->input('date'))]);

        $productTransaction = !$request->has('id') ?
            $this->productTransactionRepository->save($request) :
            $this->productTransactionRepository->update($request->input('id'), $request);
        if ($request->has('payment')) return redirect()->route('transaction.print', 'id=' . $productTransaction->id);
        if ($request->has('ajax')) return $productTransaction;
        return redirect()->route('transaction.info', 'id=' . $productTransaction->id)
            ->with('succes', 'Penjualan Berhasil Disimpan!');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $productTransaction = $this->productTransactionRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $productTransaction;
        return redirect()->route('transaction')
            ->with('succes', 'Penjualan Berhasil Dihapus!');
    }

    public function detail_save(Request $request)
    {
        $request->merge(['price' => unformat_number($request->input('price'))]);
        $request->merge(['qty' => unformat_number($request->input('qty'))]);

        $productTransactionDetail = !$request->has('id') ?
            $this->productTransactionRepository->save_detail($request) : [];
        if ($request->has('ajax')) return $productTransactionDetail;
        return redirect()->route('transaction')
            ->with('succes', 'Produk Berhasil Disimpan!');
    }

    public function detail_delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $productTransactionDetail = $this->productTransactionRepository->delete_detail($request->input('id'));
        if ($request->has('ajax')) return $productTransactionDetail;
        return redirect()->route('transaction')
            ->with('succes', 'Produk Berhasil Dihapus!');
    }

    public function payment(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $transaction = $this->productTransactionRepository->find($request->get('id'));
        return view('transaction.payment', compact('transaction'));
    }

    public function print(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $transaction = $this->productTransactionRepository->find($request->get('id'));
        return view('transaction.print', compact('transaction'));
    }
}
