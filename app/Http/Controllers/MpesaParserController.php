<?php

namespace App\Http\Controllers;

use App\Models\MappedMpesaTransaction;
use App\Services\MpesaSMSParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MpesaParserController extends Controller
{
    public function index()
    {
        $transactions = MappedMpesaTransaction::query()->latest()->get();

        return view('Treasurer.sms-parser', compact('transactions'));
    }

    public function store(Request $request, MpesaSMSParser $parser)
{
    $data = $request->validate([
        'message' => ['required', 'string'],
    ]);

    $parsed = $parser->parse($data['message']);

    $transaction = MappedMpesaTransaction::create([
        'user_id' => Auth::id(),
        'amount' => $parsed['amount'],
        'sender' => $parsed['sender'],
        'transaction_code' => $parsed['transaction_code'],
        'message' => $parsed['message'],
        'status' => 'unmapped',
    ]);

    return response()->json([
        'success' => true,
        'data' => [
            'amount' => number_format($parsed['amount'], 2),
            'sender' => $parsed['sender'],
            'transaction_code' => $parsed['transaction_code'],
            'date' => $parsed['date'] ?? now()->toDateString(),
        ]
    ]);
}}
