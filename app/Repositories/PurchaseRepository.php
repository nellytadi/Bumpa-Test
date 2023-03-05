<?php


namespace App\Repositories;


use App\Models\Purchase;

class PurchaseRepository
{
    public function create($userId, $productId){
        return Purchase::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }

}