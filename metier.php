<?php
include 'config.php';
include 'headers.php';

 // ------------------- Method GET ----------------------
if($_SERVER['REQUEST_METHOD'] == 'GET') :
    if( isset($_GET['id_metier'])) : 
        $sql = sprintf("SELECT * FROM `metier` WHERE id_metier = %d",
            $_GET['id_metier']
        );
        $response['response'] = "Un metier " .$_GET['id_metier'];
    else :
        $sql = "SELECT * FROM `metier` ";
        $response['response'] = "Tous les metiers";

    endif;
    $result = $connect->query($sql);
    echo $connect-> error;
    $response['data'] = $result->fetch_all(MYSQLI_ASSOC);// $result est un objet et MYSQLI_ASSOC c'est pour dire qu'on utilise un array associatif
    $response['nb_hits'] = $result->num_rows;
endif; // END GET

 // ------------------- Method POST ----------------------

if($_SERVER['REQUEST_METHOD'] == 'POST') :
    //extraction de l'obect json du paquet HTTP
    $json = file_get_contents('php://input');
    //décodage du format json, ça génère un obect php
    $objectPOST = json_decode($json);
    $sql = sprintf("INSERT INTO `metier` SET `label`='%s'",
        strip_tags(addslashes($objectPOST->label))
);
    $response['sql'] = $sql;
    $connect->query($sql);
    echo $connect->error;
    $response['response'] = "Ajout d'un métier avec l'id ";
    $response['new_id'] = $connect->insert_id;
endif; //END POST

echo Json_encode($response);