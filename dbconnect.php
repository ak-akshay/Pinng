<?php

try {
    // -------------Manager for local database-------------------
    // $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

    // -------------Manager for online database-------------------
    $manager = new MongoDB\Driver\Manager('mongodb://userakshay:akshay17@pinngcluster-shard-00-00-sdbuq.mongodb.net:27017,pinngcluster-shard-00-01-sdbuq.mongodb.net:27017,pinngcluster-shard-00-02-sdbuq.mongodb.net:27017/test?ssl=true&replicaSet=PinngCluster-shard-0&authSource=admin&retryWrites=true&w=majority');
}
catch(MongoDB\Driver\Exception\Exception $e) {
    echo "Exception:", $e->getMessage(), "\n";
}

?>