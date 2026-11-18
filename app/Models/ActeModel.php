<?php

namespace App\Models;

use CodeIgniter\Model;

class ActeModel extends Model
{
    protected $table = 'acte';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['id', 'id_source_acte','id_notaire','id_type_acte','id_releveur','id_paroisse_signature','id_reference_autre_acte','date','date_rep','date_enregistrement','date_rep_enregistrement','cote','resume','transcription','url','date_creation','date_modification','commentaires'];

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