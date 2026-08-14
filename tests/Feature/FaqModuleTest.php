<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FaqModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $serviceFaq = Faq::create([
            'module_type' => 'service',
            'order'       => 1,
            'is_active'   => true,
            'question'    => '22/a Kadastro Sorusu?',
            'answer'      => '22/a Kadastro Cevabı.',
        ]);
        $serviceFaq->translations()->create([
            'locale'   => 'tr',
            'question' => '22/a Kadastro Sorusu?',
            'answer'   => '22/a Kadastro Cevabı.',
        ]);
        $serviceFaq->translations()->create([
            'locale'   => 'en',
            'question' => '22/a Cadastral Question?',
            'answer'   => '22/a Cadastral Answer.',
        ]);

        $projectFaq = Faq::create([
            'module_type' => 'project',
            'order'       => 2,
            'is_active'   => true,
            'question'    => 'Proje Uygulama Sorusu?',
            'answer'      => 'Proje Cevabı.',
        ]);
        $projectFaq->translations()->create([
            'locale'   => 'tr',
            'question' => 'Proje Uygulama Sorusu?',
            'answer'   => 'Proje Cevabı.',
        ]);
        $projectFaq->translations()->create([
            'locale'   => 'en',
            'question' => 'Project Implementation Question?',
            'answer'   => 'Project Answer.',
        ]);
    }

    /**
     * Test that FAQs exist in database and can be queried by module type.
     */
    public function test_faqs_can_be_filtered_by_module_type(): void
    {
        $serviceFaqs = Faq::active()->forModule('service')->get();
        $this->assertNotEmpty($serviceFaqs);

        $projectFaqs = Faq::active()->forModule('project')->get();
        $this->assertNotEmpty($projectFaqs);
    }

    /**
     * Test that FAQ translations work for Turkish and English locales.
     */
    public function test_faq_translations_resolve_correctly(): void
    {
        $faq = Faq::first();
        $this->assertNotNull($faq);

        app()->setLocale('tr');
        $this->assertEquals('22/a Kadastro Sorusu?', $faq->question);

        app()->setLocale('en');
        $this->assertEquals('22/a Cadastral Question?', $faq->question);
    }

    /**
     * Test that services page renders dynamic FAQs.
     */
    public function test_services_page_renders_faqs(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('TEKNİK SSS');
    }

    /**
     * Test admin FAQ management CRUD operations.
     */
    public function test_admin_can_create_faq(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.faqs.store'), [
            'module_type' => 'general',
            'tr' => [
                'question' => 'Genel test sorusu?',
                'answer'   => 'Genel test cevabı içeriği.',
            ],
            'en' => [
                'question' => 'General test question?',
                'answer'   => 'General test answer content.',
            ],
            'order' => 10,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseHas('faqs', [
            'module_type' => 'general',
            'order' => 10,
        ]);
    }
}
