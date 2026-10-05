<?php

namespace App\Http\Controllers;

use App\Models\Bimbel;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Simpan atau perbarui ulasan dan rating untuk bimbel
     */
    public function store(Request $request, $bimbelId)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:3|max:1000',
        ], [
            'rating.required'   => 'Pilih bintang rating (1 - 5).',
            'rating.integer'    => 'Rating harus berupa angka.',
            'rating.min'        => 'Rating minimal 1 bintang.',
            'rating.max'        => 'Rating maksimal 5 bintang.',
            'komentar.required' => 'Tuliskan ulasan Anda mengenai bimbel ini.',
            'komentar.min'      => 'Ulasan minimal 3 karakter.',
            'komentar.max'      => 'Ulasan maksimal 1000 karakter.',
        ]);

        $bimbel = Bimbel::findOrFail($bimbelId);

        Review::updateOrCreate(
            [
                'user_id'   => auth()->id(),
                'bimbel_id' => $bimbel->id,
            ],
            [
                'rating'   => $request->rating,
                'komentar' => $request->komentar,
            ]
        );

        return back()->with('success', 'Ulasan dan rating Anda berhasil disimpan. Terima kasih atas umpan balik Anda!');
    }
}
