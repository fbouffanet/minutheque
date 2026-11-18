<?php

namespace App\Controllers;

use App\Models\ProfessionModel;

class Profession extends BaseController
{
    public function index(): string
    {
        $ancienne_bd = \Config\Database::connect('ancien_genea');
        $professions=$ancienne_bd->query('select nom from professions order by nom');
        $resultat='';
        foreach ($professions->getResult() as $row) {
            $resultat.=$row->nom.'<br>';

        }
        return $resultat;
    }

    public function migrate(): string
    {
        $ancienne_bd = \Config\Database::connect('ancien_genea');   
        $query   = $ancienne_bd->query('SELECT idf_profession, nom FROM professions');
        $results = $query->getResult();
        $ancienne_bd->close();
        $a_professions= array();
        foreach ($results as $row) {
            $a_mots = preg_split('/\s+/',$row->nom);
            $a_nouveau_nom_profession=array();
            foreach ($a_mots as $st_mot)
            {
                array_push($a_nouveau_nom_profession,ucfirst(strtolower($st_mot)));
            }
            $st_nouveau_nom_profession = join(' ',$a_nouveau_nom_profession);
            $a_professions[$row->idf_profession]=$st_nouveau_nom_profession;
        }
        $nouvelle_bd = \Config\Database::connect();  
        $model = model(ProfessionModel::class);
        foreach ($a_professions as $idf => $st_nom)
        {
            $data_insert = [
                'id' => $idf,
                'nom'  => $st_nom,
            ];
            $model->insert($data_insert);
        }
        $data = [
            'liste_professions' => $a_professions,
        ];        
        return view('profession',$data);
    }
}
