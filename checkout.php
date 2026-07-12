<?php
session_start();
require "php/csrf.php";
generate_csrf();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Checkout | SNACKVERSE</title>

<style>
*{margin:0;padding:0;box-sizing:border-box}
body{
  min-height:100vh;
  background:#0b0b0b;
  font-family:Poppins,Arial,sans-serif;
  color:#fff;
  display:flex;
  justify-content:center;
  align-items:center;
}

/* === CHECKOUT WRAPPER === */
.checkout{
  width:100%;
  padding:40px;
  display:flex;
  justify-content:center;
}

.checkout-box{
  background:#111;
  max-width:900px;
  width:100%;
  border-radius:24px;
  padding:40px;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:40px;
  box-shadow:0 40px 80px rgba(0,0,0,.7);
  opacity:0;
  transform:translateY(60px);
}

/* === LEFT === */
.checkout-box h2{
  font-size:28px;
  margin-bottom:20px;
}
.checkout-box input,
.checkout-box textarea{
  width:100%;
  padding:14px;
  margin-bottom:15px;
  border-radius:12px;
  border:none;
  background:#1b1b1b;
  color:#fff;
}

/* === RIGHT SUMMARY === */
.summary{
  background:#0e0e0e;
  padding:25px;
  border-radius:20px;
}
.summary h3{
  margin-bottom:20px;
}
.summary-item{
  display:flex;
  justify-content:space-between;
  margin-bottom:10px;
  font-size:14px;
}
.total{
  margin-top:20px;
  font-size:20px;
  font-weight:bold;
  color:#ffb703;
}

/* === PAYMENT === */
.payment{
  display:flex;
  flex-direction:column;
  gap:14px;
  margin-top:15px;
}

/* card */
.payment-card{
  display:flex;
  align-items:center;
  gap:15px;
  padding:16px 18px;
  border-radius:16px;
  background:#151515;
  cursor:pointer;
  transition:.25s ease;
  border:1px solid transparent;
}

/* hide radio */
.payment-card input{
  display:none;
}

/* text */
.payment-info strong{
  font-size:15px;
}
.payment-info span{
  font-size:12px;
  opacity:.7;
}

/* hover */
.payment-card:hover{
  background:#1c1c1c;
  transform:translateY(-2px);
}

/* ACTIVE */
.payment-card:has(input:checked){
  border:1px solid #ffb703;
  box-shadow:0 0 0 2px rgba(255,183,3,.25);
  background:linear-gradient(135deg,#1c1c1c,#141414);
}

/* dot indicator */
.payment-card::after{
  content:"";
  width:10px;
  height:10px;
  border-radius:50%;
  background:#555;
  margin-left:auto;
  transition:.2s;
}
.payment-card:has(input:checked)::after{
  background:#ffb703;
  box-shadow:0 0 10px #ffb703;
}


/* === BUTTON === */
.checkout-btn{
  margin-top:25px;
  width:100%;
  padding:16px;
  border:none;
  border-radius:30px;
  background:#ffb703;
  color:#000;
  font-weight:bold;
  cursor:pointer;
  transition:.3s;
}
.checkout-btn:hover{
  background:#ffd166;
  transform:scale(1.05);
}

/* RESPONSIVE */
@media(max-width:768px){
  .checkout-box{
    grid-template-columns:1fr;
  }
}
</style>

</head>
<body>

<div class="checkout">
  <form class="checkout-box" method="POST" action="php/create_order.php"> 
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">


    <!-- LEFT -->
    <div>
      <h2>Data Pembeli</h2>
      <input name="name" placeholder="Nama Lengkap" required>
      <input name="phone" placeholder="No WhatsApp" required>
      <textarea name="address" placeholder="Alamat Lengkap" required></textarea>

      <h2>Metode Pembayaran</h2>
     <div class="payment">

  <label class="payment-card">
    <input type="radio" name="payment" value="COD" checked>
    <div class="payment-info">
      <strong>COD</strong>
      <span>Bayar saat barang tiba</span>
    </div>
  </label>

  <label class="payment-card">
    <input type="radio" name="payment" value="Transfer">
    <div class="payment-info">
      <strong>Transfer Bank</strong>
      <span>BCA • BRI • Mandiri</span>
    </div>
  </label>

  <label class="payment-card">
    <input type="radio" name="payment" value="E-Wallet">
    <div class="payment-info">
      <strong>E-Wallet</strong>
      <span>OVO • GoPay • DANA</span>
    </div>
  </label>

</div>


      <button class="checkout-btn">Bayar Sekarang</button>
    </div>

    <!-- RIGHT -->
    <div class="summary">
      <h3>Ringkasan Pesanan</h3>
      <div id="summaryItems"></div>
      <div class="total">Total: Rp <span id="total"></span></div>
    </div>

    <input type="hidden" name="cart" id="cartInput">
    <input type="hidden" name="total" id="totalInput">

  </form>
</div>

<script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>

<script>
// === LOAD CART ===
const cart = JSON.parse(localStorage.getItem("cart")) || [];
const summary = document.getElementById("summaryItems");
let total = 0;

cart.forEach(item=>{
  total += item.price * item.qty;
  summary.innerHTML += `
    <div class="summary-item">
      <span>${item.name} x${item.qty}</span>
      <span>Rp ${item.price * item.qty}</span>
    </div>
  `;
});

document.getElementById("total").innerText = total.toLocaleString();
document.getElementById("cartInput").value = JSON.stringify(cart);
document.getElementById("totalInput").value = total;

// === CINEMATIC ANIMATION ===
gsap.to(".checkout-box",{
  opacity:1,
  y:0,
  duration:1.2,
  ease:"power4.out"
});
</script>

</body>
</html>
