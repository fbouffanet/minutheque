<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfessionModel extends Model
{
    protected $table = 'profession';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['id', 'nom'];

    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getProfessions($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}

?>