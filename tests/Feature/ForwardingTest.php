<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForwardingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testLoadRegularLink()
    {
		$link = \App\Link\Link::create([
			'name' => 'github',
			'domain' => env('DEFAULT_SHORT_DOMAIN', 'ur.bn'),
			'url' => 'https://github.com',
			'link_type_id' => 10
		]);

        $this->assertDatabaseHas('links', ['name' => 'github']);

        $response = $this->get('https://'.$link->domain.'/'.$link->name);
        $response->assertLocation($link->url);
    }
}
