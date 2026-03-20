<?php

namespace App\Http\Controllers;

use App\Models\SkinJournal;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SkinJournalController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'entry_date' => 'required|date',
            'condition_score' => 'required|integer|min:1|max:5',
            'observations' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $journalData = [
            'entry_date' => $validated['entry_date'],
            'condition_score' => $validated['condition_score'],
            'observations' => $validated['observations'] ?? null,
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('journal_photos', 'public');
            $journalData['photo_path'] = basename($photoPath);
        }

        $journal = auth()->user()->skinJournals()->create($journalData);

        return response()->json([
            'success' => true,
            'message' => 'Journal entry created successfully!',
            'journal' => $journal
        ]);
    }
}
