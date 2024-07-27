<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Edittedbook extends Model
{
    use HasFactory;


    protected $fillable = [
        'ISBN',
        'EAN',
        'ISMN',
        'title',
        'subtitle',
        'set_ISBN',
        'publication_date',
        'first_publication_date',
        'author',
        'product_form',
        'ebook_format',
        'drm_type',
        'edition_type',
        'edition',
        'pages',
        'file_size_or_duration',
        'dimensions',
        'weight',
        'illustrations',
        'language',
        'original_language',
        'original_title',
        'nur_code',
        'nur_language',
        'avi_code',
        'avi_language',
        'geo_code',
        'flap_text',
        'short_description',
        'series',
        'primary_image',
        'secondary_images',
        'available_CB',
        'available_CBC',
        'release_date',
        'translator',
        'illustrator',
        'theme',
        'keywords',
        'price',
        'related_products'
    ];

    public function getFieldtype($field) {
        $table = $this->getTable();
        $type = Schema::getColumnType($table, $field);
        return $type;
    }
   
}
