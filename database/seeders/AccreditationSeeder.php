<?php

namespace Database\Seeders;

use App\Models\Accreditation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccreditationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $accreditations = [
            [
                'title' => "PROUD MEMBERS OF THE INSTITUTE OF\nCLERKS OF WORKS AND CONSTRUCTION\nINSPECTORATE OF GREAT BRITAIN",
                'logo' => 'accreditations/icwci-crest.webp',
                'link' => null,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => "ISO 9001:2015 REGISTERED FIRM",
                'logo' => 'accreditations/iso-9001-2015.webp',
                'link' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => "PROUD MEMBER OF THE LONDON\nCHAMBER OF COMMERCE AND INDUSTRY",
                'logo' => 'accreditations/lcci.webp',
                'link' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($accreditations as $item) {
            Accreditation::updateOrCreate(
                ['title' => $item['title']], // avoids duplicate rows on re-seed
                $item
            );
        }
    }
}
