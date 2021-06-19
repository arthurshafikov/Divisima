<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends CRUDController
{
    public function __construct()
    {
        $this->model = Order::class;
        $this->essense = 'orders';
        $this->td = ['id','status_text','delivery','formatted_total'];
        $this->th = ['ID','Status','Delivery','Total'];
        $this->oneText = 'Order';
    }

    public function edit($id)
    {
        $post = $this->model::findOrFail($id);
        return view('admin.edit.' . $this->essense, [
            'post' => $post,
        ]);
    }

    protected function myValidate(Request $request)
    {
        return $request->validate([
            'status' => 'required|integer',
        ]);
    }
}
