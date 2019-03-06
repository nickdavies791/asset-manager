<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
	use RefreshDatabase;

	/*
	 * Test a guest cannot view the home page
	 */
	public function test_a_guest_cannot_view_home()
	{
		$response = $this->get(route('home'));
		$response->assertRedirect('/login');
	}
}
