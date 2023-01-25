<?php

function conectarDB(){
    $db = new mysqli('localhost:3307','root', 'password','bienesraices_crud');
    $db->set_charset("utf8");
   if(!$db){
    echo "Error no se pudo conectar";
    exit;
   }
   return $db;
}
