<!-- Copiar en las páginas que necesiten acceso a Mongo -->
<?php

$dbhost = "localhost";
$dbname = "test";
$mongo = new MongoClient("mongodb://$dbhost");
$db = $mongo->$dbname;

?>