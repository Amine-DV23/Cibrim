document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const logoutMenu = document.querySelector(".logout");
    const userInfo = document.querySelector(".user-info");
    const menuToggle = document.querySelector(".menu-toggle");
    const userArrow = document.querySelector(".user-arrow");

    document.addEventListener("click", function (event) {
      const isClickInsideSidebar = sidebar.contains(event.target);
      const isClickInsideLogout = logoutMenu.contains(event.target);
      const isClickInsideUserInfo = userInfo.contains(event.target);
      const isClickInsideMenuToggle = menuToggle.contains(event.target);

      // إغلاق الـ sidebar إذا تم النقر خارجها
      if (sidebar.classList.contains("active") && !isClickInsideSidebar && !isClickInsideMenuToggle) {
        sidebar.classList.remove("active");
      }

      // إغلاق الـ logout إذا تم النقر خارجها
      if (logoutMenu.classList.contains("active") && !isClickInsideLogout && !isClickInsideUserInfo) {
        logoutMenu.classList.remove("active");
        userArrow.classList.remove("fa-chevron-up");
        userArrow.classList.add("fa-chevron-down");
      }
    });
  });

  function toggleNav() {
    const nav = document.querySelector(".sidebar");
    nav.classList.toggle("active");
  }

  function toggleUserInfo() {
    const logout = document.querySelector(".logout");
    const userArrow = document.querySelector(".user-arrow");
    logout.classList.toggle("active");

    if (logout.classList.contains("active")) {
      userArrow.classList.remove("fa-chevron-down");
      userArrow.classList.add("fa-chevron-up");
    } else {
      userArrow.classList.remove("fa-chevron-up");
      userArrow.classList.add("fa-chevron-down");
    }
  }

  function toggleSettings() {
    const settingsDropdown = document.querySelector(".settings-dropdown");
    const settingsIcon = document.querySelector(".settings-icon");
    settingsDropdown.classList.toggle("active");
    if (settingsDropdown.classList.contains("active")) {
      settingsIcon.classList.remove("fa-chevron-down");
      settingsIcon.classList.add("fa-chevron-up");
    } else {
      settingsIcon.classList.remove("fa-chevron-up");
      settingsIcon.classList.add("fa-chevron-down");
    }
  }


function toggleNav() {
  const nav = document.querySelector(".sidebar");
  nav.classList.toggle("active");
}

function toggleSettings() {
  const settingsDropdown = document.querySelector(".settings-dropdown");
  const settingsIcon = document.querySelector(".settings-icon");
  settingsDropdown.classList.toggle("active");
  if (settingsDropdown.classList.contains("active")) {
    settingsIcon.classList.remove("fa-chevron-down");
    settingsIcon.classList.add("fa-chevron-up");
  } else {
    settingsIcon.classList.remove("fa-chevron-up");
    settingsIcon.classList.add("fa-chevron-down");
  }
}

function toggleLogout() {
  const logout = document.querySelector(".logout");
  logout.classList.toggle("active");
}

function toggleUserInfo() {
  const userArrow = document.querySelector(".user-arrow");
  const logout = document.querySelector(".logout");
  logout.classList.toggle("active");
  if (logout.classList.contains("active")) {
    userArrow.classList.remove("fa-chevron-down");
    userArrow.classList.add("fa-chevron-up");
  } else {
    userArrow.classList.remove("fa-chevron-up");
    userArrow.classList.add("fa-chevron-down");
  }
}

let dataList = [];

function showSpinner() {
  document.getElementById("spinner").style.display = "block";
}

function hideSpinner() {
  document.getElementById("spinner").style.display = "none";
}

function showSuccessMessage() {
  const successMessage = document.getElementById("success-message");
  successMessage.style.display = "block";
  setTimeout(() => {
    successMessage.style.display = "none";
  }, 2000);
}

function showErrorMessage() {
  const errorMessage = document.getElementById("error-message");
  errorMessage.style.display = "block";
  setTimeout(() => {
    errorMessage.style.display = "none";
  }, 2000);
}

function filterproducts() {
  const filter = document
    .getElementById("searchInput")
    .value.toLowerCase();
  const rows = document.querySelectorAll("tbody tr");

  rows.forEach((row) => {
    const productName = row.cells[0].textContent.toLowerCase();
    if (productName.startsWith(filter)) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}
