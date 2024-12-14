<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chirp;

class ChirpController extends Controller
{
    public function destroy(Chirp $chirp)
    {
    $this->authorize('delete', $chirp);
    $chirp->delete();

    return response()->json(['message' => 'Chirp supprimé'], 200);
    }

    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return response()->json(['message' => 'Chirp supprimé'], 200);
    }
        // Supprimer le chirp
        $chirp->delete();

        return response()->json(['message' => 'Chirp supprimé'], 200);


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

