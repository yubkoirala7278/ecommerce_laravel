<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $ratings = Rating::with('product')->latest();


                return DataTables::of($ratings)
                    ->addIndexColumn()
                    ->editColumn('product', function ($row) {
                        return $row->product ? $row->product->title : 'N/A'; // Debugging the relationship
                    })
                    ->make(true);
            }
            return view('admin.ratings.index');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function toggleRatingStatus(Request $request)
{
    try {
        // Find the rating by ID
        $rating = Rating::findOrFail($request->id);
        
        // Toggle the status
        $rating->status = !$rating->status;
        $rating->save();

        return response()->json([
            'success' => true,
            'status' => $rating->status,
            'message' => 'Status updated successfully!',
        ]);
    } catch (\Throwable $th) {
        return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
    }
}

}
