let arrowIconLeft =
  '<?xml version="1.0" ?><!DOCTYPE svg  PUBLIC \'-//W3C//DTD SVG 1.1//EN\'  \'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\'><svg height="50px" id="Layer_1" style="enable-background:new 0 0 50 50;" version="1.1" viewBox="0 0 512 512" width="50px" color="#fff" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polygon points="352,115.4 331.3,96 160,256 331.3,416 352,396.7 201.5,256 "/></svg>';

let slides = document.querySelectorAll(".slide-ana div");
let slideSayisi = slides.length;

let prev = document.getElementById("prev");
let next = document.getElementById("next");
prev.innerHTML = arrowIconLeft;
next.innerHTML = arrowIconLeft;
next.querySelector("svg").style.transform = "rotate(180deg)";

for (let index = 0; index < slides.length; index++) {
  const element = slides[index];
  element.style.transform = "translateX(" + 100 * index + "%)";
}
let loop = 0 + 1000 * slideSayisi;
let i = 0;
const interval = setInterval(() => {
  goNext(next, i);
  i += 1;
  if (i > 20) {
    clearInterval(interval);
  }
}, 6000);
function goNext() {
  loop++;
  for (let index = 0; index < slides.length; index++) {
    const element = slides[index];
    element.style.transform =
      "translateX(" + 100 * (index - (loop % slideSayisi)) + "%)";
  }
}

function goPrev() {
  loop--;
  for (let index = 0; index < slides.length; index++) {
    const element = slides[index];
    element.style.transform =
      "translateX(" + 100 * (index - (loop % slideSayisi)) + "%)";
  }
}

next.addEventListener("click", goNext);
prev.addEventListener("click", goPrev);
document.addEventListener("keydown", function (e) {
  if (e.code === "ArrowRight") {
    goNext();
  } else if (e.code === "ArrowLeft") {
    goPrev();
  }
});
const voirPlusButton = document.getElementById("voirPlusProducLocaux");

voirPlusButton.addEventListener("click", function() {
  window.location.href = "./Ethique et mode de vie/Producteurs locaux";
});

