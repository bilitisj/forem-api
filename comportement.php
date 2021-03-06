<?php
include 'config.php';
include 'headers.php';

 // ------------------- Method GET ----------------------
if($_SERVER['REQUEST_METHOD'] == 'GET') :
    if( isset($_GET['id_comportement'])) : 
        $sql = sprintf("SELECT * FROM `comportement` WHERE id_comportement = %d",
            $_GET['id_comportement']
        );
        $response['response'] = "Un comportement avec l'id " .$_GET['id_comportement'];
    else :
        $sql = "SELECT * FROM `comportement` ";
        $response['response'] = "Tous les comportement";

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
    $sql = sprintf("INSERT INTO `comportement` SET `label`='%s', `id_savoir`=%d, `niveau`=%d",
        strip_tags(addslashes($objectPOST->label)),
        strip_tags(addslashes($objectPOST->id_savoir)),
        strip_tags(addslashes($objectPOST->niveau))
);
    $response['sql'] = $sql;
    $connect->query($sql);
    echo $connect->error;
    $response['response'] = "Ajout d'un comportement";
    $response['new_id'] = $connect->insert_id;
endif; //END POST

echo Json_encode($response);