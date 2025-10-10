import './single-product.scss';

window.addEventListener('DOMContentLoaded', () => {
  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1,
  };

  const callback = (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        stickyBar.classList.remove('single-product-sticky-bar--active');
      } else {
        stickyBar.classList.add('single-product-sticky-bar--active');
      }
    });
  };

  const observer = new IntersectionObserver(callback, observerOptions);

  const btn = document.querySelector('.summary .single_add_to_cart_button');
  const stickyBar = document.querySelector('.single-product-sticky-bar');
  observer.observe(btn);
});
