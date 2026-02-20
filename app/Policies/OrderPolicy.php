<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{
    public function author(User $user, Order $order)
    {
        if($order->user_id==$user->id){
            return true;
        }else{
            return false;
        }
    }

    public function payment(User $user, Order $order){

        if($order->status==2){
            return true;
        }else{
            return false;
        }
    }
}
