<?php
include 'config.php';
include 'headers.php';

 // ------------------- Method GET ----------------------
if($_SERVER['REQUEST_METHOD'] == 'GET') :
    // - - -- - - - -  type de user  - - -- - - - -
    if( isset($_GET['search']) AND isset($_GET['type'])) : 
        $sql = sprintf("SELECT * FROM `user` WHERE(lastname LIKE '%s%%' OR firstname LIKE '%s%%') AND level = '%s'",
            $_GET['search'],
            $_GET['search'],
            $_GET['type']
        );
      //  $response['sql'] = $sql;
        $result = $connect->query($sql);
        if($result->num_rows > 0) :
            $response['data'] = $result->fetch_all(MYSQLI_ASSOC);
            $response['nb_hits'] = $result->num_rows;
        else : 
            $response['nb_hits'] = 0;
            $response['code'] = 404;
        endif;
    else :

     // - - -- - - - -  Tous les user  - - -- - - - -
    if( isset($_GET['id_user'])) : 
        $sql = sprintf("SELECT * FROM `user` WHERE id_user = %d",
            $_GET['id_user']
        );
        $response['response'] = "Un utilisateur avec l'id " .$_GET['id_user'];
    else :
        $sql = "SELECT * FROM `user` ";
        $response['response'] = "Tous les utilisateurs";

    endif;
    $result = $connect->query($sql);
    echo $connect-> error;
    $response['data'] = $result->fetch_all(MYSQLI_ASSOC);// $result est un objet et MYSQLI_ASSOC c'est pour dire qu'on utilise un array associatif
    $response['nb_hits'] = $result->num_rows;
endif;
endif; // END GET

 // ------------------- Method POST ----------------------

if($_SERVER['REQUEST_METHOD'] == 'POST') :
    //extraction de l'obect json du paquet HTTP
    $json = file_get_contents('php://input');
    //décodage du format json, ça génère un obect php
    $objectPOST = json_decode($json);
    $sql = sprintf("INSERT INTO `user` SET `email`='%s', `password`='%s', lastname='%s', firstname='%s', `level`='%s'",
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