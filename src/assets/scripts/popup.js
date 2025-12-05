// popup.js

const openTerms = document.getElementById("openTerms");
const popupOverlay = document.getElementById("popupOverlay");
const closePopup = document.getElementById("closePopup");

popupOverlay.style.display = "none";

openTerms.addEventListener("click", () => {
    popupOverlay.style.display = "flex";
});

closePopup.addEventListener("click", () => {
    popupOverlay.style.display = "none";
});
