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
    public function un_utilisateur_ne_peut_pas_modifier_le_chirp_d_un_autre_utilisateur()
    {
        // Créer deux utilisateurs
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Créer un chirp pour l'utilisateur 1
        $chirp = Chirp::factory()->create(['user_id' => $user1->id]);

        // Simuler une connexion en tant qu'utilisateur 2
        $this->actingAs($user2);

        // Tenter de modifier le chirp de l'utilisateur 1
        $response = $this->put("/chirps/{$chirp->id}", [
            'content' => 'Chirp modifié par un autre utilisateur',
        ]);

        // Vérifier que l'accès est refusé
        $response->assertStatus(403);
    }

    /** @test */
    public function un_utilisateur_ne_peut_pas_supprimer_le_chirp_d_un_autre_utilisateur()
    {
        // Créer deux utilisateurs
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Créer un chirp pour l'utilisateur 1
        $chirp = Chirp::factory()->create(['user_id' => $user1->id]);

        // Simuler une connexion en tant qu'utilisateur 2
        $this->actingAs($user2);

        // Tenter de supprimer le chirp de l'utilisateur 1
        $response = $this->delete("/chirps/{$chirp->id}");

        // Vérifier que l'accès est refusé
        $response->assertStatus(403);
}
}
