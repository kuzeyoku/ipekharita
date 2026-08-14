<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@ipekharita.com'],
            [
                'name' => 'İpek Harita Yönetici',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Initial Services
        $services = [
            [
                'title' => '22/a Kadastro Yenileme',
                'icon' => 'fa-solid fa-map-location-dot',
                'summary' => '3402 sayılı Kanun uyarınca teknik nedenlerle yetersiz kalan kadastro paftalarının sayısal yöntemlerle yenilenmesi.',
                'description' => 'İpek Mühendislik A.Ş.; 3402 Sayılı Kadastro Kanununun 22. maddesinin (a) bendi gereğince teknik nedenlerle yetersiz kalan, uygulama niteliğini kaybeden, eksikliği görülen veya zemindeki sınırları belli olmayan kadastro haritalarının yenilenmesi işlerini yüksek hassasiyetli GNSS ve fotogrametrik yöntemlerle tamamlamaktadır.',
                'order' => 1,
            ],
            [
                'title' => 'Oblik 3D Kent & Arazi Modelleme',
                'icon' => 'fa-solid fa-city',
                'summary' => 'Belediyeler ve kamu kurumları için 5-açılı oblik kamera sistemleri ile fotogerçekçi 3B şehir modelleri.',
                'description' => 'Oblik kamera sistemleri ile elde edilen hava fotoğrafları üzerinden akıllı şehirler ve 3B Kent Rehberleri için CityGML standartlarında 3B dijital ikiz üretimi gerçekleştirmekteyiz.',
                'order' => 2,
            ],
            [
                'title' => 'Airborne LiDAR & Fotogrametri',
                'icon' => 'fa-solid fa-plane-up',
                'summary' => 'Uçak ve yüksek kapasiteli İHA platformsı ile yüksek nokta yoğunluklu lazer tarama ve ortofoto haritalama.',
                'description' => 'Yoğun bitki örtüsü altında bile yüksek hassasiyetli Sayısal Arazi Modeli (SAM/DTM) üreten Airborne LiDAR teknolojisi ile geniş sahalarda hızlı veri toplama imkanı sunuyoruz.',
                'order' => 3,
            ],
            [
                'title' => 'Coğrafi Bilgi Sistemleri (CBS)',
                'icon' => 'fa-solid fa-database',
                'summary' => 'Kurumsal ve kent ölçeğinde spatial veri tabanı mimarisi, GIS analizleri ve WebGIS portalları.',
                'description' => 'Mekansal verilerin standartlaştırılması, Postgres/PostGIS mimarileri üzerinde saklanması ve kurumsal kararlara altlık oluşturacak CBS yazılımlarının geliştirilmesi.',
                'order' => 4,
            ],
            [
                'title' => 'İmar Uygulamaları & Madde 18',
                'icon' => 'fa-solid fa-draw-polygon',
                'summary' => 'Arazi ve arsa düzenlemeleri, parselasyon planları ve kadastral tescil süreçleri.',
                'description' => '3194 sayılı İmar Kanununun 18. maddesi uyarınca ham arazilerin imar parseline dönüştürülmesi ve tapu tescil işlemlerinin eksiksiz yürütülmesi.',
                'order' => 5,
            ],
            [
                'title' => 'Altyapı & Deformasyon Ölçümleri',
                'icon' => 'fa-solid fa-bridge-water',
                'summary' => 'Baraj, köprü, tünel ve karayolu hatlarında milimetrik hassasiyetli geometrik izleme.',
                'description' => 'Mühendislik yapılarında oluşabilecek oturma ve kaymaların periyodik olarak milimetrik hassasiyetli robotik total station ve izleme sensörleri ile takibi.',
                'order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['title'])],
                array_merge($service, ['slug' => Str::slug($service['title'])])
            );
        }

        // 3. Initial Projects
        $projects = [
            [
                'title' => 'Konya Şehir Merkezi 22/a Kadastro Yenileme Projesi',
                'category' => '22/a Kadastro',
                'client' => 'Tapu ve Kadastro Genel Müdürlüğü (TKGM)',
                'location' => 'Konya, Türkiye',
                'year' => '2025 - 2026',
                'summary' => '12.500 hektar alanda hassas nirengi ve poligon ağları ile kadastro haritalarının yenilenmesi ve tescili.',
                'is_featured' => true,
            ],
            [
                'title' => 'Muğla Kıyı Şeridi 3D Oblik Kent Modellemesi',
                'category' => '3D Kent Modelleme',
                'client' => 'Muğla Büyükşehir Belediyesi',
                'location' => 'Muğla, Türkiye',
                'year' => '2025',
                'summary' => '5-kameralı hava fotogrametrisi ile 8.400 hektarlık kıyı bandının 3 boyutlu dijital ikiz modelinin üretimi.',
                'is_featured' => true,
            ],
            [
                'title' => 'Ankara-Sivas YHT Hattı LiDAR ve Şerit Harita Üretimi',
                'category' => 'LiDAR & Fotogrametri',
                'client' => 'TCDD Genel Müdürlüğü',
                'location' => 'Ankara - Sivas',
                'year' => '2024 - 2025',
                'summary' => '400 km demiryolu koridorunda Airborne LiDAR lazer tarama ile milimetrik şerit harita ve ortofoto üretimi.',
                'is_featured' => true,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => Str::slug($project['title'])],
                array_merge($project, ['slug' => Str::slug($project['title'])])
            );
        }

        // 4. Initial Blog Posts
        $posts = [
            [
                'title' => "3402 Sayılı Kanun'un 22/a Maddesi Uyarınca Kadastro Yenileme Süreçleri",
                'category' => 'Kadastro Mevzuatı',
                'summary' => 'Mevcut kadastro haritalarının teknik yetersizlikler nedeniyle zeminle uyumsuzlaşması durumunda uygulanan 22/a yenileme mevzuatı ve saha prosedürleri.',
                'content' => 'Kadastro yenileme çalışmaları, mülkiyet güvenliğinin sağlanması ve güncel harita altyapısının oluşturulması açısından kritik önem taşır. Bu yazımızda 22/a maddesi kapsamındaki teknik standartları ve saha uygulamalarını inceliyoruz.',
                'published_at' => now(),
            ],
            [
                'title' => 'Oblik Kamera Teknolojisi ile Şehir Ölçeğinde 3D Dijital İkiz Üretimi',
                'category' => '3D Fotogrametri',
                'summary' => 'Geleneksel dik fotogrametriye kıyasla bina cephe detaylarını ve dikey yapıları 5 farklı açıdan görüntüleyen oblik sistemlerin avantajları.',
                'content' => 'Akıllı şehir yönetimi için 3B verilerin önemi gün geçtikçe artıyor. Oblik fotogrametri sayesinde şehirlerin dikey dokusu milimetrik detaylarla modellenebilmektedir.',
                'published_at' => now(),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                array_merge($post, ['slug' => Str::slug($post['title'])])
            );
        }

        // 5. Initial Settings
        $settings = [
            'site_title' => 'İpek Mühendislik A.Ş. | Harita, Kadastro & 3D Oblik',
            'phone' => '+90 (312) 000 00 00',
            'email' => 'info@ipekmuhendislik.com.tr',
            'address' => 'Mustafa Kemal Mah. 2118. Cad. No: 4/B Çankaya / ANKARA',
            'working_hours' => 'Hafta İçi: 08:30 - 18:00 | Cumartesi: 09:00 - 13:00',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        // 6. Initial References
        $this->call(ReferenceSeeder::class);
    }
}
