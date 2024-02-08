<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['menu'] = 'Orders';
        if ($request->ajax()) {
            return DataTables::of(Order::select())
                ->addColumn('user_name', function($order) {
                    return $order->user->name; 
                })
                ->addColumn('user_email', function($order) {
                    return $order->user->email;
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'orders';
                    $row['section_title'] = 'order';
                    return view('admin.action-buttons', $row);
                })
                ->addColumn('status', function($row){
                    $select = '<select class="form-control select2 orderStatus" id="status'.$row->unique_id.'"  data-id="'.$row->id.'" >';
                        foreach(Order::$allStatus as $status){
                            $selected = ($status == $row->status) ? ' selected="selected"' : '';
                            $select .= '<option '.$selected.' value="'.$status.'">'.ucfirst($status).'</option>';
                        }
                    $select .= '</select>';
                    return $select;
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        return view('admin.order.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    { 
        $data['status'] = 0;
        $order = Order::findOrFail($id);
        $input = $request->all();
        
        if (!empty($order)) {
            $order->update(['status' => $request->status]);
            $data['status'] = 1;
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        if(!empty($order)){
            $order->delete();
            return 1;
        }else{
            return 0;
        }
    }
} 
