<?php
include 'config.php';
include 'headers.php';

 // ------------------- Method GET ----------------------
if($_SERVER['REQUEST_METHOD'] == 'GET') :
    if( isset($_GET['id_inscription'])) : 
        $sql = sprintf("SELECT * FROM `inscription` WHERE id_inscription = %d",
            $_GET['id_inscription']
        );
        $response['response'] = "Une inscription " .$_GET['id_inscription'];

    else :
        $sql = "SELECT * FROM `inscription` ";
        $response['response'] = "Toutes les inscriptions";

        $response['sql'] = $sql;
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
    $sql = sprintf("INSERT INTO `inscription` SET id_session='%s', id_user=%d ",
        strip_tags(addslashes($objectPOST->id_session)),
        strip_tags(addslashes($objectPOST->id_user))
    );
    $response['sql'] = $sql;
    $response['data'] = $objectPOST->id_session;
elseif(isset($_POST['alldata'])) :
        $sql = 'SELECT * FROM `inscription` LEFT JOIN `session` ON session.id_session = insription.id_session LEFT JOIN user ON user.id_user = inscription.id_user';

    $response['sql'] = $sql;
    $connect->query($sql);
    echo $connect->error;
    $response['response'] = "Ajout d'une inscription avec l'id ";
    $response['new_id'] = $connect->insert_id;
endif; //END POST

echo Json_encode($response);