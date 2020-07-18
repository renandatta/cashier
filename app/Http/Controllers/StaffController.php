<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Repositories\StaffRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StaffController extends Controller
{
    private $staffRepository;
    public function __construct(StaffRepository $staffRepository)
    {
        $this->middleware('auth');
        $this->staffRepository = $staffRepository;

        view()->share(['title' => 'Karyawan']);
        view()->share(['breadcrumbs' => [
            ['name' => 'Data Master', 'url' => '#'],
                ['name' => 'Karyawan', 'url' => 'staff'],
        ]]);
    }

    public function index()
    {
        Session::put('menu_active', 'staff');
        return view('staff.index');
    }

    public function search(Request $request)
    {
        $parameters = [];
        if ($request->has('name') && $request->input('name') != '')
            array_push($parameters, [
                'column' => 'name', 'value' => '%' . $request->input('name') . '%', 'operator' => 'like'
            ]);
        $staffs = $this->staffRepository->search($parameters, null, 10);
        if ($request->has('ajax')) return $staffs;
        return view('staff._table', compact('staffs'));
    }

    public function info(Request $request)
    {
        $staff = $request->has('id') ?
            $this->staffRepository->find($request->get('id')) : [];
        return view('staff.info', compact('staff'));
    }

    public function save(StaffRequest $request)
    {
        $staff = !$request->has('id') ?
            $this->staffRepository->save($request) :
            $this->staffRepository->update($request->input('id'), $request);
        if ($request->has('ajax')) return $staff;
        return redirect()->route('staff')
            ->with('succes', 'Karyawan Berhasil Disimpan!');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $staff = $this->staffRepository->delete($request->input('id'));
        if ($request->has('ajax')) return $staff;
        return redirect()->route('staff')
            ->with('succes', 'Karyawan Berhasil Dihapus!');
    }
}
