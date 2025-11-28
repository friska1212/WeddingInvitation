<?php
header("Content-Type: application/json; charset=utf-8");
include "config.php";

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

if ($method === "POST") {
    $action = $input['action'] ?? '';

    if ($action === 'order') {
        $name = mysqli_real_escape_string($conn, $input['name'] ?? '');
        $email = mysqli_real_escape_string($conn, $input['email'] ?? '');
        $phone = mysqli_real_escape_string($conn, $input['phone'] ?? '');
        $package = mysqli_real_escape_string($conn, $input['package_slug'] ?? '');
        $template = mysqli_real_escape_string($conn, $input['template_slug'] ?? '');
        $message = mysqli_real_escape_string($conn, $input['message'] ?? '');

        $sql = "INSERT INTO orders (name,email,phone,package_slug,template_slug,message) 
                VALUES ('$name','$email','$phone','$package','$template','$message')";
        if (mysqli_query($conn, $sql)) echo json_encode(['status'=>true,'id'=>mysqli_insert_id($conn)]);
        else { http_response_code(500); echo json_encode(['status'=>false,'message'=>mysqli_error($conn)]); }
        exit;
    }

    if ($action === 'lead') {
        $name = mysqli_real_escape_string($conn, $input['name'] ?? '');
        $phone = mysqli_real_escape_string($conn, $input['phone'] ?? '');
        $message = mysqli_real_escape_string($conn, $input['message'] ?? '');
        $sql = "INSERT INTO leads (name,phone,message) VALUES ('$name','$phone','$message')";
        if (mysqli_query($conn, $sql)) echo json_encode(['status'=>true,'id'=>mysqli_insert_id($conn)]);
        else { http_response_code(500); echo json_encode(['status'=>false,'message'=>mysqli_error($conn)]); }
        exit;
    }

    echo json_encode(['status'=>false,'message'=>'unknown action']);
    exit;
}

if ($method === "GET") {
    echo json_encode(['status'=>true,'message'=>'API ready']);
    exit;
}
?>
