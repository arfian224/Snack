<?php
function generate_csrf() {
    if (empty($_SESSION["csrf"])) {
        $_SESSION["csrf"] = bin2hex(random_bytes(32));
    }
}

function verify_csrf() {
    if (!isset($_POST["csrf"], $_SESSION["csrf"])) {
        http_response_code(403);
        exit("Invalid CSRF");
    }

    if (!hash_equals($_SESSION["csrf"], $_POST["csrf"])) {
        http_response_code(403);
        exit("Invalid CSRF");
    }
}
?>