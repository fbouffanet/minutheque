<?php

namespace App\Controllers;

use App\Models\NotaireModel;

class Notaire extends BaseController
{
    public function migrate(): string
    {
        $ancienne_bd = \Config\Database::connect('ancien_genea');   
        $query   = $ancienne_bd->query('SELECT idf_notaire,idf_paroisse, nom FROM  notaires');
        $results = $query->getResult();
        $ancienne_bd->close();
        $a_notaires= array();
        foreach ($results as $row) {  
            $a_notaires[$row->idf_notaire]=array($row->nom,$row->idf_paroisse);
        }
        $nouvelle_bd = \Config\Database::connect();  
        $model = model(NotaireModel::class);
        foreach ($a_notaires as $idf => $a_row)
        {
            list($st_nom,$id_paroisse)=$a_row;
            $data_insert = [
                'id' => $idf,
                'nom'  => $st_nom,
                'id_paroisse' => $id_paroisse
            ];
            $model->insert($data_insert);
        }
        $nouvelle_bd->close();
        $data = [
            'liste_notaires' => $a_notaires,
        ];
        return view('notaire',$data);

    }
}
