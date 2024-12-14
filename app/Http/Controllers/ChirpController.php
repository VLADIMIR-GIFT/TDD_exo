<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chirp;

class ChirpController extends Controller
{
    public function like(Request $request, Chirp $chirp)
 {
    // Vérifie si l'utilisateur a déjà liké ce chirp
    if ($chirp->likes()->where('user_id', auth()->id())->exists()) {
        return response()->json(['error' => 'Vous avez déjà liké ce chirp'], 403);
    }

    // Ajoute un like
    $chirp->likes()->attach(auth()->id());

    return response()->json(['message' => 'Chirp liké avec succès'], 200);
 }
     public function index()
    {
            // Filtrer les chirps créés dans les 7 derniers jours
            $chirps = Chirp::where('created_at', '>=', Carbon::now()->subDays(7))->get();

            return view('welcome', ['chirps' => $chirps]);
    }

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
