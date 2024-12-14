<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chirp;

class ChirpController extends Controller
{
    public function store(Request $request)
    {
        // Vérifier si l'utilisateur a déjà 10 chirps
        if (auth()->user()->chirps()->count() >= 10) {
            return response()->json(['error' => 'Vous ne pouvez pas créer plus de 10 chirps'], 403);
        }

        // Validation des données
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Créer le chirp
        $chirp = Chirp::create([
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);

        return response()->json($chirp, 201);
    }

    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();

        return response()->json(['message' => 'Chirp supprimé'], 200);
    }

    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        // Validation des règles pour la mise à jour
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Mise à jour du chirp
        $chirp->update([
            'content' => $request->input('content'),
        ]);

        return response()->json($chirp, 200);
    }
}
