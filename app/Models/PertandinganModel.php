<?php

namespace App\Models;

use CodeIgniter\Model;

class PertandinganModel extends Model
{
    protected $table = 'pertandingan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['klub_home', 'klub_away', 'skor_home', 'skor_away'];
}
