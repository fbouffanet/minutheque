<?php

namespace App\Models;

use CodeIgniter\Model;

class ReleveurModel extends Model
{
    protected $table = 'releveur';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['id', 'nom','prenom','email','ident','mdp'];

    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getReleveurs($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}

?>