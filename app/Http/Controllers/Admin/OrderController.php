<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends CRUDController
{
    public function __construct()
    {
        $this->model = Order::class;
        $this->essense = 'orders';
        $this->td = ['id','status_text','delivery_text','formatted_total'];
        $this->th = ['ID','Status','Delivery','Total'];
        $this->oneText = 'Order';
    }

    protected function myValidate(Request $request)
    {
        return $request->validate([
            'status' => Rule::in(ORDER::ORDER_STATUSES),
        ]);
    }
}
