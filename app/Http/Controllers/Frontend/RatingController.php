<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function submitRating(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required',
            'product_id' => 'required|integer',
        ]);

        try {
            $existingRating = Rating::where('product_id', $validated['product_id'])
                ->where('email', $validated['email'])
                ->first();

            if ($existingRating) {
                return response()->json(['message' => 'You have already rated this product.'], 422);
            }

            Rating::create([
                'product_id' => $validated['product_id'],
                'username' => $validated['name'],
                'email' => $validated['email'],
                'comment' => $validated['review'],
                'rating' => $validated['rating']
            ]);

            return response()->json(['message' => 'Rating has been completed'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
