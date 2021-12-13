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
        $this->routePrefix = 'orders';
        $this->tableData = ['id','status_text','delivery_text','formatted_total'];
        $this->tableHeaders = ['ID','Status','Delivery','Total'];
        $this->title = 'Order';
    }

    protected function myValidate(Request $request): array
    {
        return $request->validate([
            'status' => ['required', Rule::in(ORDER::ORDER_STATUSES)],
        ]);
    }
}
