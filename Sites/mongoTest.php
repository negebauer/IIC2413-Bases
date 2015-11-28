<?php

echo $dbhost = "localhost";
echo $dbname = "test";
echo $mongo = new Mongo("mongodb://$dbhost");
echo $db = $mongo->$dbname;

?>