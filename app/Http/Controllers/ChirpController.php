<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chirp;

class ChirpController extends Controller
{
    public function update(Request $request, Chirp $chirp)
    {
        // Vérifier si l'utilisateur est propriétaire du chirp
        if ($chirp->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Valider le contenu
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Mettre à jour le chirp
        $chirp->update([
            'content' => $request->input('content'),
        ]);

        return response()->json($chirp, 200);
    }
}
