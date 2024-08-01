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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Initialize all attributes to null
        $this->attributes = array_fill_keys($this->getFillable(), null);
    }

    public function getFields() {
        //Outputs all possible book fields, and a boolean depending on whether its an array
        $fields = [
            'outputname' => 'string',
            'productform' => 'string',
            'collectiontitle' => 'string',
            'collectionsubtitle' => 'string',
            'collectionpart' => 'string',
            'maintitle' => 'string',
            'subtitle' => 'string',
            'titleinoriginallanguage' => 'string',
            'contributors' => '[json]', //json is {"role", "firstname", "middlename", "name"}
            'languagecode' => 'string',
            'pagecount' => 'integer',
            'illustrated' => 'string', //Of bool??
            'nurcodes' => '[integer]',
            'keyword' => '[string]',
            'shortdescription' => 'text',
            'covercopy' => 'text',
            'reviews' => '[text]',
            'publishernote' => 'text',
            'imprintName' => 'string',
            'publisherid' => 'integer',
            'publishername' => 'string',
            'publishingstatus' => 'string',
            'publishingdate' => 'date',
            'nstc' => 'integer',
            'keywords' => '[string]',
            'relatedtolist' => '[integer]',
            'replacedby' => 'string', //geen idee
            'price' => 'decimal',
            'imprintname' => 'string',
        ];
        return $fields;
    }

    public function getFieldtype($field) {
        $table = $this->getTable();
        $type = Schema::getColumnType($table, $field);
        return $type;
    }
}
