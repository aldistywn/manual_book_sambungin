<?php

require_once 'config.php';

function getModules() {
    global $conn;

    $result = $conn->query("SELECT * FROM modules");

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

function createModule() {
    global $conn;

    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['name'])) {
        http_response_code(400);
        echo json_encode(["error" => "Name required"]);
        return;
    }

    $stmt = $conn->prepare("INSERT INTO modules (name) VALUES (?)");
    $stmt->bind_param("s", $input['name']);
    $stmt->execute();

    echo json_encode(["id" => $stmt->insert_id]);
}

function deleteModule($id) {
    global $conn;

    $conn->begin_transaction();

    try {
        $stmt1 = $conn->prepare("DELETE FROM steps WHERE module_id=?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();

        $stmt2 = $conn->prepare("DELETE FROM modules WHERE id=?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception("Module not found");
        }

        $stmt2->close();
        $conn->commit();

        echo json_encode([
            "success" => true,
            "message" => "Deleted successfully"
        ]);

    } catch (Throwable $e) {
        $conn->rollback();

        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
    }
}