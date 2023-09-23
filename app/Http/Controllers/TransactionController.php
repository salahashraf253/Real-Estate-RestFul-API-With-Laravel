<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyUnitRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserPurchasesCollection;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class TransactionController extends Controller
{
    public function buy(BuyUnitRequest $request): TransactionResource
    {
        $request->validated();
        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'unit_id' => $request['unit_id'],
            'price' => $request['price'],
        ]);

        $unit = Unit::find($request['unit_id']);

        $unit->markAsSold();

        return new TransactionResource($transaction);
    }

    public function index(): UserPurchasesCollection
    {
        $transactions = Transaction::all();

        return new UserPurchasesCollection($transactions);
    }

    public function show(int $userId): UserPurchasesCollection
    {
        if (Auth::user()->id != $userId) {
            abort(HttpResponse::HTTP_FORBIDDEN, 'Unauthorized');
        }
        $user = User::findOrFail($userId);

        $transactions = $user->transactions;

        return new UserPurchasesCollection($transactions);
    }

    public function adminShow(int $userId): UserPurchasesCollection
    {
        $user = User::findOrFail($userId);

        $transactions = $user->transactions;

        return new UserPurchasesCollection($transactions);
    }
}
