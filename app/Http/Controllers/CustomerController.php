<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    private $customerRepository;
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->middleware('auth');
        $this->customerRepository = $customerRepository;

        view()->share(['title' => 'Pelanggan']);
        view()->share(['breadcrumbs' => [
            ['name' => 'Data Master', 'url' => '#'],
            ['name' => 'Pelanggan', 'url' => 'customer'],
        ]]);
    }

    public function index()
    {
        Session::put('menu_active', 'customer');
        return view('customer.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->has('name') && $request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $customers = $this->customerRepository->search($parameters, null, 10);
        if ($request->has('ajax')) return $customers;
        return view('customer._table', compact('customers'));
    }

    public function info(Request $request)
    {
        $customer = $request->has('id') ?
            $this->customerRepository->find($request->get('id')) : [];
        return view('customer.info', compact('customer'));
    }

    public function save(CustomerRequest $request)
    {
        $customer = !$request->has('id') ?
            $this->customerRepository->save($request) :
            $this->customerRepository->update($request->input('id'), $request);
        if ($request->has('ajax')) return $customer;
        return redirect()->route('customer')
            ->with('succes', 'Pelanggan Berhasil Disimpan!');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $customer = $this->customerRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $customer;
        return redirect()->route('customer')
            ->with('succes', 'Pelanggan Berhasil Dihapus!');
    }
}
