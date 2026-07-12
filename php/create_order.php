<?php
session_start();

require "db.php";
require "rate_limit.php";
require "csrf.php";

verify_csrf();

// === PAYMENT ===
$payment = $_POST["payment"] ?? 'COD';
$validPayments = ["COD", "Transfer", "E-Wallet"];
if (!in_array($payment, $validPayments)) {
    exit("Metode pembayaran tidak valid");
}

// === INPUT ===
$name    = trim($_POST["name"] ?? '');
$phone   = trim($_POST["phone"] ?? '');
$address = trim($_POST["address"] ?? '');
$total   = intval($_POST["total"] ?? 0);
$cart    = json_decode($_POST["cart"] ?? '', true);

// === VALIDASI ===
if (!$cart || $total <= 0 || !$name || !$phone || !$address) {
    exit("Invalid order");
}

// === INSERT ORDER ===
$stmt = $conn->prepare(
    "INSERT INTO orders (customer_name, phone, address, total, payment_method)
     VALUES (?, ?, ?, ?, ?)"
);

$stmt->bind_param("sssis", $name, $phone, $address, $total, $payment);
$stmt->execute();

// ✅ AMBIL ORDER ID
$order_id = $stmt->insert_id;

// === INSERT ITEMS ===
$itemStmt = $conn->prepare(
    "INSERT INTO order_items (order_id, product_name, price, qty)
     VALUES (?, ?, ?, ?)"
);

foreach ($cart as $item) {
    $itemStmt->bind_param(
        "isii",
        $order_id,
        $item["name"],
        $item["price"],
        $item["qty"]
    );
    $itemStmt->execute();
}

header("Location: ../index.php?order=success");
exit;
?>