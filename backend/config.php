<?php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "paperless_like";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if (!$conn) {
    http_response_code(500);
    echo json_encode(["status"=>false,"message"=>"DB connection failed"]);
    exit;
}
?>
