<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends CRUDController
{
    public function __construct()
    {
        $this->model = Promocode::class;
        $this->routePrefix = 'promocodes';
        $this->tableData = ['id','promocode','discount','expired_at'];
        $this->tableHeaders = ['ID','Promocode','Discount','Expired At'];
        $this->title = 'Promocode';
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'promocode' => 'required|string',
            'discount' => 'required|integer',
            'expired_at' => 'nullable|date',
        ]);
    }
}
