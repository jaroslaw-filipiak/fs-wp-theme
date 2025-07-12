import './style.scss';


// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle';

// import styles bundle
import 'swiper/css/bundle';


//home page slider
const productsSlider = new Swiper('.products-slider', {
    direction: 'horizontal',
    loop: true,
    slidesPerView: 5,
    autoplay: {
        delay: 2500,
        disableOnInteraction: true,
    },
    centeredSlides: true,
  
    navigation: {
      nextEl: '.products-slider .fajnestarocie-swiper-button-next',
      prevEl: '.products-slider .fajnestarocie-swiper-button-prev',
    },
  
  
});

const reviewsSlider = new Swiper('.reviews-slider', {
    direction: 'horizontal',
    loop: true,
    slidesPerView: 3,
    autoplay: {
        delay: 2500,
        disableOnInteraction: true,
    },
    scrollbar: {
      el: '.reviews-slider-scrollbar',
      draggable: true,
      dragSize: 100,
      draggableTrack: true,
      draggableTrackClickable: true,
      draggableTrackClickable: true,
      enabled: true, 
      snapOnRelease: true,
    }
});