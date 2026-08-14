<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test that all public frontend pages render successfully.
     */
    public function test_homepage_returns_successful_response(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_about_page_returns_successful_response(): void
    {
        $this->get('/about')->assertStatus(200);
    }

    public function test_services_page_returns_successful_response(): void
    {
        $this->get('/services')->assertStatus(200);
    }

    public function test_projects_page_returns_successful_response(): void
    {
        $this->get('/projects')->assertStatus(200);
    }

    public function test_blog_page_returns_successful_response(): void
    {
        $this->get('/blog')->assertStatus(200);
    }

    public function test_contact_page_returns_successful_response(): void
    {
        $this->get('/contact')->assertStatus(200);
    }
}
