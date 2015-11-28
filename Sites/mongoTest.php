<?php

echo $dbhost = "localhost";
echo $dbname = "test";
echo $mongo = new MongoClient("mongodb://$dbhost");
echo $db = $mongo->$dbname;
echo $db.universidades.find()

?>