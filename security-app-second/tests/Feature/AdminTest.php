<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_admin_can_update_contact_message(): void
    {
        $message = ContactMessage::create([
            'name' => '変更前',
            'email' => 'before@example.com',
            'message' => '変更前の内容',
        ]);

        $this->withSession(['admin_logged_in' => true])
            ->get(route('admin.messages.edit', $message))
            ->assertOk()
            ->assertSee('お問い合わせの編集');

        $this->withSession(['admin_logged_in' => true])
            ->put(route('admin.messages.update', $message), [
                'name' => '変更後',
                'email' => 'after@example.com',
                'message' => '変更後の内容',
            ])
            ->assertRedirect(route('admin.index'));

        $this->assertDatabaseHas('contact_messages', [
            'id' => $message->id,
            'name' => '変更後',
            'email' => 'after@example.com',
            'message' => '変更後の内容',
        ]);
    }

    public function test_admin_can_delete_contact_message(): void
    {
        $message = ContactMessage::create([
            'name' => '削除対象',
            'email' => 'delete@example.com',
            'message' => '削除する内容',
        ]);

        $this->withSession(['admin_logged_in' => true])
            ->delete(route('admin.messages.destroy', $message))
            ->assertRedirect(route('admin.index'));

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }
}
