<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Agenda;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VotingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_voting_page_if_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $agenda = Agenda::factory()->create();
        
        // Vincula usuário à agenda
        $agenda->users()->attach($user->id);

        $response = $this->actingAs($user)->get(route('agenda.vote', $agenda->id));

        $response->assertStatus(200);
    }

    public function test_user_cannot_view_voting_page_if_not_authorized()
    {
        $user = User::factory()->create(['role' => 'user']);
        $agenda = Agenda::factory()->create();

        // NÃO vincula usuário

        $response = $this->actingAs($user)->get(route('agenda.vote', $agenda->id));

        $response->assertStatus(403); // Ou 404 dependendo da implementação
    }
}
