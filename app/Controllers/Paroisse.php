<?php

namespace App\Controllers;

use App\Models\ParoisseModel;

class Paroisse extends BaseController
{
    public function migrate(): string
    {
        $ancienne_bd = \Config\Database::connect('ancien_genea');   
        $query   = $ancienne_bd->query('SELECT idf_paroisse, nom FROM paroisses');
        $results = $query->getResult();
        $ancienne_bd->close();
        $a_paroisses= array();
        foreach ($results as $row) {
            $a_mots = preg_split('/\s+/',$row->nom);
           
            $a_nouveau_nom_paroisse=array();
            foreach ($a_mots as $st_mot)
            {
                array_push($a_nouveau_nom_paroisse,ucfirst(strtolower($st_mot)));
            }
            $st_nouveau_nom_paroisse = join(' ',$a_nouveau_nom_paroisse);
            $a_paroisses[$row->idf_paroisse]=$st_nouveau_nom_paroisse;
        }
        $nouvelle_bd = \Config\Database::connect();  
        $model = model(ParoisseModel::class);
        foreach ($a_paroisses as $idf => $st_nom)
        {

            $data_insert = [
                'id' => $idf,
                'nom'  => $st_nom,
            ];
            $model->insert($data_insert);
        }
        $data = [
            'liste_paroisses' => $a_paroisses,
        ];
        return view('paroisse',$data);
    }
}
