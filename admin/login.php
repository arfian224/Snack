<?php session_start(); require "../php/db.php"; ?>
<!DOCTYPE html>
<html>
<body>
<h2>Admin Login</h2>
<form method="POST">
    <input name="username" placeholder="Username" required><br>
    <input name="password" type="password" placeholder="Password" required><br>
    <button>Login</button>
</form>

<?php
if($_SERVER["REQUEST_METHOD"]==="POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if($res && password_verify($password,$res["password"])){
        $_SESSION["admin"] = $res["id"];
        header("Location: dashboard.php");
        exit;
    } else echo "Login gagal";
}
?>
</body>
</html>
