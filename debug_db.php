<?php
require __DIR__ . '/public/index.php';

try {
    $db = lava_instance()->call->database();
    echo "DB_OBJECT_OK\n";
    echo get_class($db) . "\n";
    echo "driver=" . getenv('DB_DRIVER') . "\n";
    echo "host=" . getenv('DB_HOST') . "\n";
    echo "port=" . getenv('DB_PORT') . "\n";
    echo "name=" . getenv('DB_NAME') . "\n";
    $pdo = $db->raw('SELECT 1 AS ok');
    var_dump($pdo->fetchAll(PDO::FETCH_ASSOC));
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
