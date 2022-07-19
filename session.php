<?php
include 'config.php';
include 'headers.php';

 // ------------------- Method GET ----------------------
if($_SERVER['REQUEST_METHOD'] == 'GET') :
    if( isset($_GET['id_session'])) : 
        $sql = sprintf("SELECT * FROM `session` WHERE id_session = %d",
            $_GET['id_session']
        );
        $response['response'] = "Une session " .$_GET['id_session'];
    else :
        $sql = "SELECT * FROM `session` ";
        $response['response'] = "Toutes les sessions";

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
    $sql = sprintf("INSERT INTO `session` SET id_metier=%d, `label`='%s', id_centre=%d, id_user=%d, date_start='%s'",
        strip_tags(addslashes($objectPOST->id_metier)),
        strip_tags(addslashes($objectPOST->label)),
        strip_tags(addslashes($objectPOST->id_centre)),
        strip_tags(addslashes($objectPOST->id_user)),
        strip_tags(addslashes($objectPOST->date_start))
);
    $response['sql'] = $sql;
    $connect->query($sql);
    echo $connect->error;
    $response['response'] = "Ajout d'une session avec l'id ";
    $response['new_id'] = $connect->insert_id;
endif; //END POST

echo Json_encode($response);