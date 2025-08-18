<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validate = $request->validate([
            'whatsapp' => 'required|numeric',
        ]);

        $response = $this->callFonnteApi([
            'target'   => $request->whatsapp,
            'message'  => "Aku ROY",
            'schedule' => null,
        ]);

        return response()->json($response, $response['ok'] ? 200 : 422);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    protected function callFonnteApi(array $payload): array
    {
        $token = config('services.fonnte.token', env('FONNTE_TOKEN'));
        if (!$token) {
            return [
                'ok' => false,
                'error' => 'FONNTE_TOKEN belum diset di .env atau config services',
            ];
        }

        // Bersihkan null values
        $payload = array_filter($payload, fn($v) => !is_null($v));

        try {
            $res = Http::withoutVerifying()
                ->asForm()
                ->withHeaders(['Authorization' => $token])
                ->post('https://api.fonnte.com/send', $payload);


            return $this->parseFonnteResponse($res);
        } catch (\Throwable $e) {
            return [
                'ok' => false,
                'error' => 'Gagal menghubungi Fonnte: '.$e->getMessage(),
            ];
        }
    }

    protected function parseFonnteResponse(\Illuminate\Http\Client\Response $res): array
    {
        $status = $res->status();
        $json = $res->json();

        // Beberapa akun/API Fonnte mengembalikan { "status": true/false, "detail": ... }
        // Kita standarkan ke { ok, status_code, data|error }
        if ($res->successful()) {
            return [
                'ok'         => (bool)($json['status'] ?? true),
                'status_code'=> $status,
                'data'       => $json,
            ];
        }

        return [
            'ok'         => false,
            'status_code'=> $status,
            'error'      => $json['detail'] ?? $json['message'] ?? $res->body(),
        ];
    }
}
