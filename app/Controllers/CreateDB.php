<?php

namespace App\Controllers;

class CreateDB extends BaseController
{
    public function create(): string
    {
        $forge = \Config\Database::forge();
        //profession    
        $fields = array(
        'nom' => array(
                'type' => 'VARCHAR',
                'constraint' => '35',
                'unique' => TRUE,
        )
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->createTable('profession',True);
        //type_acte
        $fields = array(
        'nom' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'unique' => TRUE,
        )
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->createTable('type_acte',True);
        //type_comparution
        $fields = array(
        'nom' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
                'unique' => TRUE,
        )
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->createTable('type_comparution',True);
        //type_parente
        $fields = array(
        'nom' => array(
                'type' => 'VARCHAR',
                'constraint' => '60',
                'unique' => TRUE,
        )
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->createTable('type_parente',True);
        //source_acte
        $fields = array(
        'nom' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
                'unique' => TRUE,
        )
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->createTable('source_acte',True);
        //departement
        $fields = array(
        'nom' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
                'unique' => TRUE,
        )
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->createTable('departement',True);
        //paroisse
        $fields = array(
        'nom' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
                'unique' => TRUE,
        ),
        'latitude' => array(
                'type' => 'DOUBLE',
                'null' => true,
        ),
        'longitude' => array(
                'type' => 'DOUBLE',
                'null' => true,
        ),
        'id_departement' => array(
                'type' => 'INT',
                'null' => true,
        )
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->addForeignKey('id_departement', 'departement', 'id');
        $forge->createTable('paroisse',True);
        //notaire
        $fields = array(
        'nom' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
        ),
        'prenom' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
        ),
        'id_paroisse' => array(
                'type' => 'INT',
                'null' => true,
        )
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->addForeignKey('id_paroisse', 'paroisse', 'id');
        $forge->createTable('notaire',True);
        //releveur
        $fields = array(
        'nom' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
        ),
        'prenom' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
        ),
        'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
        ),
        'ident' => array(
                'type' => 'VARCHAR',
                'constraint' => '45',
        ),
        'mdp' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
        ),
        'niveau_droit' => array(
                'type' => 'SMALLINT',
        ),
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->createTable('releveur',True);
        //acte
        $fields = array(
        'id_source_acte' => array(
                'type' => 'INT',
        ),
        'id_type_acte' => array(
                'type' => 'INT',
        ),
        'id_notaire' => array(
                'type' => 'INT',
        ),
        'id_releveur' => array(
                'type' => 'INT',
                'null' => true,
        ),
        'id_paroisse_signature' => array(
                'type' => 'INT',
                'null' => true,
        ),        
        'date' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
        ),
        'date_rep' => array(
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => true,
        ),
        'date_enregistrement' => array(
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
        ),
        'date_rep_enregistrement' => array(
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => true,
        ),
        'commentaires' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
        ),
        'cote' => array(
                'type' => 'VARCHAR',
                'constraint' => '40',
        ),
        'resume' => array(
                'type' => 'TEXT',
                'constraint' => '4096',
                'null' => true,
        ),
        'transcription' => array(
                'type' => 'MEDIUMTEXT',
                'null' => true,
        ),
        'url' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
        ),
        'date_creation' => array(
                'type' => 'DATE',
        ),             
        'date_modification' => array(
                'type' => 'DATE',
                'null' => true,
        ),
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->addForeignKey('id_source_acte', 'source_acte', 'id');
        $forge->addForeignKey('id_type_acte', 'type_acte', 'id');
        $forge->addForeignKey('id_notaire', 'notaire', 'id');
        $forge->addForeignKey('id_releveur', 'releveur', 'id');
        $forge->addForeignKey('id_paroisse_signature', 'paroisse', 'id');
        $forge->createTable('acte',True);
        //paroisses_acte
        $fields = array(
        'id_acte' => array(
                'type' => 'INT',
        ),
        'id_paroisse' => array(
                'type' => 'INT',
        ),
        );
        $forge->addField($fields);
        $forge->addForeignKey('id_acte', 'acte', 'id');
        $forge->addForeignKey('id_paroisse', 'paroisse', 'id');
        $forge->createTable('paroisses_acte',True);
        //personne
        $fields = array(
        'id_acte' => array(
                'type' => 'INT',
        ),
        'id_type_comparution' => array(
                'type' => 'INT',
        ),
        'sexe' => array(
                'type' => 'ENUM',
                'constraint' => ['M', 'F', '?'],
        ),      
        'nom' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
        ),
        'prenom' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
        ),
        'surnom' => array(
                'type' => 'VARCHAR',
                'constraint' => '45000',
        ),
        'id_profession' => array(
                'type' => 'INT',
                'null' => true,
        ),
        'id_paroisse_origine' => array(
                'type' => 'INT',
                'null' => true,
        ),
        'id_paroisse_residence' => array(
                'type' => 'INT',
                'null' => true,
        ),
        'commentaires' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
        ),
        'phonex_nom' => array(
                'type' => 'DOUBLE',
                'null' => true,
        ),
        'phonex_prenom' => array(
                'type' => 'DOUBLE',
                'null' => true,
        ),
        'phonex_surnom' => array(
                'type' => 'DOUBLE',
                'null' => true,
        ),
        'decede' => array(
                'type' => 'BOOLEAN',
        ),
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->addForeignKey('id_acte', 'acte', 'id');
        $forge->addForeignKey('id_type_comparution', 'type_comparution', 'id');
        $forge->addForeignKey('id_profession', 'profession', 'id');
        $forge->addForeignKey('id_paroisse_origine', 'paroisse', 'id');
        $forge->addForeignKey('id_paroisse_residence', 'paroisse', 'id');
        $forge->createTable('personne',True);
        //relation_parente
        $fields = array(
        'id_personne' => array(
                'type' => 'INT',
        ),
        'id_parent' => array(
                'type' => 'INT',
        ),
        'id_type_parente' => array(
                'type' => 'INT',
        ),
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->addForeignKey('id_personne', 'personne', 'id');
        $forge->addForeignKey('id_parent', 'personne', 'id');
        $forge->addForeignKey('id_type_parente', 'type_parente', 'id');
        $forge->createTable('relation_parente',True);
        //relation_couple
        /*
        $fields = array(
        'id_cjt' => array(
                'type' => 'INT',
        ),
        'id_cjte' => array(
                'type' => 'INT',
        ),
        );
        $forge->addField('id');
        $forge->addField($fields);
        $forge->addForeignKey('id_cjt', 'personne', 'id');
        $forge->addForeignKey('id_cjte', 'personne', 'id');
        $forge->createTable('relation_couple',True);
        */
        return view('create_db');
    }
    
}
