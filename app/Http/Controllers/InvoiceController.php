<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id= null)
    {
      $user=auth()->user();
        if($user->hasRole('user')){
     $all_Invoices=Invoice::with('customer.user','invoice_items')->paginate(20);
      }
     if($user->hasRole('Super-Admin')){
     $all_Invoices=Invoice::with('customer.user','invoice_items')->paginate(20);
     }
     if($user->hasRole('customer')){
     $all_Invoices=Invoice::whereRaw("client_id = '".$user->id."'")->with('customer.user','invoice_items')->paginate(20);
     }
     if($id != null){
     $all_Invoices=Invoice::whereRaw("client_id = '".$id."'")->with('customer.user','invoice_items')->paginate(20);
     }
    // dd($all_Invoices);
     return view('invoice.index',compact('all_Invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=auth()->user()->client;
        $inv_count=Invoice::count();
        $inv_count=$inv_count+1;
        $invoice_number="INV00".$inv_count;
        $total=0;
       $Invoice= Invoice::create([
            'client_id'=>$user->id,
            'invoice_number'=>$invoice_number,
            'due_date'=>$request->due_date,
            'invoice_date'=>now(),
        ]);
        foreach ($request->invoice_items as  $items) {
            $invoice_detail=   InvoiceDetail::create([
                'invoice_id'=>$Invoice->id,
            ]);
            foreach ($items as $key => $value) {
          $invoice_detail->update([
                $key=>$value,
            ]);
        }
        $total += $items['price'] * $items['quantity'];

    }
    $Invoice->update(['total'=>$total]);
        toastr()->success('Data has been saved successfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        if (request()->ajax()) {
            $Invoice=  Invoice::with('invoice_items')->findOrFail($id);
          return response()->json($Invoice);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {    
        // dd($request->all());  
        $updates_Invoice= $request->except('_token','_method','Invoice_id');
        $Invoice=  Invoice::findOrFail($id);
        try {
            $Invoice->update($updates_Invoice);
            $total=0;
            foreach ($request->invoice_items as  $items) {
                if(isset($items['id'])){
                    $invoice_detail=   InvoiceDetail::findOrFail($items['id']);
                    foreach ($items as $key => $value) {
                        $invoice_detail->update([
                              $key=>$value,
                          ]);
                      }
                }else{
                    $invoice_detail=   InvoiceDetail::create([
                        'invoice_id'=>$Invoice->id,
                    ]);
                    foreach ($items as $key => $value) {
                  $invoice_detail->update([
                        $key=>$value,
                    ]);
                }
            }
               
            $total += $items['price'] * $items['quantity'];
        }
             $Invoice->update(['total'=>$total]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        toastr()->success('Data has been saved successfully!');
        return redirect()->back();
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Invoice=  Invoice::findOrFail($id);
        $Invoice->delete();
        toastr()->success('Data has been Deleted successfully!');
        return redirect()->back();
    }
}
