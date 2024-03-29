<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest // extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testCreateProject()
    {
		$admin = factory(\App\User::class)->create();

		$admin->ownProjects()->create([
            'name' => 'Project-One',
            'description' => 'Project One'
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'Project-One',
            'description' => 'Project One'
        ]);
    }

    public function testCreateProjectRoute()
    {
        $response = $this->json('POST', env('DASHBOARD_URL').'/projects', [
            'name' => 'Anyonymous',
        ]);
		
        $response->assertJson(['message' => 'Unauthenticated.']);

		$user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->json('POST', env('DASHBOARD_URL').'/projects', [
            'name' => 'Anonymous',
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'Anonymous',
        ]);
		
    }

    public function testJoinProject()
    {
		$admin = factory(\App\User::class)->create();

		$project = $admin->ownProjects()->create([
            'name' => 'Project',
            'description' => 'Project One'
        ]);

		$user = factory(\App\User::class)->create();

		$this->assertDatabaseHas('users', ['name' => $user->name]);

		$project->addMember($user);

		$this->assertDatabaseHas('project_members', [
			'project_id' => $project->id,
			'user_id' => $user->id
		]);
    }

    public function testLeaveProject()
    {
		$admin = factory(\App\User::class)->create();

        $project = $admin->ownProjects()->create([
            'name' => 'Project-Two',
            'description' => 'Project One'
        ]);

		$user = factory(\App\User::class)->create();

		$this->assertDatabaseHas('users', ['name' => $user->name]);

		$project->addMember($user);

		$project->removeMember($user);

		$this->assertDatabaseMissing('project_members', [
			'user_id' => $user->id,
		]);
    }

    public function testMakeAdmin()
    {
		$admin = factory(\App\User::class)->create();

        $project = $admin->ownProjects()->create([
            'name' => 'Project-Three',
            'description' => 'Project One'
        ]);

		$user = factory(\App\User::class)->create();

		$project->addMember($user);

		$project->changeAdmin($user);

		$this->assertDatabaseHas('projects', [
			'id' => $project->id,
			'admin_id' => $user->id
		]);
    }
}
