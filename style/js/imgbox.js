document.addEventListener("DOMContentLoaded", () => {
  const galleryModal = document.getElementById("galleryModal");
  const galleryMainImage = document.getElementById("galleryMainImage");
  const galleryThumbnails = document.getElementById("galleryThumbnails");
  const zoomDisplay = document.getElementById("zoomDisplay");
  const zoomInBtn = document.getElementById("zoomIn");
  const zoomOutBtn = document.getElementById("zoomOut");
  const zoomResetBtn = document.getElementById("zoomReset");
  let currentIndex = 0;
  let allImages = [];
  let zoomScale = 1;
  let hintTimer = null;
  function initGallery() {
    const articleImages = document.querySelectorAll(".post-main img");
    allImages = Array.from(articleImages);
    articleImages.forEach((img, index) => {
      img.addEventListener("click", () => openGallery(index));
    });
  }
  function openGallery(clickedIndex) {
    currentIndex = clickedIndex;
    galleryModal.style.display = "block";
    document.body.style.overflow = "hidden";
    updateMainImage();
    createThumbnails();
  }
  function updateMainImage() {
    if (!allImages[currentIndex]) return;
    galleryMainImage.src = allImages[currentIndex].src;
    galleryMainImage.alt = allImages[currentIndex].alt;
    zoomScale = 1;
    updateZoomDisplay();
    galleryMainImage.style.opacity = 0;
    galleryMainImage.style.transform = "scale(0.95)";
    setTimeout(() => {
      galleryMainImage.style.transition = "opacity 0.4s, transform 0.4s";
      galleryMainImage.style.opacity = 1;
      galleryMainImage.style.transform = "scale(1)";
    }, 10);
    const thumbs = document.querySelectorAll(".gallery-thumb");
    thumbs.forEach((thumb, idx) => {
      thumb.classList.toggle("active", idx === currentIndex);
    });
    scrollToCurrentThumb();
  }
  function createThumbnails() {
    galleryThumbnails.innerHTML = "";
    allImages.forEach((img, index) => {
      const thumb = document.createElement("img");
      thumb.className = "gallery-thumb";
      thumb.src = img.src;
      thumb.alt = `${img.alt}`;
      if (index === currentIndex) {
        thumb.classList.add("active");
      }
      thumb.addEventListener("click", (e) => {
        e.stopPropagation();
        currentIndex = index;
        updateMainImage();
      });
      galleryThumbnails.appendChild(thumb);
    });
  }
  function prevImage() {
    currentIndex = (currentIndex - 1 + allImages.length) % allImages.length;
    updateMainImage();
  }
  function nextImage() {
    currentIndex = (currentIndex + 1) % allImages.length;
    updateMainImage();
  }
  function scrollToCurrentThumb() {
    const activeThumb = document.querySelector(".gallery-thumb.active");
    if (activeThumb) {
      activeThumb.scrollIntoView({
        behavior: "smooth",
        block: "nearest",
        inline: "center",
      });
    }
  }
  function closeGallery() {
    galleryModal.style.display = "none";
    document.body.style.overflow = "";
    if (allImages[currentIndex]) {
      allImages[currentIndex].scrollIntoView({
        behavior: "smooth",
        block: "center",
      });
    }
  }
  function zoomIn() {
    if (zoomScale < 5) {
      zoomScale += 0.25;
      applyZoom();
    }
  }
  function zoomOut() {
    if (zoomScale > 0.5) {
      zoomScale -= 0.25;
      applyZoom();
    }
  }
  function resetZoom() {
    zoomScale = 1;
    applyZoom();
  }
  function applyZoom() {
    galleryMainImage.style.transform = `scale(${zoomScale})`;
    updateZoomDisplay();
  }
  function updateZoomDisplay() {
    zoomDisplay.textContent = `×${zoomScale}`;
  }
  function handleKeyDown(e) {
    if (!galleryModal.style.display || galleryModal.style.display === "none")
      return;
    switch (e.key) {
      case "ArrowLeft":
      case "ArrowUp":
        prevImage();
        e.preventDefault();
        break;
      case "ArrowRight":
      case "ArrowDown":
        nextImage();
        e.preventDefault();
        break;
      case "+":
      case "=":
        zoomIn();
        e.preventDefault();
        break;
      case "-":
      case "_":
        zoomOut();
        e.preventDefault();
        break;
      case "0":
      case "o":
        resetZoom();
        e.preventDefault();
        break;
      case "Escape":
        closeGallery();
        e.preventDefault();
        break;
      case " ":
        nextImage();
        e.preventDefault();
        break;
    }
  }
  function bindEvents() {
    document
      .querySelector(".gallery-prev")
      .addEventListener("click", prevImage);
    document
      .querySelector(".gallery-next")
      .addEventListener("click", nextImage);
    document
      .querySelector(".gallery-close")
      .addEventListener("click", closeGallery);
    galleryModal.addEventListener("click", (e) => {
      if (e.target === galleryModal) closeGallery();
    });
    zoomInBtn.addEventListener("click", zoomIn);
    zoomOutBtn.addEventListener("click", zoomOut);
    zoomResetBtn.addEventListener("click", resetZoom);
    document.addEventListener("keydown", handleKeyDown);
    galleryModal.addEventListener(
      "wheel",
      (e) => {
        if (galleryModal.style.display === "none") return;
        if (e.deltaY < 0) prevImage();
        else if (e.deltaY > 0) nextImage();
      },
      { passive: false },
    );
  }
  initGallery();
  bindEvents();
});
