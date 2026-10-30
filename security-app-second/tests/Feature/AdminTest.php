<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminTest extends TestCase
{
    public function test_admin_login_page_loads(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    public function test_admin_page_requires_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_log_in_and_view_dashboard(): void
    {
        config([
            'admin.email' => 'admin@example.com',
            'admin.password' => 'password',
        ]);

        $this->followingRedirects()
            ->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
            ])
            ->assertOk()
            ->assertSee('管理者画面')
            ->assertSee('総件数')
            ->assertSee('お問い合わせはまだありません。');
    }
}
