<?php

namespace App\Controllers;

use App\Models\ReleveurModel;

class Releveur extends BaseController
{
    public function migrate(): string
    {
        $ancienne_bd = \Config\Database::connect('ancien_genea');   
        $query   = $ancienne_bd->query('SELECT idf_redacteur,nom,login,password,email FROM redacteurs');
        $results = $query->getResult();
        $ancienne_bd->close();
        $a_releveurs= array();
        foreach ($results as $row) {
            if (preg_match('/[\w-]+\s+[\w-]+/',$row->nom))
            {
                list($st_prenom,$st_nom) = preg_split('/\s+/',$row->nom,2);
                $st_nom=strtoupper($st_nom);
            }
            else
            {
                $st_nom =$row->nom;
                $st_prenom='';
            }
            $a_releveurs[$row->idf_redacteur]=array($st_nom,$st_prenom,$row->login,$row->password,$row->email);
        }
        $nouvelle_bd = \Config\Database::connect();  
        $model = model(ReleveurModel::class);
        foreach ($a_releveurs as $idf_releveur => $a_row)
        {
            list($st_nom,$st_prenom,$st_login,$st_password,$st_email)=$a_row;
            $data_insert = [
                'id' => $idf_releveur,
                'nom'  => $st_nom,
                'prenom' => $st_prenom,
                'email' => $st_email,
                'ident'=>$st_login,
                'mdp'=> $st_password
            ];   
            $model->insert($data_insert);
        }
        $data = [
            'liste_releveurs' => $a_releveurs,
        ];

        $nouvelle_bd->close();
        return view('releveur',$data);
    }
}


        