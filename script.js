window.addEventListener("scroll", function() {
    var menuBar = document.getElementById("menu-bar");

    if (window.scrollY > 0) {
        menuBar.classList.add("sticky");
    } else {
        menuBar.classList.remove("sticky");
    }
});
