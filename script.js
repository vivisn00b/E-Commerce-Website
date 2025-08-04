let navBar = document.querySelector("#navbar");
let navToggle = document.querySelector(".mobile-nav-toggle");
const hamburgerIcon = document.querySelector(".hamburger-icon");
navToggle.addEventListener("click", () => {
  let visible = navBar.getAttribute("data-visible");
  if (visible === "false") {
    navBar.setAttribute("data-visible", true);
    navToggle.setAttribute("aria-expanded", true);
    hamburgerIcon.classList.add("fa-times");
    hamburgerIcon.classList.remove("fa-bars");
  } else {
    navBar.setAttribute("data-visible", false);
    hamburgerIcon.classList.remove("fa-times");
    hamburgerIcon.classList.add("fa-bars");
  }
});

let MainImg = document.getElementById("MainImg1");
let smallimg = document.getElementsByClassName("small-img");
smallimg[0].onclick = function () {
  MainImg.src = smallimg[0].src;
};
smallimg[1].onclick = function () {
  MainImg.src = smallimg[1].src;
};
smallimg[2].onclick = function () {
  MainImg.src = smallimg[2].src;
};
smallimg[3].onclick = function () {
  MainImg.src = smallimg[3].src;
};
smallimg[4].onclick = function () {
  MainImg.src = smallimg[4].src;
};
smallimg[5].onclick = function () {
  MainImg.src = smallimg[5].src;
};

const coll = document.getElementsByClassName("icon-small");
let i;
for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function () {
    this.classList.toggle("expand");
    let content = this.nextElementSibling;
    if (content.style.maxHeight) {
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
}
