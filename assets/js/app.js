const tabGroups = document.querySelectorAll('[data-tabs]');

for (const tabGroup of tabGroups) {
  const tabButtons = tabGroup.querySelectorAll('[data-tab]');
  const tabPanels = tabGroup.parentElement.querySelectorAll('[data-panel]');

  function showTab(tabName) {
    for (const tabButton of tabButtons) {
      const isSelected = tabButton.dataset.tab === tabName;
      tabButton.classList.toggle('is-active', isSelected);
    }

    for (const tabPanel of tabPanels) {
      tabPanel.hidden = tabPanel.dataset.panel !== tabName;
    }
  }

  for (const tabButton of tabButtons) {
    tabButton.addEventListener('click', function () {
      showTab(tabButton.dataset.tab);
    });
  }
}

const imageInput = document.querySelector('[data-image-preview]');
if (imageInput) {
  let previewObjectUrl = null;

  imageInput.addEventListener('change', function () {
    const imagePreview = document.getElementById('image-preview');
    const selectedFile = imageInput.files[0];
    if (!selectedFile || !imagePreview) {
      return;
    }

    if (previewObjectUrl) {
      URL.revokeObjectURL(previewObjectUrl);
    }
    previewObjectUrl = URL.createObjectURL(selectedFile);
    imagePreview.src = previewObjectUrl;
    imagePreview.hidden = false;
  });
}

const copyButton = document.querySelector('[data-copy-link]');
if (copyButton) {
  copyButton.addEventListener('click', function () {
    navigator.clipboard.writeText(location.href).then(function () {
      copyButton.textContent = 'Link gekopieerd';
    });
  });
}

const slides = document.querySelectorAll('.drop-photos .drop-slide');
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (slides.length > 1 && !reducedMotion) {
  let currentSlide = 0;
  for (const slide of slides) {
    if (slide.classList.contains('is-shown')) {
      currentSlide = Number(slide.dataset.slide);
    }
  }

  setInterval(function () {
    if (document.hidden) {
      return;
    }
    currentSlide = (currentSlide + 1) % slides.length;
    for (const slidePart of document.querySelectorAll('[data-slide]')) {
      slidePart.classList.toggle('is-shown', Number(slidePart.dataset.slide) === currentSlide);
    }
  }, 6000);
}

const revealParts = document.querySelectorAll('.reveal');

if ('IntersectionObserver' in window) {
  const revealObserver = new IntersectionObserver(function (entries) {
    for (const entry of entries) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        revealObserver.unobserve(entry.target);
      }
    }
  }, { threshold: 0.15 });

  for (const revealPart of revealParts) {
    revealObserver.observe(revealPart);
  }
} else {
  for (const revealPart of revealParts) {
    revealPart.classList.add('is-visible');
  }
}
