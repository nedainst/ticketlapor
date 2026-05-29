<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Infrastruktur',
                'slug' => 'infrastruktur',
                'description' => 'Laporan terkait jalan rusak, jembatan, gedung publik, dan infrastruktur lainnya',
                'icon' => 'building-office',
                'color' => '#3B82F6',
                'sort_order' => 1,
            ],
            [
                'name' => 'Pelayanan Publik',
                'slug' => 'pelayanan-publik',
                'description' => 'Keluhan terkait pelayanan di kantor pemerintahan, rumah sakit, sekolah, dll',
                'icon' => 'user-group',
                'color' => '#8B5CF6',
                'sort_order' => 2,
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'description' => 'Pengaduan terkait sekolah, guru, fasilitas pendidikan, dan beasiswa',
                'icon' => 'academic-cap',
                'color' => '#10B981',
                'sort_order' => 3,
            ],
            [
                'name' => 'Kesehatan',
                'slug' => 'kesehatan',
                'description' => 'Laporan terkait rumah sakit, puskesmas, obat, dan layanan kesehatan',
                'icon' => 'heart',
                'color' => '#EF4444',
                'sort_order' => 4,
            ],
            [
                'name' => 'Keamanan',
                'slug' => 'keamanan',
                'description' => 'Pengaduan terkait keamanan lingkungan, kriminalitas, dan ketertiban umum',
                'icon' => 'shield-check',
                'color' => '#F59E0B',
                'sort_order' => 5,
            ],
            [
                'name' => 'Lingkungan',
                'slug' => 'lingkungan',
                'description' => 'Laporan pencemaran, sampah, banjir, dan masalah lingkungan hidup',
                'icon' => 'globe-americas',
                'color' => '#059669',
                'sort_order' => 6,
            ],
            [
                'name' => 'Transportasi',
                'slug' => 'transportasi',
                'description' => 'Keluhan terkait angkutan umum, lalu lintas, parkir, dan transportasi',
                'icon' => 'truck',
                'color' => '#6366F1',
                'sort_order' => 7,
            ],
            [
                'name' => 'Lainnya',
                'slug' => 'lainnya',
                'description' => 'Pengaduan dan saran yang tidak masuk kategori di atas',
                'icon' => 'ellipsis-horizontal-circle',
                'color' => '#6B7280',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
