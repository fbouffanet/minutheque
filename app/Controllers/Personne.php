<?php

namespace App\Controllers;
use App\Models\PersonneModel;
use App\Models\RelationParenteModel;
use App\Libraries\Phonex;

class Personne extends BaseController
{
    private function phonex($st_nom)
    {
        $phonex = new Phonex();
        if (!empty($st_nom))
        {
            $phonex->build($st_nom);
            return $phonex->get();
        }
        else
        {
            return 0;
        }
    }

    public function migrate(): string
    {
        $ancienne_bd = \Config\Database::connect('ancien_genea'); 
        $fp = fopen('e:\migre_log', 'w');    
        //$query   = $ancienne_bd->query('SELECT idf_personne,idf_acte,idf_type_presence,nom,prenom,surnom,idf_profession,idf_paroisse_residence, idf_paroisse_origine,sexe, commentaires, idf_type_parente,idf_parent,nom_excjt,prenom_excjt,surnom_excjt,nom_pere,prenom_pere,surnom_pere,idf_profession_pere,idf_paroisse_pere,pere_decede,nom_mere,prenom_mere,mere_decedee FROM personnes where idf_acte in (select idf_acte from actes) and idf_profession in (select idf_profession from professions) and idf_parent in (select idf_personne from personnes) and idf_type_parente in (select idf_type_parente from types_parente)');
        $query   = $ancienne_bd->query('SELECT idf_personne,idf_acte,idf_type_presence,nom,prenom,surnom,idf_profession,idf_paroisse_residence, idf_paroisse_origine,sexe, commentaires, idf_type_parente,idf_parent,nom_excjt,prenom_excjt,surnom_excjt,nom_pere,prenom_pere,surnom_pere,idf_profession_pere,idf_paroisse_pere,pere_decede,nom_mere,prenom_mere,mere_decedee FROM personnes where idf_acte in (select idf_acte from actes) and (idf_profession=0 or idf_profession in (select idf_profession from professions)) and (idf_parent=0 or idf_parent in (select idf_personne from personnes)) and (idf_type_parente=0 or idf_type_parente in (select idf_type_parente from types_parente))');
        $results = $query->getResult();
        $ancienne_bd->close();
        $a_parties_comparantes= array();
        foreach ($results as $row) {
            $a_parties_comparantes[$row->idf_personne]=array($row->idf_acte,$row->idf_type_presence,$row->nom,$row->prenom,$row->surnom,$row->idf_profession,$row->idf_paroisse_residence,$row->idf_paroisse_origine,$row->sexe,$row->commentaires,$row->idf_type_parente,$row->idf_parent,$row->nom_excjt,$row->prenom_excjt,$row->surnom_excjt,$row->nom_pere,$row->prenom_pere,$row->surnom_pere,$row->idf_profession_pere,$row->idf_paroisse_pere,$row->pere_decede,$row->nom_mere,$row->prenom_mere,$row->mere_decedee);
            $line=join(array($row->idf_acte,$row->idf_personne,$row->idf_type_presence,$row->nom,$row->prenom));
            fwrite($fp,"$line\n");
        }
        $nouvelle_bd = \Config\Database::connect();  
        $model = model(PersonneModel::class);
        $a_parentes_a_ajouter= array();
        $a_cjts_a_ajouter=array();
        $a_peres_a_ajouter=array();
        $a_meres_a_ajouter=array();
        foreach ($a_parties_comparantes as $idf_personne => $a_row)
        {
            list($idf_acte,$idf_type_comparution,$st_nom,$st_prenom,$st_surnom,$i_idf_profession,$i_idf_paroisse_residence,$i_idf_paroisse_origine,$st_sexe,$st_commentaires,$idf_type_parente,$idf_parent,$st_nom_excjt,$st_prenom_excjt,$st_surnom_excjt,$st_nom_pere,$st_prenom_pere,$st_surnom_pere,$i_idf_profession_pere,$i_idf_paroisse_pere,$i_pere_decede,$st_nom_mere,$st_prenom_mere,$i_mere_decedee)=$a_row;
            if ($st_nom_excjt!='')
            {
                if ($st_sexe=='M')
                {
                    array_push($a_cjts_a_ajouter,array($idf_acte,$idf_personne,'F',$st_nom_excjt,$st_prenom_excjt,$st_surnom_excjt));
                }
                else if ($st_sexe=='F')
                {
                    array_push($a_cjts_a_ajouter,array($idf_acte,$idf_personne,'M',$st_nom_excjt,$st_prenom_excjt,$st_surnom_excjt));
                }
            }
            if ($st_nom_pere!='')
            {
                array_push($a_peres_a_ajouter,array($idf_acte,$idf_personne,$st_nom_pere,$st_prenom_pere,$st_surnom_pere,$i_idf_profession_pere,$i_idf_paroisse_pere,$i_pere_decede));
            }
            if ($st_nom_mere!='')
            {
                array_push($a_meres_a_ajouter,array($idf_acte,$idf_personne,$st_nom_mere,$st_prenom_mere,$i_mere_decedee));
            }
            $idf_profession = $i_idf_profession==0? null : $i_idf_profession;
            $idf_paroisse_residence = $i_idf_paroisse_residence==0? null : $i_idf_paroisse_residence;
            $idf_paroisse_origine = $i_idf_paroisse_origine==0? null : $i_idf_paroisse_origine;
            $idf_type_parente = $idf_type_parente==0? null : $idf_type_parente;
            $idf_parent = $idf_parent==0? null : $idf_parent;
            $f_phonex_nom=$this->phonex($st_nom);
            $f_phonex_prenom=$this->phonex($st_prenom);
            $f_phonex_surnom=$this->phonex($st_surnom);
            $data_insert = [
                'id' => $idf_personne,
                'id_acte'=>$idf_acte,
                'id_type_comparution' => $idf_type_comparution,
                'sexe' => $st_sexe,
                'nom'  => $st_nom,
                'prenom'  => $st_prenom,
                'surnom'  => $st_surnom,
                'id_profession' => $idf_profession,
                'id_paroisse_origine' => $idf_paroisse_origine,
                'id_paroisse_residence' => $idf_paroisse_residence,
                'commentaires'=>$st_commentaires,
                'phonex_nom'=>$f_phonex_nom,
                'phonex_prenom'=>$f_phonex_prenom,
                'phonex_surnom'=>$f_phonex_surnom
            ];
            $model->insert($data_insert);
            if ($idf_type_parente!=NULL and $idf_parent!=NULL)
            {
                array_push($a_parentes_a_ajouter,array($idf_personne,$idf_parent,$idf_type_parente));
            }                       
        }
        $relation_parente_model = model(RelationParenteModel::class);
        $a_pere_to_update= array();
        foreach ($a_peres_a_ajouter as $a_pere)
        {
            list($idf_acte,$idf_personne,$st_nom_pere,$st_prenom_pere,$st_surnom_pere,$i_idf_profession_pere,$i_idf_paroisse_pere,$i_pere_decede)=$a_pere;
            $f_phonex_nom_pere=$this->phonex($st_nom_pere);
            $f_phonex_prenom_pere=$this->phonex($st_prenom_pere);
            $f_phonex_surnom_pere=$this->phonex($st_surnom_pere);
            $i_idf_profession_pere = $i_idf_profession_pere==0? null : $i_idf_profession_pere;
            $i_idf_paroisse_pere = $i_idf_paroisse_pere==0? null : $i_idf_paroisse_pere;
            $data_insert = [
                'id_acte'=>$idf_acte,
                'id_type_comparution' => 13,
                'sexe' => 'M',
                'nom'  => $st_nom_pere,
                'prenom'  => $st_prenom_pere,
                'surnom'  => $st_surnom_pere,
                'id_profession' => $i_idf_profession_pere,
                'id_paroisse_residence' => $i_idf_paroisse_pere,
                'phonex_nom'=>$f_phonex_nom_pere,
                'phonex_prenom'=>$f_phonex_prenom_pere,
                'phonex_surnom'=>$f_phonex_surnom_pere,
                'decede'=> $i_pere_decede
            ];
            $id_pere=$model->insert($data_insert);
            $a_pere_to_update[$idf_personne]=$id_pere;
        }
        $a_mere_to_update= array();
        foreach ($a_meres_a_ajouter as $a_mere)
        {
            list($idf_acte,$idf_personne,$st_nom_mere,$st_prenom_mere,$i_mere_decedee)=$a_mere;
            $f_phonex_nom_mere=$this->phonex($st_nom_mere);
            $f_phonex_prenom_mere=$this->phonex($st_prenom_mere);
            $data_insert = [
                'id_acte'=>$idf_acte,
                'id_type_comparution' => 13,
                'sexe' => 'F',
                'nom'  => $st_nom_mere,
                'prenom'  => $st_prenom_mere,
                'phonex_nom'=>$f_phonex_nom_mere,
                'phonex_prenom'=>$f_phonex_prenom_mere,
                'decede'=> $i_mere_decedee
            ];
            $id_mere=$model->insert($data_insert);
            $a_mere_to_update[$idf_personne]=$id_mere;
        }
        foreach ($a_pere_to_update as $idf_personne => $idf_pere)
        {
            $relation__pere = [
                    'id_parent' => $idf_personne,
                    'id_personne' => $idf_pere,
                    'id_type_parente'=> 3
                ];
            $relation_parente_model->insert($relation__pere);  
        }
        foreach ($a_mere_to_update as $idf_personne => $idf_mere)
        {
            $relation__mere = [
                    'id_parent' => $idf_personne,
                    'id_personne' => $idf_mere,
                    'id_type_parente'=> 4
                ];
            $relation_parente_model->insert($relation__mere);  
        }
      
        foreach ($a_pere_to_update as $idf_personne => $id_pere)
        {
            if (array_key_exists($idf_personne,$a_mere_to_update))
            {
                $couple_parents = [
                    'id_personne' => $id_pere,
                    'id_parent' => $a_mere_to_update[$idf_personne],
                    'id_type_parente'=> 1
                ];
                $relation_parente_model->insert($couple_parents);
            }
        }
        foreach($a_cjts_a_ajouter as $cjt)
        {
            list($idf_acte,$idf_personne,$st_sexe,$st_nom_excjt,$st_prenom_excjt,$st_surnom_excjt)=$cjt;
            $f_phonex_nom_excjt=$this->phonex($st_nom_excjt);
            $f_phonex_prenom_excjt=$this->phonex($st_prenom_excjt);
            $f_phonex_surnom_excjt=$this->phonex($st_surnom_excjt);
            $data_insert = [
                'id_acte'=>$idf_acte,
                'id_type_comparution' => 13,
                'sexe' => $st_sexe,
                'nom'  => $st_nom_excjt,
                'prenom'  => $st_prenom_excjt,
                'surnom' => $st_surnom_excjt, 
                'phonex_nom'=>$f_phonex_nom_excjt,
                'phonex_prenom'=>$f_phonex_prenom_excjt,
                'phonex_surnom'=>$f_phonex_surnom_excjt,
                'decede'=> 1
            ];
            $id_cjt=$model->insert($data_insert);
            $couple_parents = [
                    'id_personne' => $id_cjt,
                    'id_parent'=> $idf_personne,
                    'id_type_parente'=> 2
                ];
            $relation_parente_model->insert($couple_parents);
        }
        foreach ($a_parentes_a_ajouter as $a_row)
        {
            list($idf_personne,$idf_parent,$idf_type_parente)=$a_row;
            $data2_insert = [
                'id_personne' => $idf_personne,
                'id_parent' => $idf_parent,
                'id_type_parente' => $idf_type_parente
            ];
            $relation_parente_model->insert($data2_insert);        
        }
        $nouvelle_bd->close();
        fclose($fp); 
        $data = [
            'liste_personnes' => $a_parties_comparantes,
        ];
        return view('migration_parties',$data);    
    }
    
}
