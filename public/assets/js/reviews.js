//code pour le boutton voir plus plour les avis clients
const readMoreButtons = document.querySelectorAll(".read-more");
readMoreButtons.forEach((button) => {
  button.addEventListener("click", (event) => {
    event.preventDefault();
    const reviewSection = button.closest(".reviews-section");
    const shortText = reviewSection.querySelector(".short-text");
    const fullText = reviewSection.querySelector(".full-text");

    if (fullText.style.display === "none") {
      fullText.style.display = "block";
      shortText.style.display = "none";
      button.textContent = "Lire moins";
    } else {
      fullText.style.display = "none";
      shortText.style.display = "block";
      button.textContent = "Lire la suite";
    }
  });
});
function goBack() {
  history.back();
}
window.renderBadge = function () {
  var ratingBadgeContainer = document.createElement("div");
  document.body.appendChild(ratingBadgeContainer);
  window.gapi.load("ratingbadge", function () {
    window.gapi.ratingbadge.render(ratingBadgeContainer, {
      // OBLIGATOIRE
      merchant_id: A761402,
    });
  });
};

window.___gcfg = {
  lang: "fr",
};
