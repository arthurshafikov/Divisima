<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends CRUDController
{
    public function __construct()
    {
        
        $this->model = Promocode::class;
        $this->essense = 'promocodes';
        $this->td = ['id','promocode','discount','expired_at'];
        $this->th = ['ID','Promocode','Discount','Expired At'];
        $this->oneText = 'Promocode';
    }

    protected function myValidate(Request $request)
    {
        return $request->validate([
            'promocode' => 'required|string',
            'discount' => 'required|integer',
            'expired_at' => 'nullable|date',
        ]);
    }
}
