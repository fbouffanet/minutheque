<?php

namespace App\Controllers;

use App\Models\TypeComparutionModel;

class TypeComparution extends BaseController
{
    public function migrate(): string
    {
        $ancienne_bd = \Config\Database::connect('ancien_genea');
        $query   = $ancienne_bd->query('SELECT idf_type_presence, nom FROM types_presence');
        $results = $query->getResult();
        $ancienne_bd->close();
        $a_types_presence= array();
        foreach ($results as $row) {
            $a_types_presence[$row->idf_type_presence]=ucfirst(strtolower($row->nom));
        }
        $nouvelle_bd = \Config\Database::connect();
        foreach ($a_types_presence as $idf => $st_nom)
        {
            $model = model(TypeComparutionModel::class);
            $data_insert = [
                'id' => $idf,
                'nom'  => $st_nom,
            ];
            $model->insert($data_insert);
        }
        $data = [
            'liste_types_presence' => $a_types_presence,
        ];
        $nouvelle_bd->close();
        return view('type_comparution',$data);
    }
}
