//check ambient sensor for browsers
if ("AmbientLightSensor" in window) {
  const sensor = new AmbientLightSensor();

  sensor.addEventListener("reading", () => {
    console.log("Ambient light level:", sensor.illuminance);
  });

  sensor.start();
} else {
  console.log("Ambient light sensor is not supported on this device.");
}

//prevention click droit sur image pour telechargé
document.addEventListener("contextmenu", function (event) {
  if (event.target.tagName === "IMG") {
    event.preventDefault();
  }
});
//WhatsUp Chat
function openWhatsAppPopup() {
  const phoneNumber = "+33778882242"; // Replace with the desired phone number
  const url = "https://wa.me/" + 33778882242;

  const windowWidth = 500; // Desired width of the popup window
  const windowHeight = 600; // Desired height of the popup window

  const left = (screen.width - windowWidth) / 2;
  const top = (screen.height - windowHeight) / 2;

  const options =
    "width=" +
    windowWidth +
    ",height=" +
    windowHeight +
    ",top=" +
    top +
    ",left=" +
    left;

  window.open(url, "_blank", options);
}


// Effects dynamiques pages
window.addEventListener('load', function() {
  const content = document.querySelector('#presentation .content');
  const image = document.querySelector('#presentation .image');

  content.classList.add('show');
  image.classList.add('show');
});
// Effects dynamique header
window.addEventListener('load', function() {
  const imgHeader = document.querySelector('#imgHeader');
  imgHeader.classList.add('show');
});
var currentlyVisibleText = null;

function toggleText(textId) {
  var textElement = document.getElementById(textId);

  if (currentlyVisibleText !== null && currentlyVisibleText !== textElement) {
    currentlyVisibleText.classList.remove('text-visible');
  }

  textElement.classList.toggle('text-visible');
  currentlyVisibleText = textElement;
}
function toggleMenu() {
  var menuItems = document.querySelector('.menu-items');
  menuItems.style.left = (menuItems.style.left === '0%' || menuItems.style.left === '') ? '-100%' : '0%';
}
