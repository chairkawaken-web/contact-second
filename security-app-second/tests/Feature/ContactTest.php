<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactTest extends TestCase
{
    public function test_contact_form_page_loads(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200)
            ->assertSee('href="/admin/login"', false)
            ->assertSee('管理者ログイン');
    }
}
