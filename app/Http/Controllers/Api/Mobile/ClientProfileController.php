<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Profile retrieved successfully',
            'data' => $this->summary($request->user()),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'nullable|email|max:200',
        ]);

        $client = $request->user();

        $client->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $this->summary($client),
        ]);
    }

    public function destroy(Request $request)
    {
        $client = $request->user();

        $client->tokens()->delete();
        $client->delete();

        return response()->json([
            'status' => true,
            'message' => 'Account deleted successfully',
            'data' => null,
        ]);
    }

    private function summary(Client $client): array
    {
        return [
            'id' => $client->id,
            'name' => $client->name,
            'phone' => $client->phone,
            'email' => $client->email,
            'number_of_visit' => $client->number_of_visit,
            'total_points' => $client->total_points,
        ];
    }
}
