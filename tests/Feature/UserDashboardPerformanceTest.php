<?php

use App\Models\User;
use App\Models\Agenda;
use App\Models\Project;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

test('dashboard performance N+1 check', function () {
    // Setup
    $user = User::factory()->create();

    // Create 5 agendas
    $agendas = collect();
    for ($i = 0; $i < 5; $i++) {
        $agenda = Agenda::create([
            'title' => 'Agenda ' . $i,
            'year' => 2024,
            'deadline' => now()->addDays(10),
            'start_date' => now(),
            'results_date' => now()->addDays(20),
            'is_main_schedule' => false,
            'allow_editing' => true,
        ]);
        $agendas->push($agenda);

        // Create 10 projects per agenda
        for ($j = 0; $j < 10; $j++) {
            $project = Project::create([
                'agenda_id' => $agenda->id,
                'codigo' => 'PROJ-' . $i . '-' . $j,
                'type' => 'agenda',
                'ementa' => 'Test project',
            ]);

            // Vote on 5 of them
            if ($j < 5) {
                Vote::create([
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                    'prioridade' => 'Alta',
                    'posicao' => 'Favorável'
                ]);
            }
        }
    }

    // Attach user to agendas
    $user->agendas()->attach($agendas->pluck('id'));

    Auth::login($user);

    // Measure
    DB::enableQueryLog();

    $response = $this->get('/dashboard');

    $queries = DB::getQueryLog();
    $count = count($queries);

    // Expected query count should be significantly low.
    // Observed count was 4.
    // We assert it is less than 10 to allow for some variation but catch N+1 (which was > 20).
    expect($count)->toBeLessThan(10);

    $response->assertStatus(200);
});
