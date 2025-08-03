export default function handleMobileMenu() {
  document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.querySelector('.hamburger');
    const mobileNav = document.querySelector('#mobile-nav');
    const mobileNavOverlay = document.querySelector('.mobile-nav-overlay');
    if (!hamburger) return;

    hamburger.addEventListener('click', function () {
      hamburger.classList.toggle('is-active');

      mobileNav.classList.toggle('w-[75vw]');
      mobileNav.classList.toggle('w-[0vw]');

      mobileNavOverlay.classList.toggle('w-[100vw]');
      mobileNavOverlay.classList.toggle('w-[0vw]');
    });
  });
}
