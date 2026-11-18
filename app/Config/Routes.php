<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('create_db', 'CreateDB::create');
$routes->get('profession', 'Profession::index');
$routes->get('migre_profession', 'Profession::migrate');
$routes->get('migre_paroisse', 'Paroisse::migrate');
$routes->get('migre_type_presence', 'TypeComparution::migrate');
$routes->get('migre_type_acte', 'TypeActe::migrate');
$routes->get('migre_notaire', 'Notaire::migrate');
$routes->get('migre_releveur', 'Releveur::migrate');
$routes->get('migre_type_parente', 'TypeParente::migrate');
$routes->get('migre_acte', 'Acte::migrate');
$routes->get('migre_personne', 'Personne::migrate');
$routes->get('migre_paroisses_acte', 'ParoissesActe::migrate');
$routes->get('affiche_acte/(:num)', 'Acte::affiche/$1');

service('auth')->routes($routes);
