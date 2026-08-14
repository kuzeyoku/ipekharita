<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Service Translations
        Schema::create('service_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();

            $table->unique(['service_id', 'locale']);
        });

        // 2. Project Translations
        Schema::create('project_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('location')->nullable();
            $table->string('client')->nullable();
            $table->timestamps();

            $table->unique(['project_id', 'locale']);
        });

        // 3. Blog Post Translations
        Schema::create('blog_post_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->constrained('blog_posts')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();

            $table->unique(['blog_post_id', 'locale']);
        });

        // 4. Page Translations
        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->unique(['page_id', 'locale']);
        });

        // 5. Category Translations
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['category_id', 'locale']);
        });

        // 6. Site Modal Translations
        Schema::create('site_modal_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_modal_id')->constrained('site_modals')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->string('btn_text')->nullable();
            $table->timestamps();

            $table->unique(['site_modal_id', 'locale']);
        });

        // 7. Menu Item Translations
        Schema::create('menu_item_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained('menu_items')->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();

            $table->unique(['menu_item_id', 'locale']);
        });

        // Seed Existing Records into Translations (Locale: 'tr')
        $now = now();

        // Migrate Services
        if (Schema::hasTable('services')) {
            $services = DB::table('services')->get();
            foreach ($services as $item) {
                DB::table('service_translations')->insertOrIgnore([
                    'service_id' => $item->id,
                    'locale'     => 'tr',
                    'title'      => $item->title ?? '',
                    'slug'       => $item->slug ?? '',
                    'summary'    => $item->summary ?? '',
                    'content'    => $item->content ?? '',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // Migrate Projects
        if (Schema::hasTable('projects')) {
            $projects = DB::table('projects')->get();
            foreach ($projects as $item) {
                DB::table('project_translations')->insertOrIgnore([
                    'project_id'  => $item->id,
                    'locale'      => 'tr',
                    'title'       => $item->title ?? '',
                    'slug'        => $item->slug ?? '',
                    'summary'     => $item->summary ?? '',
                    'description' => $item->description ?? '',
                    'location'    => $item->location ?? '',
                    'client'      => $item->client ?? '',
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);
            }
        }

        // Migrate Blog Posts
        if (Schema::hasTable('blog_posts')) {
            $posts = DB::table('blog_posts')->get();
            foreach ($posts as $item) {
                DB::table('blog_post_translations')->insertOrIgnore([
                    'blog_post_id' => $item->id,
                    'locale'       => 'tr',
                    'title'        => $item->title ?? '',
                    'slug'         => $item->slug ?? '',
                    'summary'      => $item->summary ?? '',
                    'content'      => $item->content ?? '',
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ]);
            }
        }

        // Migrate Pages
        if (Schema::hasTable('pages')) {
            $pages = DB::table('pages')->get();
            foreach ($pages as $item) {
                DB::table('page_translations')->insertOrIgnore([
                    'page_id'          => $item->id,
                    'locale'           => 'tr',
                    'title'            => $item->title ?? '',
                    'slug'             => $item->slug ?? '',
                    'summary'          => $item->summary ?? '',
                    'content'          => $item->content ?? '',
                    'meta_description' => $item->meta_description ?? '',
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ]);
            }
        }

        // Migrate Categories
        if (Schema::hasTable('categories')) {
            $categories = DB::table('categories')->get();
            foreach ($categories as $item) {
                DB::table('category_translations')->insertOrIgnore([
                    'category_id' => $item->id,
                    'locale'      => 'tr',
                    'title'       => $item->title ?? '',
                    'slug'        => $item->slug ?? '',
                    'description' => $item->description ?? '',
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);
            }
        }

        // Migrate Site Modals
        if (Schema::hasTable('site_modals')) {
            $modals = DB::table('site_modals')->get();
            foreach ($modals as $item) {
                DB::table('site_modal_translations')->insertOrIgnore([
                    'site_modal_id' => $item->id,
                    'locale'        => 'tr',
                    'title'         => $item->title ?? '',
                    'content'       => $item->content ?? '',
                    'btn_text'      => $item->btn_text ?? '',
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ]);
            }
        }

        // Migrate Menu Items
        if (Schema::hasTable('menu_items')) {
            $menuItems = DB::table('menu_items')->get();
            foreach ($menuItems as $item) {
                DB::table('menu_item_translations')->insertOrIgnore([
                    'menu_item_id' => $item->id,
                    'locale'       => 'tr',
                    'title'        => $item->title ?? '',
                    'url'          => $item->url ?? '',
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_translations');
        Schema::dropIfExists('site_modal_translations');
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('blog_post_translations');
        Schema::dropIfExists('project_translations');
        Schema::dropIfExists('service_translations');
    }
};
