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
    public function un_utilisateur_ne_peut_pas_mettre_a_jour_un_chirp_avec_un_contenu_vide()
    {
        // Créer un utilisateur et un chirp
        $user = User::factory()->create();
        $chirp = Chirp::factory()->create(['user_id' => $user->id]);

        // Simuler une connexion en tant qu'utilisateur
        $this->actingAs($user);

        // Tenter de mettre à jour le chirp avec un contenu vide
        $response = $this->put("/chirps/{$chirp->id}", [
            'content' => '',
        ]);

        // Vérifier que l'accès est refusé et une erreur est retournée
        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function un_utilisateur_ne_peut_pas_mettre_a_jour_un_chirp_avec_un_contenu_trop_long()
    {
        // Créer un utilisateur et un chirp
        $user = User::factory()->create();
        $chirp = Chirp::factory()->create(['user_id' => $user->id]);

        // Simuler une connexion en tant qu'utilisateur
        $this->actingAs($user);

        // Tenter de mettre à jour le chirp avec un contenu de plus de 255 caractères
        $response = $this->put("/chirps/{$chirp->id}", [
            'content' => str_repeat('a', 256),
        ]);

        // Vérifier que l'accès est refusé et une erreur est retournée
        $response->assertSessionHasErrors(['content']);
    }
}
