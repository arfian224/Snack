let cart = [];

document.querySelectorAll(".product button").forEach(btn => {
    btn.addEventListener("click", () => {

        const id    = btn.dataset.id;
        const name  = btn.dataset.name;
        const price = parseInt(btn.dataset.price);

        const existing = cart.find(item => item.id === id);

        if (existing) {
            existing.qty++;
        } else {
            cart.push({ id, name, price, qty: 1 });
        }

        updateCartUI();
    });
});

const cartPanel = document.querySelector(".cart-panel");
const cartItemsEl = document.querySelector(".cart-items");
const cartTotalEl = document.querySelector(".cart-total");

function updateCartUI() {
    cartItemsEl.innerHTML = "";
    let total = 0;

    cart.forEach(item => {
        total += item.price * item.qty;

        cartItemsEl.innerHTML += `
            <div class="cart-item">
                <strong>${item.name}</strong>
                <div>
                    <button onclick="changeQty('${item.id}', -1)">−</button>
                    ${item.qty}
                    <button onclick="changeQty('${item.id}', 1)">+</button>
                </div>
                <span>Rp ${item.price * item.qty}</span>
            </div>
        `;
    });

    cartTotalEl.innerHTML = `<h3>Total: Rp ${total}</h3>`;
    cartPanel.classList.add("active");
}

function changeQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (!item) return;

    item.qty += delta;

    if (item.qty <= 0) {
        cart = cart.filter(i => i.id !== id);
    }

    updateCartUI();
}
