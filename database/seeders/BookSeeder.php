<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'ISBN' => 9781234567897,
                'EAN' => 9781234567897,
                'ISMN' => null,
                'title' => 'Sample Book Title 1',
                'subtitle' => 'An Interesting Subtitle',
                'set_ISBN' => 9781234567898,
                'publication_date' => '2023-01-01',
                'first_publication_date' => '2022-01-01',
                'author' => 'John Doe',
                'product_form' => 'Hardcover',
                'ebook_format' => null,
                'drm_type' => 'None',
                'edition_type' => 'First',
                'edition' => 1,
                'pages' => 350,
                'file_size_or_duration' => null,
                'dimensions' => '8.5 x 11 inches',
                'weight' => 500,
                'illustrations' => 10,
                'language' => 'English',
                'original_language' => 'French',
                'original_title' => 'Titre Original',
                'nur_code' => 123,
                'nur_language' => 'English',
                'avi_code' => null,
                'avi_language' => null,
                'geo_code' => 'US',
                'flap_text' => 'This is a flap text.',
                'short_description' => 'This is a short description of the book.',
                'series' => 'Sample Series',
                'primary_image' => 'primary_image.jpg',
                'secondary_images' => json_encode(['image1.jpg', 'image2.jpg']),
                'available_CB' => true,
                'available_CBC' => false,
                'release_date' => '2023-02-01',
                'translator' => 'Jane Smith',
                'illustrator' => 'Bob Ross',
                'theme' => 'Adventure',
                'keywords' => json_encode(['adventure', 'journey', 'hero']),
                'price' => 19.99,
                'related_products' => json_encode([2, 3, 4]),
            ],
            [
                'ISBN' => 9781234567899,
                'EAN' => 9781234567899,
                'ISMN' => null,
                'title' => 'Sample Book Title 2',
                'subtitle' => 'Another Interesting Subtitle',
                'set_ISBN' => 9781234567900,
                'publication_date' => '2023-03-01',
                'first_publication_date' => '2021-05-01',
                'author' => 'Jane Roe',
                'product_form' => 'Softcover',
                'ebook_format' => null,
                'drm_type' => 'Simple',
                'edition_type' => 'Revised',
                'edition' => 2,
                'pages' => 275,
                'file_size_or_duration' => null,
                'dimensions' => '6 x 9 inches',
                'weight' => 400,
                'illustrations' => 5,
                'language' => 'Dutch',
                'original_language' => 'Dutch',
                'original_title' => 'Oorspronkelijke Titel',
                'nur_code' => 456,
                'nur_language' => 'Dutch',
                'avi_code' => null,
                'avi_language' => null,
                'geo_code' => 'NL',
                'flap_text' => 'This is another flap text.',
                'short_description' => 'This is another short description of the book.',
                'series' => 'Another Series',
                'primary_image' => 'another_primary_image.jpg',
                'secondary_images' => json_encode(['image3.jpg', 'image4.jpg']),
                'available_CB' => true,
                'available_CBC' => true,
                'release_date' => '2023-04-01',
                'translator' => 'John Smith',
                'illustrator' => 'Alice Johnson',
                'theme' => 'Mystery',
                'keywords' => json_encode(['mystery', 'investigation', 'detective']),
                'price' => 14.99,
                'related_products' => json_encode([1, 3, 5]),
            ],
        ]);
    }
}
