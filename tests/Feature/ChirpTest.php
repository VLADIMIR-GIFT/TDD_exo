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
    public function un_utilisateur_peut_liker_un_chirp()
    {
        // Créer un utilisateur et un chirp
        $user = User::factory()->create();
        $chirp = Chirp::factory()->create();

        // Simuler une connexion en tant qu'utilisateur
        $this->actingAs($user);

        // Liker le chirp
        $response = $this->post("/chirps/{$chirp->id}/like");

        // Vérifier que la requête a réussi
        $response->assertStatus(200);

        // Vérifier que le like est enregistré en base de données
        $this->assertDatabaseHas('chirp_likes', [
            'chirp_id' => $chirp->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function un_utilisateur_ne_peut_pas_liker_deux_fois_le_meme_chirp()
    {
        // Créer un utilisateur et un chirp
        $user = User::factory()->create();
        $chirp = Chirp::factory()->create();

        // Simuler une connexion en tant qu'utilisateur
        $this->actingAs($user);

        // Liker le chirp une première fois
        $this->post("/chirps/{$chirp->id}/like");

        // Tenter de liker le chirp une deuxième fois
        $response = $this->post("/chirps/{$chirp->id}/like");

        // Vérifier que la deuxième requête est refusée
        $response->assertStatus(403);
    }
}
