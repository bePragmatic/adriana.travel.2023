<?php

namespace App\Http\Controllers;

use App\Http\Helper\PaymentHelper;
use App\Models\Currency;
use App\Models\Reservation;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    protected $payment_helper; // Global variable for Helpers instance

    /**
     * Constructor to Set PaymentHelper instance in Global variable
     *
     * @param array $payment Instance of PaymentHelper
     */
    public function __construct(PaymentHelper $payment)
    {
        $this->payment_helper = $payment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Transaction::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $exchangeRate = Currency::where('code', 'HRK')->first()->rate;

        $transaction = Reservation::findOrFail($request->reservation)
            ->transactions()
            ->create([
                'price'         => $request->price,
                'price_hrk'         => $request->price * $exchangeRate,
                'exchange_rate' => $exchangeRate,
            ]);

        return $transaction;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
