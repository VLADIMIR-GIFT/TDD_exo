<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ChirpTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function un_chirp_ne_peut_pas_avoir_un_contenu_vide()
    {
        // Étape 1 : Simuler un utilisateur connecté
        $utilisateur = User::factory()->create();
        $this->actingAs($utilisateur);

        // Étape 2 : Envoyer une requête POST avec un contenu vide
        $reponse = $this->post('/chirps', [
            'content' => '',
        ]);

        // Étape 3 : Vérifier que la validation échoue
        $reponse->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function un_chirp_ne_peut_pas_depasse_255_caracteres()
    {
        // Étape 1 : Simuler un utilisateur connecté
        $utilisateur = User::factory()->create();
        $this->actingAs($utilisateur);

        // Étape 2 : Envoyer une requête POST avec un contenu trop long
        $reponse = $this->post('/chirps', [
            'content' => str_repeat('a', 256), // Générer une chaîne de 256 caractères
        ]);

        // Étape 3 : Vérifier que la validation échoue
        $reponse->assertSessionHasErrors(['content']);
    }
}
