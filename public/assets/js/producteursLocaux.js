import { articles } from "./prodLoc.js";
//affichage

const imgElements = document.querySelectorAll("div img");
// console.dir(imgElements);
const imgFull = [];
const frameImg = document.createElement("div");
frameImg.style.width = "100vw";
frameImg.style.height = "100vh";
frameImg.style.backdropFilter = "blur(18px)";
frameImg.style.backgroundColor = "rgba(0,0,0,0.7)";
frameImg.style.display = "none";
frameImg.style.justifyContent = "center";
frameImg.style.alignItems = "center";
frameImg.style.position = "fixed";
frameImg.style.zIndex = 2;
document.body.prepend(frameImg);
// Meme chose avec une boucle while :
let i = 0;
while (i < imgElements.length) {
  let n = i;
  imgElements[i].addEventListener("click", () => {
    frameImg.style.display = "flex";
    console.log(n);
    imgFull[n] = document.createElement("img");
    imgFull[n].style.width = "40%";

    imgFull[n].src = imgElements[n].src;
    frameImg.append(imgFull[n]);
  });
  i++;
}
//click pour fermer la fenetre
// frameImg.addEventListener("click", function (event) {
//   console.log(event);
//   if (!frameImg.querySelector("img").contains(event.target)) {
//     frameImg.style.display = "none";
//     frameImg.innerHTML = "";
//   }
// });
function createCard(element) {
  const card = document.createElement("div");
  card.classList.add("article");

  // Creation of the elements pour constituer les cartes
  const cardImg = document.createElement("img");
  card.append(cardImg);
  const cardName = document.createElement("figcaption");
  card.append(cardName);
  const cardCP = document.createElement("p");
  cardCP.classList.add("codepostal");
  card.append(cardCP);
  const cardVille = document.createElement("p");
  cardVille.classList.add("ville");
  card.append(cardVille);
  const cardDescription = document.createElement("p");
  cardDescription.classList.add("description");
  card.append(cardDescription);
  const voirPlusButton = document.createElement("a");
  voirPlusButton.classList.add("voir-plus");
  voirPlusButton.innerText = "Voir plus";
  voirPlusButton.href = "#"; // j'utilise "#" comme un placeholder
  voirPlusButton.addEventListener("click", function (event) {
    event.preventDefault();
    // console.log("Clicked on voir plus button");
    openPopup(element);
  });

  card.append(voirPlusButton);

  return card;
}
function openPopup(element) {
  // Create a popup element
  const popup = document.createElement("div");
  popup.classList.add("popup");
  // Create the close button
  const closeButton = document.createElement("button");
  closeButton.classList.add("close-button");
  closeButton.innerText = "X";
  closeButton.addEventListener("click", function () {
    // Remove the popup from the document body when the close button is clicked
    document.body.removeChild(popup);
  });
  // Create title and description elements in the popup
  const popupImage = document.createElement("img");
  popupImage.src = element.url;
  const popupCP = document.createElement("p");
  popupCP.innerText = element.codepostal;
  const popupVille = document.createElement("p");
  popupVille.innerText = element.ville;
  const popupTel = document.createElement("p");
  popupTel.innerText = element.tel;
  const popupTitle = document.createElement("h2");
  popupTitle.innerText = element.name;
  const popupDescription = document.createElement("p");
  popupDescription.innerText = element.description;
  const popupSite = document.createElement("a");
  popupSite.innerText = element.site;
  // Append the close button, title, and description to the popup
  popup.append(
    closeButton,
    popupImage,
    popupCP,
    popupVille,
    popupSite,
    popupTel,
    popupTitle,
    popupDescription
  );

  // Add the popup to the document body
  document.body.appendChild(popup);
}

//creation d'un array destiné a contenir mes cards
const articlesElements = [];

//boucle for pour le tableau
const produits = document.querySelector("#prodLocaux");
for (let index = 0; index < articles.length; index++) {
  const element = articles[index];
  let tmpCard = createCard(element);
  articlesElements.push(tmpCard);
  articlesElements[index].childNodes[0].src = element.url;
  articlesElements[index].childNodes[1].innerText = element.name;
  articlesElements[index].childNodes[4].innerText = element.description;
  // Check if the description is too long and add ellipsis if needed
  if (element.description.length > 100) {
    articlesElements[index].childNodes[4].innerTextF =
      element.description.slice(0, 100) + "...";
  } else {
    articlesElements[index].childNodes[4].innerText = element.description;
  }

  produits.append(articlesElements[index]);
}

function afficherPlus() {
  var articles = document.getElementsByClassName("article");

  for (var i = 0; i < articles.length; i++) {
    if (articles[i].style.display === "none") {
      articles[i].style.display = "block";
    }
  }
}
