<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Chirp;

class ChirpTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function les_chirps_sont_affiches_sur_la_page_d_accueil()
    {
        // Étape 1 : Créer plusieurs chirps
        $chirps = Chirp::factory()->count(3)->create();

        // Étape 2 : Faire une requête GET sur la page d'accueil
        $reponse = $this->get('/');

        // Étape 3 : Vérifier que chaque chirp est visible dans la réponse
        foreach ($chirps as $chirp) {
            $reponse->assertSee($chirp->content);
        }
    }
}
