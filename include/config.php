<?php

try {
    $db = new \PDO('mysql:host=mysql18j11.db.hostpoint.internal;dbname=carlos4_vertrag', 'carlos4_door42', 'nGKK3BnqN!f8pfK9JK2o');
    
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>