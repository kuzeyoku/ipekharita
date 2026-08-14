<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'module_type' => 'service',
                'order' => 1,
                'is_active' => true,
                'tr' => [
                    'question' => '22/a Kadastro Yenileme Projelerinde Hangi Teknik Standartlar Uygulanır?',
                    'answer'   => '22/a Kadastro Yenileme ihalelerinde Tapu ve Kadastro Genel Müdürlüğü (TKGM) 2018/13 sayılı Genelgesi ve BÖHHBÜY (Büyük Ölçekli Harita ve Harita Bilgileri Üretim Yönetmeliği) esas alınır. Eski paftalardaki geometrik hatalar, CORS-TR GNSS ölçümleri ve yüksek çözünürlüklü İHA ortofotoları ile santimetre hassasiyetinde yenilenerek tapu kütüğüne tescil edilir.',
                ],
                'en' => [
                    'question' => 'What technical standards apply to 22/a Cadastral Renewal projects?',
                    'answer'   => 'Projects comply with General Directorate of Land Registry and Cadastre (TKGM) Circular 2018/13 and Large-Scale Mapping Regulations (BOHHBUY). Geometric legacy distortions are renewed with centimeter accuracy via CORS-TR GNSS and UAV orthophotos.',
                ],
            ],
            [
                'module_type' => 'service',
                'order' => 2,
                'is_active' => true,
                'tr' => [
                    'question' => 'Oblik (Eğik) 3D Kent Modelleme ile Klasik Ortofoto Arasındaki Fark Nedir?',
                    'answer'   => 'Klasik ortofotolar sadece 90 derece dik açıdan tek kamera ile çekilir ve bina cephelerini gösteremez. 5-kameralı Oblik (Oblique) sistemler ise 1 dik ve 4 eğik açılı kamera ile aynı anda çekim yaparak binaların ve dokuların 3 boyutlu gerek cephe gerekse çatı dokusunu (CityGML LoD2 / LoD3) üreterek akıllı kent otomasyonuna veri sağlar.',
                ],
                'en' => [
                    'question' => 'What is the difference between Oblique 3D Urban Modeling and Classic Orthophoto?',
                    'answer'   => 'Classic orthophotos only capture from a 90-degree nadir perspective. 5-camera Oblique systems capture 1 vertical and 4 diagonal angles simultaneously, generating photorealistic 3D building facades and roof meshes (CityGML LoD2 / LoD3) for smart city GIS.',
                ],
            ],
            [
                'module_type' => 'service',
                'order' => 3,
                'is_active' => true,
                'tr' => [
                    'question' => 'Airborne LiDAR Lazer Tarama Teknolojisinin Yoğun Bitki Örtüsünde Avantajı Nedir?',
                    'answer'   => 'Airborne LiDAR Lazer sistemi, saniyede 1 milyonun üzerinde lazer darbesi gönderir. Çoklu yankı (multi-echo) teknolojisi sayesinde lazer ışınları orman ve sık bitki örtüsü yapraklarının arasından sızarak doğrudan gerçek arazi zeminine (Bare Earth DEM) ulaşır ve fotogrametrinin yetersiz kaldığı sık ormanlık alanlarda hassas topoğrafya çıkarır.',
                ],
                'en' => [
                    'question' => 'What is the advantage of Airborne LiDAR in dense vegetation?',
                    'answer'   => 'Airborne LiDAR fires over 1 million laser pulses per second. Using multi-echo technology, laser pulses penetrate tree canopies to calculate true bare-earth digital elevation models (DEM) where photogrammetry is constrained.',
                ],
            ],
            [
                'module_type' => 'service',
                'order' => 4,
                'is_active' => true,
                'tr' => [
                    'question' => 'Karayolları ve TCDD Koridor Haritacılığında Teslimat Formatları Nelerdir?',
                    'answer'   => 'Koridor haritacılığı teslimatlarımız KGM ve TCDD teknik şartnamelerine tam uyumlu olarak AutoCAD DWG, Netcad NCD, MicroStation DGN, ArcGIS SHP ve 3D Nokta Bulutu (LAS/LAZ) formatlarında, eksiksiz veri sözlüğü ve kamulaştırma planları ile birlikte teslim edilmektedir.',
                ],
                'en' => [
                    'question' => 'What are the delivery formats for Highway and Railway Corridor Mapping?',
                    'answer'   => 'Deliverables comply with KGM and TCDD technical specs, delivered in AutoCAD DWG, Netcad NCD, MicroStation DGN, ArcGIS SHP, and 3D Point Cloud (LAS/LAZ) formats with complete data dictionaries and expropriation plans.',
                ],
            ],
            [
                'module_type' => 'project',
                'order' => 1,
                'is_active' => true,
                'tr' => [
                    'question' => 'Kamusal harita ihalelerinde teslimat ve hakediş süreci nasıl yürütülür?',
                    'answer'   => 'İhale şartnamesinde belirtilen iş programına göre her aşama (nirengi ağı tesisi, hava çekimi, pafta üretimi, askı ilan cetvelleri) ilgili kamu kontrol mühendislerince arazide denetlenir ve onaylanan etaplar için geçici kabul hakedişleri düzenlenir.',
                ],
                'en' => [
                    'question' => 'How is the delivery and progress payment process managed in public mapping tenders?',
                    'answer'   => 'According to the project schedule defined in the technical tender specifications, each stage is audited on-site by supervising public engineers, and progress payments are issued upon stage verification.',
                ],
            ],
            [
                'module_type' => 'project',
                'order' => 2,
                'is_active' => true,
                'tr' => [
                    'question' => 'Askı ilan sürecinde vatandaş itirazları ve teknik düzeltmeler nasıl karşılanır?',
                    'answer'   => '30 günlük yasal askı ilan süresinde iletilen teknik ve hukuki itirazlar, uzman harita ve kadastro mühendislerimiz tarafından arazi ölçü krokileri ve tapu kayıtlarıyla yeniden tetkik edilerek mevzuata uygun biçimde karara bağlanır.',
                ],
                'en' => [
                    'question' => 'How are citizen objections and technical adjustments resolved during public suspension notices?',
                    'answer'   => 'Technical and legal objections submitted during the 30-day statutory notice period are re-examined against field sketches and title records by our survey engineers for regulatory resolution.',
                ],
            ],
        ];

        foreach ($faqs as $faqData) {
            $tr = $faqData['tr'];
            $en = $faqData['en'];
            unset($faqData['tr'], $faqData['en']);

            $faqData['question'] = $tr['question'];
            $faqData['answer'] = $tr['answer'];

            $faq = Faq::create($faqData);
            $faq->syncTranslations([
                'tr' => $tr,
                'en' => $en,
            ]);
        }
    }
}
