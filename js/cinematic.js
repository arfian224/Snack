const lenis = new Lenis({
    duration: 1.2,
    easing: t => t,
    smooth: true
});

function raf(time){
    lenis.raf(time)
    requestAnimationFrame(raf)
}

requestAnimationFrame(raf);

const hoverSound = new Audio('sounds/hover.mp3');

document.querySelectorAll(".product").forEach(product => {
    product.addEventListener("mouseenter", () => {
        gsap.to(product, { scale:1.05, duration:0.3 });
        hoverSound.play();
    });
    product.addEventListener("mouseleave", () => {
        gsap.to(product, { scale:1, duration:0.3 });
    });
});

gsap.from("body", { opacity: 0, duration: 1 });
window.addEventListener("beforeunload", () => {
    gsap.to("body", { opacity:0, duration: 0.8 });
});
