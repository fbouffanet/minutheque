<?php

namespace App\Controllers;
use App\Models\ActeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Acte extends BaseController
{
    public function migrate(): string
    {
        $ga_mois_revolutionnaires       = array(                          
            1=> 'Vendémiaire',                 
            2=> 'Brumaire',                    
            3=> 'Frimaire',                    
            4=> 'Nivôse',                      
            5=> 'Pluviôse',                    
            6=> 'Ventôse',                     
            7=> 'Germinal',                    
            8=> 'Floréal',                     
            9=> 'Prairial',                    
            10=> 'Messidor',                   
            11=> 'Thermidor',                  
            12=> 'Fructidor',
            13=> 'Complémentaires'                   
           );

        $ga_mois_revolutionnaires_nimegue       = array(                          
            1=> 'Vend',                 
            2=> 'Brum',                   
            3=> 'Frim',                    
            4=> 'Nivo',                     
            5=> 'Pluv',                    
            6=> 'Vent',                     
            7=> 'Germ',                    
            8=> 'Flor',                    
            9=> 'Prai',                   
            10=> 'Mess',                  
            11=> 'Ther',                  
            12=> 'Fruc',
            13=> 'Comp',                  
           );                               
        
        $ga_annees_revolutionnaires      = array(                            
            2 =>'An II',                       
            3=>'An III',                      
            4=>'An IV',                       
            5=>'An V',                        
            6=>'An VI',                       
            7=>'An VII',                      
            8=>'An VIII',                     
            9=>'An IX',                       
            10=>'An X',                       
            11=>'An XI',                      
            12=>'An XII',                     
            13=>'An XIII',                    
            14=>'An XIV'                      
            );
        $gst_rep_textes = 'E:\Documents\Genealogie\GeneaPHP5\Actes';
        $ancienne_bd = \Config\Database::connect('ancien_genea');       
        $query   = $ancienne_bd->query('select idf_acte,date,jour_rep,mois_rep,annee_rep,fete_rep,idf_type_acte,idf_notaire,date_enregistrement,jour_rep_enregistrement,mois_rep_enregistrement,annee_rep_enregistrement,fete_rep_enregistrement,idf_paroisse_enregistrement,cote,idf_paroisse_signature,commentaires,date_modification,idf_redacteur from actes');
        $results = $query->getResult();
        $ancienne_bd->close();
        $a_actes= array();
        foreach ($results as $row) {
            list($i_annee,$i_mois,$i_jour)=preg_split('/\-/',$row->date);
            list($i_annee_enr,$i_mois_enr,$i_jour_enr)=preg_split('/\-/',$row->date_enregistrement);
            if ($row->mois_rep!=0)
                $st_date_rep =sprintf("%02d/%s/%02d",$row->jour_rep,$ga_mois_revolutionnaires_nimegue[$row->mois_rep],$row->annee_rep_enregistrement);
            else
                $st_date_rep ='';
            if ($row->mois_rep_enregistrement!=0)
                $st_date_rep_enregistrement =sprintf("%02d/%s/%02d",$row->jour_rep_enregistrement,$ga_mois_revolutionnaires_nimegue[$row->mois_rep_enregistrement],$row->annee_rep_enregistrement);
            else
                $st_date_rep_enregistrement ='';
            $i_id_paroisse_signature = $row->idf_paroisse_signature != 0 ? $row->idf_paroisse_signature: null;
            $st_nom_fichier = $gst_rep_textes.DIRECTORY_SEPARATOR."$row->idf_acte.txt";
            if (file_exists($st_nom_fichier))
            {
                $st_transcription = file_get_contents($st_nom_fichier);
            }
            else
            {
                $st_transcription= '';
            }
            $a_actes[$row->idf_acte]=array($row->date,$st_date_rep,$row->date_enregistrement,$st_date_rep_enregistrement,$row->idf_type_acte,$row->idf_notaire,$row->cote,$i_id_paroisse_signature,$row->commentaires,$row->date_modification,$row->idf_redacteur,mb_convert_encoding($st_transcription, "UTF-8","Windows-1252"));
        }

        $nouvelle_bd = \Config\Database::connect();  
        $model = model(ActeModel::class);

        foreach ($a_actes as $idf_acte => $a_row)
        {
            list($st_date,$st_date_rep,$st_date_enregistrement,$st_date_rep_enregistrement,$i_idf_type_acte,$i_idf_notaire,$st_cote,$i_idf_paroisse_signature,$st_commentaires,$st_date_modification,$i_idf_redacteur,$st_transcription)=$a_row;
            
            $data_insert = [
                'id' => $idf_acte,
                'id_source_acte'  => 1,
                'id_notaire'=> $i_idf_notaire,
                'id_type_acte'=> $i_idf_type_acte,
                'id_releveur'=> $i_idf_redacteur,
                'id_paroisse_signature'=>$i_idf_paroisse_signature,
                'date' => $st_date,
                'date_rep' => $st_date_rep,
                'date_enregistrement' => $st_date_enregistrement,
                'date_rep_enregistrement' => $st_date_rep_enregistrement,
                'cote'=> $st_cote,
                'commentaires'=>$st_commentaires,
                'date_creation'=>$st_date_modification,
                'date_modification'=>$st_date_modification,
                'transcription'=>$st_transcription
            ];
            $model->insert($data_insert);
        }
        
        $data = [
            'liste_actes' => $a_actes,
        ];

        $nouvelle_bd->close();
        return view('acte',$data);
    }

    public function affiche(int $id): string
    {
        $nouvelle_bd = \Config\Database::connect();  
        $model = model(ActeModel::class);
        $infos = $model->find($id);
        $nouvelle_bd->close();
        print_r($infos);
        $data = [
            'infos_acte' => $infos,
        ];    
        return view('visu_acte',$data);
    }
}
