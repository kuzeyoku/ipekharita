<?php

namespace Database\Seeders;

use App\Models\Reference;
use Illuminate\Database\Seeder;

class ReferenceSeeder extends Seeder
{
    public function run(): void
    {
        $references = [
            [
                'title' => 'TKGM - Tapu ve Kadastro Genel Müdürlüğü',
                'logo' => 'assets/img/references/tkgm.svg',
                'url' => 'https://www.tkgm.gov.tr',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'KGM - Karayolları Genel Müdürlüğü',
                'logo' => 'assets/img/references/kgm.svg',
                'url' => 'https://www.kgm.gov.tr',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'DSİ - Devlet Su İşleri Genel Müdürlüğü',
                'logo' => 'assets/img/references/dsi.svg',
                'url' => 'https://www.dsi.gov.tr',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'NVİ - Nüfus ve Vatandaşlık İşleri (MAKS)',
                'logo' => 'assets/img/references/nvi.svg',
                'url' => 'https://www.nvi.gov.tr',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'OGM - Orman Genel Müdürlüğü',
                'logo' => 'assets/img/references/ogm.svg',
                'url' => 'https://www.ogm.gov.tr',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'TCDD - T.C. Devlet Demiryolları',
                'logo' => 'assets/img/references/tcdd.svg',
                'url' => 'https://www.tcdd.gov.tr',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Çevre, Şehircilik ve İklim Değişikliği Bakanlığı',
                'logo' => 'assets/img/references/csb.svg',
                'url' => 'https://csb.gov.tr',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'İller Bankası A.Ş. (İLBANK)',
                'logo' => 'assets/img/references/ilbank.svg',
                'url' => 'https://www.ilbank.gov.tr',
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($references as $ref) {
            Reference::updateOrCreate(
                ['title' => $ref['title']],
                $ref
            );
        }
    }
}
