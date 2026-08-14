<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslationModuleTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@ipek.test',
        ]);
    }

    public function test_admin_can_view_translations_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.translations.index'));
        $response->assertStatus(200);
        $response->assertSee('Dil ve Çeviri Yönetimi');
    }

    public function test_admin_can_save_translations(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.translations.update'), [
            'locale' => 'tr',
            'file'   => 'site',
            'keys'   => [
                'general.brand_name' => 'İpek Test Mühendislik',
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_admin_can_add_and_delete_translation_key(): void
    {
        // Add key
        $addResponse = $this->actingAs($this->admin)->post(route('admin.translations.add-key'), [
            'locale' => 'tr',
            'file'   => 'site',
            'key'    => 'test_key_temp',
            'value'  => 'Geçici Test Değeri',
        ]);

        $addResponse->assertRedirect();
        $addResponse->assertSessionHas('success');

        // Delete key
        $delResponse = $this->actingAs($this->admin)->post(route('admin.translations.delete-key'), [
            'locale' => 'tr',
            'file'   => 'site',
            'key'    => 'test_key_temp',
        ]);

        $delResponse->assertRedirect();
        $delResponse->assertSessionHas('success');
    }

    public function test_admin_can_create_and_delete_new_language(): void
    {
        // Create language 'de'
        $createResponse = $this->actingAs($this->admin)->post(route('admin.translations.store-language'), [
            'locale' => 'de',
        ]);

        $createResponse->assertRedirect();
        $createResponse->assertSessionHas('success');
        $this->assertDirectoryExists(base_path('lang/de'));

        // Delete language 'de'
        $delLangResponse = $this->actingAs($this->admin)->post(route('admin.translations.delete-language'), [
            'locale' => 'de',
        ]);

        $delLangResponse->assertRedirect();
        $delLangResponse->assertSessionHas('success');
        $this->assertDirectoryDoesNotExist(base_path('lang/de'));
    }

    public function test_cannot_delete_default_turkish_language(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.translations.delete-language'), [
            'locale' => 'tr',
        ]);

        $response->assertSessionHasErrors('locale');
        $this->assertDirectoryExists(base_path('lang/tr'));
    }

    public function test_default_turkish_locale_is_always_ordered_first(): void
    {
        $service = app(\App\Services\TranslationService::class);
        $locales = $service->getAvailableLocales();
        $keys = array_keys($locales);

        $this->assertEquals('tr', $keys[0]);
    }
}
