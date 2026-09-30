'use strict';

const a = document.getElementById('megaMenuId');
const items = document.getElementById('megaMenuChildId');
const closeBtn = document.getElementById('closeMegaMenuId');
if (a && items) {
    a.addEventListener("click", (e) => {
        e.preventDefault();
        items.classList.toggle("open");
    });
}
if (closeBtn && items) {
    closeBtn.addEventListener("click", () => {
        items.classList.remove("open");
    });
}