<?php

namespace App\Repositories;

class BaseRepository {

    public function setOrder($model, $orders)
    {
        if ($orders != null) {
            foreach($orders as $order) {
                $model = $model->orderBy($order['column'], !empty($order['direction']) ? $order['direction'] : 'asc');
            }
        }
        return $model;
    }

    public function setParameter($model, $parameters)
    {
        if ($parameters != null) {
            foreach ($parameters as $parameter) {
                $operator = !empty($parameter['operator']) ? $parameter['operator'] : '=';
                $custom = !empty($parameter['custom']) ? $parameter['custom'] : '';

                if ($custom == '') $model = $model->where($parameter['column'], $operator, $parameter['value']);
                if ($custom == 'in_array') $model = $model->whereIn($parameter['column'], $parameter['value']);
                if ($custom == 'null') $model = $model->whereNull($parameter['column']);
                if ($custom == 'not_null') $model = $model->whereNotNull($parameter['column']);
            }
        }
        return $model;
    }

}
