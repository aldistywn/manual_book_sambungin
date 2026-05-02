<?php

require_once 'config.php';

function getSteps($module_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM steps WHERE module_id=?");
    $stmt->bind_param("i", $module_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($data);
}