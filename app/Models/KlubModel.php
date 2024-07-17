<?php

namespace App\Models;

use CodeIgniter\Model;

class KlubModel extends Model
{
    protected $table = 'klub';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_klub', 'asal_klub'];
}
