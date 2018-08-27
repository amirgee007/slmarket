<?php

namespace Responsive;

use Illuminate\Database\Eloquent\Model;

class UserEarning extends Model
{
    protected $table = 'user_earnings';
    protected $guarded = [];


    public function productOrder()
    {
        return $this->hasOne(ProductOrder::class ,'ord_id' ,'product_order_id');
    }
}
