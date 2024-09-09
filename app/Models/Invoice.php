<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable=['client_id','invoice_number','due_date', 'invoice_date','total'];
    public function customer()
    {
       return $this->belongsTo(Client::class, 'client_id','id');
    }
   
    public function invoice_items()
    {
       return $this->hasMany(InvoiceDetail::class , 'invoice_id', 'id');
    }
}
