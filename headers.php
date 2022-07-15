<?php
header("Access-Control-Allow-Origin:*");
// je rend mon api accesible à n'importe quel domaine (opendata)

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
//je precise les methodes que j'accepte

header("Content-Type:application/json");
//les retours que le serveur va faire sont en json

header("Access-Control-Allow-Headers: Date,Server,X-Powered-By,Access-Control-Allow-Origin,Access-Control-Allow-Methods,Set-Cookie,Expires,Cache-Control,Pragma,Content-Length,Keep-Alive,Connection,Content-Type");
?>