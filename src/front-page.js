import './front-page.scss';

import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';


document.addEventListener('DOMContentLoaded', function() {
    //home page slider
    const productsSlider = new Swiper('.products-slider', {
        direction: 'horizontal',
        loop: true,
        slidesPerView: 2,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        centeredSlides: true,
       
        navigation: {
          nextEl: '.products-slider .fajnestarocie-swiper-button-next',
          prevEl: '.products-slider .fajnestarocie-swiper-button-prev',
        },

        breakpoints: {
            '@0.75': {
              slidesPerView: 2,
            },
            '@1.00': {
              slidesPerView: 3,
            },
            '@1.50': {
              slidesPerView: 4, 
            },
        }
    });

    // home page reviews slider
    const reviewsSlider = new Swiper('.reviews-slider', {
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
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
            },
            breakpoints: {
              '@0.75': {
                slidesPerView: 1,
              },
              '@1.00': {
                slidesPerView: 3,
              },
              '@1.50': {
                slidesPerView: 4, 
              },
          }
        });

})


