<?php

namespace App\Models;

use CodeIgniter\Model;

class RelationParenteModel extends Model
{
    protected $table = 'relation_parente';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['id', 'id_personne','id_parent','id_type_parente'];

    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getRelationsParente($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}

?>