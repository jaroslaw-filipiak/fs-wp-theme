import './single-product.scss';

import { gsap } from "gsap";
    
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollSmoother } from "gsap/ScrollSmoother";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";

gsap.registerPlugin(ScrollTrigger,ScrollSmoother,ScrollToPlugin);


let tl = gsap.timeline({
	scrollTrigger: {
		trigger: '.single-product-gallery',
		pin: '.entry-summary', 
		start: 'top 20%', 
		end: '+=500', 
		scrub: 1, 
		markers: false,
	}
});






