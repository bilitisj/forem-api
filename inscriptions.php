<?php
include 'config.php';
include 'headers.php';

 // ------------------- Method GET ----------------------
if($_SERVER['REQUEST_METHOD'] == 'GET') :
    if( isset($_GET['id_inscriptions'])) : 
        $sql = sprintf("SELECT * FROM `inscriptions` WHERE id_inscriptions = %d",
            $_GET['id_inscriptions']
        );
        $response['response'] = "Une inscriptions " .$_GET['id_inscriptions'];
    else :
        $sql = "SELECT * FROM `inscriptions` ";
        $response['response'] = "Toutes les inscriptions";

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
    $sql = sprintf("INSERT INTO `inscriptions` SET id_session=%d, id_users=%d ",
        strip_tags(addslashes($objectPOST->id_session)),
        strip_tags(addslashes($objectPOST->id_users))
);
    $response['sql'] = $sql;
    $connect->query($sql);
    echo $connect->error;
    $response['response'] = "Ajout d'une inscriptions avec l'id ";
    $response['new_id'] = $connect->insert_id;
endif; //END POST

echo Json_encode($response);