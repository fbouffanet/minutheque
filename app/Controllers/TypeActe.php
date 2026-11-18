<?php

namespace App\Controllers;

use App\Models\TypeActeModel;

class TypeActe extends BaseController
{

    public function migrate(): string
    {
        $ancienne_bd = \Config\Database::connect('ancien_genea');   
        $query   = $ancienne_bd->query('SELECT idf_type_acte, nom FROM types_acte');
        $results = $query->getResult();
        $ancienne_bd->close();
        $a_types_acte= array();
        foreach ($results as $row) {
            $a_mots = preg_split('/\s+/',$row->nom);
           
            $a_nouveau_nom_type_acte=array();
            foreach ($a_mots as $st_mot)
            {
                array_push($a_nouveau_nom_type_acte,ucfirst(strtolower($st_mot)));
            }

            $st_nouveau_nom_type_acte = join(' ',$a_nouveau_nom_type_acte);
            $a_types_acte[$row->idf_type_acte]=$st_nouveau_nom_type_acte;
        }
        $nouvelle_bd = \Config\Database::connect();  
        $model = model(TypeActeModel::class);
        foreach ($a_types_acte as $idf => $st_nom)
        {
            $data_insert = [
                'id' => $idf,
                'nom'  => $st_nom,
            ];        
            $model->insert($data_insert);
        }
        $data = [
            'liste_types_actes' => $a_types_acte,
        ];
        $nouvelle_bd->close();
        return view('type_acte',$data);
    }
}
