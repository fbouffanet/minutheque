<?php

namespace App\Controllers;

use App\Models\TypeParenteModel;

class TypeParente extends BaseController
{

    public function migrate(): string
    {
        $ancienne_bd = \Config\Database::connect('ancien_genea');   
        $query   = $ancienne_bd->query('SELECT idf_type_parente, nom FROM types_parente');
        $results = $query->getResult();
        $ancienne_bd->close();
        $a_types_parente= array();
        foreach ($results as $row) {
            $a_types_parente[$row->idf_type_parente]=ucfirst(strtolower($row->nom));
        }
        $nouvelle_bd = \Config\Database::connect();  
        $model = model(TypeParenteModel::class);
        foreach ($a_types_parente as $idf => $st_nom)
        {
            $data_insert = [
                'id' => $idf,
                'nom'  => $st_nom,
            ];        
            $model->insert($data_insert);
        }
        $data = [
            'liste_types_parente' => $a_types_parente,
        ];
        $nouvelle_bd->close();
        return view('types_parente',$data);
    }
}
