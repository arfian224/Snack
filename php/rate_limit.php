<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$limit = 5;
$time = 300;

$_SESSION["hits"] = $_SESSION["hits"] ?? [];
$_SESSION["hits"] = array_filter(
    $_SESSION["hits"],
    fn($t) => $t > time() - $time
);

if (count($_SESSION["hits"]) >= $limit) {
    http_response_code(429);
    exit("Too many requests");
}

$_SESSION["hits"][] = time();
?>