const burger = document.querySelector(".burger-menu");
const toggle = document.getElementById("toggle");
const menuItems = document.querySelector(".menu-items");

burger.addEventListener("click", () => {
  menuItems.classList.toggle("show");
});

toggle.addEventListener("change", () => {
  burger.classList.toggle("active", toggle.checked);
});

// ajout des flèches pour le sous-menu display mobile
const submenuParents = document.querySelectorAll(".has-submenu > a");
submenuParents.forEach((parent) => {
  parent.addEventListener("click", (event) => {
    event.preventDefault();
    toggleSubmenu(parent);
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var noLinkItems = document.querySelectorAll(".no-link > a");
  for (var i = 0; i < noLinkItems.length; i++) {
    noLinkItems[i].addEventListener("click", function (e) {
      e.preventDefault();
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  var arrows = document.querySelectorAll("li.parent[has-submenu]");
  for (var i = 0; i < arrows.length; i++) {
    arrows[i].addEventListener("click", function () {
      this.classList.toggle("active");
    });
    arrows[i].addEventListener("mouseover", function () {
      this.querySelector(".arrow").classList.add("active");
    });
    arrows[i].addEventListener("mouseout", function () {
      this.querySelector(".arrow").classList.remove("active");
    });
  }
});

function toggleSubmenu(parent) {
  var submenu = parent.nextElementSibling;

  // Check if the submenu is open and close it, or open it if closed
  if (submenu.classList.contains("open")) {
    submenu.classList.remove("open");
  } else {
    // Close other open submenus before opening this one (optional)
    closeOpenSubmenus();

    submenu.classList.add("open");
  }
}

function closeOpenSubmenus() {
  const openSubmenus = document.querySelectorAll(".submenu.open");
  openSubmenus.forEach((openSubmenu) => {
    openSubmenu.classList.remove("open");
  });
}
// prevent double click mobile
const debounce = (func, delay) => {
  let timeoutId;
  return function () {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
      func.apply(this, arguments);
    }, delay);
  };
};

const handleClick = (event) => {
  event.preventDefault();
  // Your click logic here
  console.log("Link clicked!");
};

const debouncedClickHandler = debounce(handleClick, 1000); // 1000 milliseconds (adjust as needed)

const links = document.querySelectorAll("a");

links.forEach((link) => {
  link.addEventListener("click", debouncedClickHandler);
});
