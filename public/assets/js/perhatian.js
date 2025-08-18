function fadeOut(element, callback) {
  element.classList.remove("fade-in");
  element.classList.add("fade-out");
  element.addEventListener(
    "animationend",
    () => {
      element.style.display = "none";
      element.classList.remove("fade-out");
      if (callback) callback();
    },
    { once: true }
  );
}

function fadeIn(element) {
  element.style.display = "block";
  element.classList.add("fade-in");
}

function navigateToPage1() {
  const page1 = document.getElementById("page1");
  const page2 = document.getElementById("page2");

  fadeOut(page2, () => {
    fadeIn(page1);
  });
}

function navigateToPage2() {
  const page1 = document.getElementById("page1");
  const page2 = document.getElementById("page2");

  fadeOut(page1, () => {
    fadeIn(page2);
  });
}

function redirectToNewPage() {
  const checkbox = document.getElementById("agree-checkbox");

  if (checkbox.checked) {
    const verifikasiUrl = document.body.dataset.verifikasiUrl;
    window.location.href = verifikasiUrl;
  } else {
    const alertBox = document.getElementById("alert-box");
    alertBox.style.display = "block";
  }
}
