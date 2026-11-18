<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonneModel extends Model
{
    protected $table = 'personne';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['id', 'id_acte','id_type_comparution','sexe','nom','prenom','surnom','id_profession','id_paroisse_origine','id_paroisse_residence','commentaires','phonex_nom','phonex_prenom','phonex_surnom','id_pere','id_mere','decede'];

    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getActes($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}

?>