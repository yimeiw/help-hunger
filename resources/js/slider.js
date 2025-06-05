document.addEventListener('DOMContentLoaded', () => {
  const carousel = document.querySelector('#default-carousel');
  if (!carousel) return;

  const items = carousel.querySelectorAll('[data-carousel-item]');
  const indicators = carousel.querySelectorAll('[data-carousel-slide-to]');
  let currentIndex = 0;
  const totalItems = items.length;
  const intervalTime = 3000;

  const activeSrc = '/assets/indicator-active.svg';
  const inactiveSrc = '/assets/indicator-unactive.svg';

  function showSlide(index) {
    items.forEach((item, i) => {
      item.classList.toggle('hidden', i !== index);
      item.classList.toggle('block', i === index);
    });

    indicators.forEach((btn, i) => {
      btn.setAttribute('aria-current', i === index ? 'true' : 'false');

      const img = btn.querySelector('img');
      if (img) {
        img.src = i === index ? activeSrc : inactiveSrc;
      }
    });
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % totalItems;
    showSlide(currentIndex);
  }

  showSlide(currentIndex);
  setInterval(nextSlide, intervalTime);

  indicators.forEach((btn, i) => {
    btn.addEventListener('click', () => {
      currentIndex = i;
      showSlide(currentIndex);
    });
  });
});
