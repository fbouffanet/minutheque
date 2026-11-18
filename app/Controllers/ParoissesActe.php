<?php

namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;

class ParoissesActe extends BaseController
{
    public function migrate(): string
    {
        $ancienne_bd = \Config\Database::connect('ancien_genea');    
        $query   = $ancienne_bd->query('select distinct idf_acte,idf_paroisse from lieux_acte where idf_acte in (select idf_acte from actes) and idf_paroisse in (select idf_paroisse from paroisses)');
        $results = $query->getResult();
        $ancienne_bd->close();
        $a_paroisses_acte= array();
        foreach ($results as $row) {
            array_push($a_paroisses_acte,array($row->idf_acte,$row->idf_paroisse));
        }
        $nouvelle_bd = \Config\Database::connect();  
        foreach ($a_paroisses_acte as $a_row)
        {   
            list($idf_acte,$idf_paroisse)=$a_row;
            $sql = 'INSERT INTO paroisses_acte (id_paroisse, id_acte) VALUES (' . $nouvelle_bd->escape($idf_paroisse) . ', ' . $nouvelle_bd->escape($idf_acte) . ')';
            $nouvelle_bd->query($sql); 
        }
        $nouvelle_bd->close();
        $data = [
            'liste_paroisses_actes' => $a_paroisses_acte,
        ]; 
        return view('paroisses_acte',$data);
    }
}
