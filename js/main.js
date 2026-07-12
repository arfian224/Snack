// ========================
// CURSOR INTERACTION
// ========================
const cursor = document.querySelector(".cursor");

document.addEventListener("mousemove", e => {
    cursor.style.left = e.clientX + "px";
    cursor.style.top = e.clientY + "px";
});

document.querySelectorAll("button, a, .product").forEach(el => {
    el.addEventListener("mouseenter", () => cursor.classList.add("active"));
    el.addEventListener("mouseleave", () => cursor.classList.remove("active"));
});

// ========================
// SCROLL REVEAL
// ========================
const revealElements = document.querySelectorAll(".product, .location iframe");

const revealOnScroll = () => {
    revealElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight - 100) {
            el.style.opacity = 1;
            el.style.transform = "translateY(0)";
        }
    });
};

window.addEventListener("scroll", revealOnScroll);

revealElements.forEach(el => {
    el.style.opacity = 0;
    el.style.transform = "translateY(80px)";
    el.style.transition = "all 1s ease";
});

// ========================
// ADD TO CART FEEDBACK
// ========================
let cartCount = 0;
const cartBadge = document.createElement("div");
cartBadge.className = "cart-badge";
cartBadge.innerText = cartCount;
document.body.appendChild(cartBadge);

cartBadge.style.cssText = `
    position: fixed;
    top: 25px;
    right: 30px;
    background: #ffb703;
    color: #000;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    z-index: 999;
`;

document.querySelector(".checkout-btn").addEventListener("click", () => {
    localStorage.setItem("cart", JSON.stringify(cart));
    window.location.href = "checkout.html";
});

document.querySelectorAll(".product button").forEach(btn => {
    btn.addEventListener("click", () => {
        cartCount++;
        cartBadge.innerText = cartCount;

        cartBadge.style.transform = "scale(1.5)";
        setTimeout(() => {
            cartBadge.style.transform = "scale(1)";
        }, 200);
    });
});

const chatInput = document.getElementById("chatInput");
const chatBody = document.getElementById("chatBody");

chatInput.addEventListener("keypress", e => {
    if(e.key === "Enter" && chatInput.value.trim() !== "") {
        const msg = document.createElement("div");
        msg.textContent = "Kamu: " + chatInput.value;
        chatBody.appendChild(msg);

        const reply = document.createElement("div");
        reply.textContent = "CS: Terima kasih, kami akan membalas segera!";
        chatBody.appendChild(reply);

        chatInput.value = "";
        chatBody.scrollTop = chatBody.scrollHeight;
    }
});
