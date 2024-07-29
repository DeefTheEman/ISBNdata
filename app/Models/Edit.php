<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Edit extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'version',
        'maintitle',
        'subtitle',
        'collectiontitle',
        'author',
        'publisher',
        'language',
        'pagecount',
        'keywords',
        'nurcode',
        'shortdescription',
    ];

    public function getFieldtype($field) {
        $table = $this->getTable();
        $type = Schema::getColumnType($table, $field);
        return $type;
    }
}
