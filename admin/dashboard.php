<?php
session_start();
require "../php/db.php";
if(!isset($_SESSION["admin"])) header("Location: login.php");
?>

<!DOCTYPE html>
<html>
<body>
<h2>Admin Dashboard</h2>
<a href="logout.php">Logout</a>

<h3>Orders</h3>
<table border="1">
<tr>
<th>ID</th><th>Nama</th><th>Phone</th><th>Alamat</th>
<th>Total</th><th>Payment</th><th>Status</th><th>Aksi</th>
</tr>

<?php
$orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
while($row = $orders->fetch_assoc()){
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['customer_name']}</td>";
    echo "<td>{$row['phone']}</td>";
    echo "<td>{$row['address']}</td>";
    echo "<td>Rp {$row['total']}</td>";
    echo "<td>{$row['payment_method']}</td>";
    echo "<td>{$row['payment_status']}</td>";
    echo "<td>
        <form method='POST'>
        <input type='hidden' name='order_id' value='{$row['id']}'>
        <select name='status'>
            <option value='Pending'>Pending</option>
            <option value='Processing'>Processing</option>
            <option value='Completed'>Completed</option>
        </select>
        <button>Update</button>
        </form>
    </td>";
    echo "</tr>";
}

if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['order_id'])){
    $id = intval($_POST['order_id']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET payment_status=? WHERE id=?");
    $stmt->bind_param("si",$status,$id);
    $stmt->execute();
    header("Location: dashboard.php");
}
?>
</table>

</body>
</html>
