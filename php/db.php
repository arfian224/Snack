<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("localhost", "root", "", "snackverse");
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    http_response_code(500);
    exit("Database error");
}
?>