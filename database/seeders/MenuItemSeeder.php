<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (MenuItem::count() === 0) {
            $home = MenuItem::create([
                'title' => 'Ana Sayfa',
                'url' => '/',
                'order' => 1,
                'is_active' => true,
            ]);

            $about = MenuItem::create([
                'title' => 'Kurumsal',
                'url' => '/about',
                'order' => 2,
                'is_active' => true,
            ]);

            $services = MenuItem::create([
                'title' => 'Hizmetlerimiz',
                'url' => '/services',
                'order' => 3,
                'is_active' => true,
            ]);

            // Add sample sub-menus under Hizmetlerimiz
            MenuItem::create([
                'parent_id' => $services->id,
                'title' => '22/a Kadastro Yenileme',
                'url' => '/service/22-a-kadastro-yenileme',
                'order' => 1,
                'is_active' => true,
            ]);

            MenuItem::create([
                'parent_id' => $services->id,
                'title' => 'Oblik 3D Kent Modelleme',
                'url' => '/service/oblik-3d-kent-modelleme',
                'order' => 2,
                'is_active' => true,
            ]);

            MenuItem::create([
                'parent_id' => $services->id,
                'title' => 'Airborne LiDAR Lazer Tarama',
                'url' => '/service/airborne-lidar-lazer-tarama',
                'order' => 3,
                'is_active' => true,
            ]);

            $projects = MenuItem::create([
                'title' => 'Projelerimiz',
                'url' => '/projects',
                'order' => 4,
                'is_active' => true,
            ]);

            $blog = MenuItem::create([
                'title' => 'Blog & Haberler',
                'url' => '/blog',
                'order' => 5,
                'is_active' => true,
            ]);

            $contact = MenuItem::create([
                'title' => 'İletişim',
                'url' => '/contact',
                'order' => 6,
                'is_active' => true,
            ]);
        }
    }
}
