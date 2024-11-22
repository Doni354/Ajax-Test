<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaceModel extends Model
{
    protected $table = 'places';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description'];

    // Fungsi untuk mengambil data dengan pagination
    public function getPlaces($limit, $offset)
    {
        return $this->orderBy('id', 'ASC')->findAll($limit, $offset);
    }
}
