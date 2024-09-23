<?php

use App\Models\Form;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

test('get forms of authenticated user', function () {

    $this->actingAs(User::factory()->create());

    Form::factory(50)->create();

    $response = $this->get('/api/forms');

    $response->assertStatus(200);
});
