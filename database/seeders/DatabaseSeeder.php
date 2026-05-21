<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN USERS (Admin & Anggota Kelompok 6)
        $users = [
            [
                'name' => 'Super Admin',
                'id_anggota' => 'ADM-001',
                'kontak' => '081234567890',
                'email' => 'admin@perpus.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Fitrandi Sabila Mustaqim',
                'id_anggota' => '21120124130061',
                'kontak' => '085123456701',
                'email' => 'fitrandi@student.undip.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Farhan Fahrezi',
                'id_anggota' => '21120124130092',
                'kontak' => '085123456702',
                'email' => 'farhan@student.undip.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Satria Bintang Sangaji',
                'id_anggota' => '21120123100000', // Sesuai D2
                'kontak' => '085123456703',
                'email' => 'satria@student.undip.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Zaki Rahmat Al Aziz',
                'id_anggota' => '21120124130054',
                'kontak' => '085123456704',
                'email' => 'zaki@student.undip.ac.id',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }

        // 2. BUAT KATEGORI BUKU
        $categories = [
            'Teknik Komputer & Pemrograman',
            'Sejarah Militer & Taktik',
            'Otomotif & Rekayasa Mesin',
            'Fiksi & Sastra Psikologis',
            'Seni & Musik Klasik'
        ];

        $categoryIds = [];
        foreach ($categories as $catName) {
            $category = Category::firstOrCreate(['nama_kategori' => $catName]);
            $categoryIds[$catName] = $category->id;
        }

        // 3. BUAT KATALOG BUKU
        $books = [
            // Teknik Komputer & Pemrograman
            ['judul_buku' => 'Operating Systems Design and Implementation', 'penulis' => 'Andrew S. Tanenbaum', 'isbn' => '978-0131429383', 'category_id' => $categoryIds['Teknik Komputer & Pemrograman'], 'stok' => 5],
            ['judul_buku' => 'Advanced Engineering Mathematics', 'penulis' => 'Erwin Kreyszig', 'isbn' => '978-0470458365', 'category_id' => $categoryIds['Teknik Komputer & Pemrograman'], 'stok' => 3],
            ['judul_buku' => 'Mastering Luau Scripting for Game Dev', 'penulis' => 'Roblox Corporation', 'isbn' => '978-1234567890', 'category_id' => $categoryIds['Teknik Komputer & Pemrograman'], 'stok' => 8],
            ['judul_buku' => '3D Modeling in Blender: A Comprehensive Guide', 'penulis' => 'Jason van Gumster', 'isbn' => '978-1119617269', 'category_id' => $categoryIds['Teknik Komputer & Pemrograman'], 'stok' => 4],
            ['judul_buku' => 'Wave Physics and Naval Ballistics', 'penulis' => 'Dr. H. Nelson', 'isbn' => '978-0987654321', 'category_id' => $categoryIds['Teknik Komputer & Pemrograman'], 'stok' => 2],

            // Sejarah Militer & Taktik
            ['judul_buku' => 'Austerlitz 1805: The Fate of Empires', 'penulis' => 'Ian Castle', 'isbn' => '978-1841761367', 'category_id' => $categoryIds['Sejarah Militer & Taktik'], 'stok' => 4],
            ['judul_buku' => 'The Campaigns of Marshal Davout', 'penulis' => 'John G. Gallaher', 'isbn' => '978-0806132066', 'category_id' => $categoryIds['Sejarah Militer & Taktik'], 'stok' => 3],
            ['judul_buku' => 'Borodino and the War of 1812', 'penulis' => 'Christopher Duffy', 'isbn' => '978-0684131733', 'category_id' => $categoryIds['Sejarah Militer & Taktik'], 'stok' => 2],
            ['judul_buku' => 'Das Boot: A U-Boat Narrative', 'penulis' => 'Lothar-Günther Buchheim', 'isbn' => '978-0304352317', 'category_id' => $categoryIds['Sejarah Militer & Taktik'], 'stok' => 5],

            // Otomotif & Rekayasa Mesin
            ['judul_buku' => 'JDM Legends: The Golden Era of Japanese Tuning', 'penulis' => 'Takahiro Suzuki', 'isbn' => '978-3456789012', 'category_id' => $categoryIds['Otomotif & Rekayasa Mesin'], 'stok' => 6],
            ['judul_buku' => 'Tuning the Mitsubishi Galant VR-4', 'penulis' => 'David Visard', 'isbn' => '978-4567890123', 'category_id' => $categoryIds['Otomotif & Rekayasa Mesin'], 'stok' => 2],
            ['judul_buku' => 'Automotive Aerodynamics & Performance Setups', 'penulis' => 'Joseph Katz', 'isbn' => '978-0837616150', 'category_id' => $categoryIds['Otomotif & Rekayasa Mesin'], 'stok' => 4],

            // Fiksi & Sastra Psikologis
            ['judul_buku' => 'Neon Genesis: The Psychological Impact', 'penulis' => 'Hideaki Anno', 'isbn' => '978-5678901234', 'category_id' => $categoryIds['Fiksi & Sastra Psikologis'], 'stok' => 7],
            ['judul_buku' => 'Barry Lyndon: A Novel', 'penulis' => 'William Makepeace Thackeray', 'isbn' => '978-0199536719', 'category_id' => $categoryIds['Fiksi & Sastra Psikologis'], 'stok' => 3],
            ['judul_buku' => 'War and Peace', 'penulis' => 'Leo Tolstoy', 'isbn' => '978-1400079988', 'category_id' => $categoryIds['Fiksi & Sastra Psikologis'], 'stok' => 10],

            // Seni & Musik Klasik
            ['judul_buku' => 'Beethoven\'s Symphonies: A Comprehensive Guide', 'penulis' => 'George Grove', 'isbn' => '978-6789012345', 'category_id' => $categoryIds['Seni & Musik Klasik'], 'stok' => 4],
            ['judul_buku' => 'Tchaikovsky and the 1812 Overture', 'penulis' => 'David Brown', 'isbn' => '978-7890123456', 'category_id' => $categoryIds['Seni & Musik Klasik'], 'stok' => 3],
            ['judul_buku' => 'The Composition of Wellington\'s Victory', 'penulis' => 'Alexander Wheelock Thayer', 'isbn' => '978-8901234567', 'category_id' => $categoryIds['Seni & Musik Klasik'], 'stok' => 2],
        ];

        foreach ($books as $bookData) {
            Book::firstOrCreate(['judul_buku' => $bookData['judul_buku']], $bookData);
        }
    }
}