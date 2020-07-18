<?php

namespace App\Repositories;

use App\RawMaterialPurchase;
use App\RawMaterial;
use App\RawMaterialPurchaseDetail;
use Illuminate\Http\Request;

class RawMaterialPurchaseRepository extends BaseRepository
{
    private $rawMaterialPurchase;
    private $rawMaterialPurchaseDetail;
    private $rawMaterial;
    public function __construct(RawMaterialPurchase $rawMaterialPurchase,
                                RawMaterialPurchaseDetail $rawMaterialPurchaseDetail,
                                RawMaterial $rawMaterial)
    {
        $this->rawMaterialPurchase = $rawMaterialPurchase;
        $this->rawMaterialPurchaseDetail = $rawMaterialPurchaseDetail;
        $this->rawMaterial = $rawMaterial;
    }

    public function search($parameters = null, $orders = null, $paginate = false)
    {
        $rawMaterialPurchases = $this->rawMaterialPurchase->with('user');
        $rawMaterialPurchases = $this->setParameter($rawMaterialPurchases, $parameters);
        $rawMaterialPurchases = $this->setOrder($rawMaterialPurchases, $orders);
        return $paginate == false ? $rawMaterialPurchases->get() : $rawMaterialPurchases->paginate($paginate);
    }

    public function find($value, $column = 'id')
    {
        return $this->rawMaterialPurchase->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        $request->merge(['status' => 'Proses']);
        return $this->rawMaterialPurchase->create($request->all());
    }

    public function update($id, Request $request)
    {
        $rawMaterialPurchase = $this->rawMaterialPurchase->find($id);
        return $rawMaterialPurchase->update($request->all());
    }

    public function delete($id)
    {
        return $this->rawMaterialPurchase->find($id)->delete();
    }

    public function save_detail(Request $request)
    {
        $request->merge(['status' => 'Belum Diperiksa']);
        $detail = $this->rawMaterialPurchaseDetail->create($request->all());
        $raw_material = $this->rawMaterial->find($detail->raw_material_id);
        $raw_material->stock += $detail->qty;
        $raw_material->save();
        $detail->raw_material = $raw_material;
        $detail->total = $detail->total;
        return $detail;
    }

    public function delete_detail($id)
    {
        $detail = $this->rawMaterialPurchaseDetail->find($id)->delete();
        $raw_material = $this->rawMaterial->find($detail->raw_material_id);
        $raw_material->stock -= $detail->qty;
        $raw_material->save();
        return $detail;
    }
}
