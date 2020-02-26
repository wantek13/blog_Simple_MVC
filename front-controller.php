<?php

session_start();

// Vérifier l'horodatage de destruction
if (isset($_SESSION['destroyed'])
    && $_SESSION['destroyed'] < time() - 300) {
    // Ne devrait pas se produire habituellement. Cela pourrait être une attaque 
    // ou en raison d'un réseau instable. Supprimez tout l'état d'authentification 
    // de cette session utilisateurs.
    remove_all_authentication_flag_from_active_sessions($_SESSION['username']);
    throw(new DestroyedSessionAccessException);
}


$old_sessionid = session_id();

// Définir l'horodatage de déstruction
$_SESSION['destroyed'] = time(); // Depuis PHP 7.0.0 et supérieur, session_regenerate_id () enregistre les anciennes données de session

// Il suffit d'appeler session_regenerate_id() peut entraîner la perte de session, etc.
// Voir l'exemple suivant.
session_regenerate_id();

// La nouvelle session n'a pas besoin du timestamp de destruction
unset($_SESSION['destroyed']);

$new_sessionid = session_id();

echo "Ancienne Session: $old_sessionid<br />";
echo "Nouvelle Session: $new_sessionid<br />";

print_r($_SESSION);

require 'bdd.php';

var_dump($_GET);

$filename = 'controllers/' . $_GET['controller'] . '.php';
$controller = $_GET['controller'];
$action = $_GET['action'] . 'Action';

try
{
    if(array_key_exists('controller', $_GET))
    {
        if (file_exists($filename)) 
        {
            require $filename;

            if(function_exists($action))
            {
                $action($bdd);
            }
            else
            {
                throw new Exception('action inconnu', 02);
            }
        }
        else
        {
            throw new Exception('controlleur inconnu', 02);
        }
    }
}
catch(Exception $e)
{
    var_dump($e);
}

?>