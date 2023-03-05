<?php

namespace App\Http\Controllers;


use App\Http\Requests\PurchaseRequest;
use App\Repositories\PurchaseRepository;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private PurchaseRepository $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository) {
        $this->purchaseRepository = $purchaseRepository;
    }

    /**
     * @throws \Exception
     */
    public function purchaseProduct(PurchaseRequest $request): array {
        $this->purchaseRepository->create(Auth::id(), $request->input('product_id'));

        (new AchievementService(Auth::user()))->checkAndUpdateUserAchievement();

        return ["message" => "completed"];
    }
}
