<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerApiController extends Controller
{
    // GET /api/customers
    public function index()
    {
        $customers = Customer::paginate(10);

        return response()->json([
            'success' => true,
            'data' => $customers
        ]);
    }

    // POST /api/customers
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $customer = Customer::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil ditambahkan.',
            'data' => $customer
        ], 201);
    }

    // GET /api/customers/{id}
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    }

    // PUT /api/customers/{id}
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan.'
            ], 404);
        }

        $customer->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data pelanggan berhasil diupdate.',
            'data' => $customer
        ]);
    }

    // DELETE /api/customers/{id}
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan.'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil dihapus.'
        ]);
    }
}
