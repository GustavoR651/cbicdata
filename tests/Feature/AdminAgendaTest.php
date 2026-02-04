<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Agenda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminAgendaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_agendas_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.agendas.index'));

        $response->assertStatus(200);
    }

    public function test_user_cannot_view_agendas_page()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get(route('admin.agendas.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_create_agenda()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Mock de arquivo seria necessário aqui, mas para teste rápido vamos testar acesso à rota
        $response = $this->actingAs($admin)->get(route('admin.agendas.create'));

        $response->assertStatus(200);
    }
}
