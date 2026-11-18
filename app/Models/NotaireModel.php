<?php

namespace App\Models;

use CodeIgniter\Model;

class NotaireModel extends Model
{
    protected $table = 'notaire';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['id', 'nom','prenom','id_paroisse'];

    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getNotaires($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}

?>