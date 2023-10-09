
export function toggleNav() {
    const burgerMenu = document.querySelector(".burger-menu");
    const navList = document.querySelector(".nav-links");

    burgerMenu.addEventListener("click", () => {
        navList.classList.toggle("active");
    });
}