<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Chirp;

class ChirpTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_utilisateur_peut_modifier_son_chirp()
    {
        // Étape 1 : Créer un utilisateur et un chirp
        $utilisateur = User::factory()->create();
        $chirp = Chirp::factory()->create(['user_id' => $utilisateur->id]);

        // Étape 2 : Simuler une authentification
        $this->actingAs($utilisateur);

        // Étape 3 : Faire une requête PUT pour mettre à jour le chirp
        $reponse = $this->put("/chirps/{$chirp->id}", [
            'content' => 'Chirp modifié',
        ]);

        // Étape 4 : Vérifier que la requête a réussi
        $reponse->assertStatus(200);

        // Étape 5 : Vérifier que le chirp a été mis à jour dans la base de données
        $this->assertDatabaseHas('chirps', [
            'id' => $chirp->id,
            'content' => 'Chirp modifié',
        ]);
    }
}
