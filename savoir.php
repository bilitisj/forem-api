<?php
include 'config.php';
include 'headers.php';


 // ------------------- Method GET ----------------------
if($_SERVER['REQUEST_METHOD'] == 'GET') :
    if( isset($_GET['id_savoir'])) : 
        $sql = sprintf("SELECT * FROM `savoir` WHERE id_savoir = %d",
            $_GET['id_savoir']
        );
        $response['response'] = "Un savoir " .$_GET['id_savoir'];
    else :
        $sql = "SELECT * FROM `savoir` ";
        $response['response'] = "Tous les savoirs";

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
    $sql = sprintf("INSERT INTO `savoir` SET `id_metier`=%d, `definition`='%s', `theme`='%s'",
        strip_tags(addslashes($objectPOST->id_metier)),
        strip_tags(addslashes($objectPOST->definition)),
        strip_tags(addslashes($objectPOST->theme))
);
    $response['sql'] = $sql;
    $connect->query($sql);
    echo $connect->error;
    $response['response'] = "Ajout d'un savoir avec l'id ";
    $response['new_id'] = $connect->insert_id;
endif; //END POST

echo Json_encode($response);