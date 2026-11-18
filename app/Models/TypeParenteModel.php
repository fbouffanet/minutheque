<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeParenteModel extends Model
{
    protected $table = 'type_parente';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['id', 'nom'];

    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getTypesParente($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}

?>