import './single-product.scss';


import { gsap } from "gsap";
    
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollSmoother } from "gsap/ScrollSmoother";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";

window.addEventListener('DOMContentLoaded', () => {

gsap.registerPlugin(ScrollTrigger,ScrollSmoother,ScrollToPlugin);

gsap.timeline({
	scrollTrigger: {
		trigger: '.single-product-gallery',
		pin: '.entry-summary',
		pinSpacing: true,
		start: 'top 20%', 
		end: '+=100%',
		scrub: 1,
		markers: false,
		anticipatePin: 1,
		
	}
});
});



