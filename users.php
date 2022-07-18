<?php
include 'config.php';
include 'headers.php';

 // ------------------- Method GET ----------------------
if($_SERVER['REQUEST_METHOD'] == 'GET') :
    if( isset($_GET['id_users'])) : 
        $sql = sprintf("SELECT * FROM `users` WHERE id_users = %d",
            $_GET['id_users']
        );
        $response['response'] = "Un utilisateur avec l'id " .$_GET['id_users'];
    else :
        $sql = "SELECT * FROM `users` ";
        $response['response'] = "Tous les utilisateurs";

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
    $sql = sprintf("INSERT INTO `users` SET `email`='%s', `password`='%s', lastname='%s', firstname='%s', `level`='%s'",
        strip_tags(addslashes($objectPOST->email)),
        strip_tags(addslashes($objectPOST->password)),
        strip_tags(addslashes($objectPOST->lastname)),
        strip_tags(addslashes($objectPOST->firstname)),
        strip_tags(addslashes($objectPOST->level))
);
    $response['sql'] = $sql;
    $connect->query($sql);
    echo $connect->error;
    $response['response'] = "Ajout d'un utilisateur avec l'id ";
    $response['new_id'] = $connect->insert_id;
endif; //END POST

echo Json_encode($response);