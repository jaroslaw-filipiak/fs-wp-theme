/**
 * ACF Component: Text and Image
 * JavaScript functionality for the text_and_image flexible content layout
 */

// Styles are loaded separately via PHP enqueue system

class TextAndImage {
  constructor() {
    this.components = document.querySelectorAll('.acf-text-and-image');
    this.init();
  }

  init() {
    if (this.components.length === 0) return;

    this.setupScrollAnimations();
    this.setupImageEffects();
    this.setupTextAnimations();
    this.handleImagePositions();
    this.addAccessibilityEnhancements();
  }

  /**
   * Setup scroll-triggered animations
   */
  setupScrollAnimations() {
    if (!window.IntersectionObserver) return;

    const observerOptions = {
      threshold: 0.15,
      rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          this.animateComponent(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    this.components.forEach(component => {
      observer.observe(component);
    });
  }

  /**
   * Animate component entrance
   */
  animateComponent(component) {
    component.classList.add('animate-in');

    // Stagger paragraph animations
    const paragraphs = component.querySelectorAll('.prose p');
    paragraphs.forEach((p, index) => {
      setTimeout(() => {
        p.style.opacity = '1';
        p.style.transform = 'translateY(0)';
      }, 100 * index);
    });
  }

  /**
   * Setup image effects and loading
   */
  setupImageEffects() {
    this.components.forEach(component => {
      const images = component.querySelectorAll('img');
      
      images.forEach(img => {
        // Lazy loading effect
        img.style.opacity = '0';
        img.style.transform = 'scale(0.95)';
        img.style.transition = 'opacity 0.6s ease, transform 0.6s ease';

        // Handle image load
        const handleLoad = () => {
          img.style.opacity = '1';
          img.style.transform = 'scale(1)';
          this.addImageInteractions(img);
        };

        if (img.complete) {
          handleLoad();
        } else {
          img.addEventListener('load', handleLoad);
          img.addEventListener('error', () => {
            this.handleImageError(img);
          });
        }
      });
    });
  }

  /**
   * Add interactive effects to images
   */
  addImageInteractions(img) {
    const container = img.closest('.image-container');
    if (!container) return;

    // Parallax effect on mouse move (subtle)
    container.addEventListener('mousemove', (e) => {
      const rect = container.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width;
      const y = (e.clientY - rect.top) / rect.height;
      
      const moveX = (x - 0.5) * 10;
      const moveY = (y - 0.5) * 10;
      
      img.style.transform = `scale(1.02) translate(${moveX}px, ${moveY}px)`;
    });

    container.addEventListener('mouseleave', () => {
      img.style.transform = 'scale(1)';
    });
  }

  /**
   * Handle image loading errors
   */
  handleImageError(img) {
    const container = img.closest('.image-container');
    if (!container) return;

    // Create placeholder
    const placeholder = document.createElement('div');
    placeholder.className = 'flex items-center justify-center bg-gray-100 text-gray-500 p-8 rounded-lg';
    placeholder.innerHTML = `
      <div class="text-center">
        <svg class="mx-auto h-12 w-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <p class="text-sm">Image not available</p>
      </div>
    `;

    container.replaceChild(placeholder, img);
  }

  /**
   * Setup text animations
   */
  setupTextAnimations() {
    this.components.forEach(component => {
      const paragraphs = component.querySelectorAll('.prose p');
      
      paragraphs.forEach(p => {
        p.style.opacity = '0';
        p.style.transform = 'translateY(20px)';
        p.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      });

      // Animate links on hover
      const links = component.querySelectorAll('.prose a');
      links.forEach(link => {
        link.addEventListener('mouseenter', () => {
          this.animateLink(link, true);
        });
        
        link.addEventListener('mouseleave', () => {
          this.animateLink(link, false);
        });
      });
    });
  }

  /**
   * Animate link interactions
   */
  animateLink(link, isHover) {
    if (isHover) {
      link.style.transform = 'translateY(-1px)';
      link.style.textShadow = '0 2px 4px rgba(0,0,0,0.1)';
    } else {
      link.style.transform = 'translateY(0)';
      link.style.textShadow = 'none';
    }
  }

  /**
   * Handle different image positions
   */
  handleImagePositions() {
    this.components.forEach(component => {
      // This would be set by PHP based on ACF field value
      const imagePosition = component.dataset.imagePosition || 'right';
      component.classList.add(`image-${imagePosition}`);
    });
  }

  /**
   * Add accessibility enhancements
   */
  addAccessibilityEnhancements() {
    this.components.forEach(component => {
      // Add skip link for screen readers
      const heading = component.querySelector('h2');
      if (heading && !heading.id) {
        heading.id = `heading-${Math.random().toString(36).substr(2, 9)}`;
      }

      // Ensure images have proper alt text
      const images = component.querySelectorAll('img:not([alt])');
      images.forEach(img => {
        img.setAttribute('alt', 'Content illustration');
      });

      // Add ARIA labels where needed
      const links = component.querySelectorAll('a:not([aria-label])');
      links.forEach(link => {
        if (!link.textContent.trim()) {
          link.setAttribute('aria-label', 'Read more');
        }
      });

      // Focus management
      const focusableElements = component.querySelectorAll(
        'a, button, [tabindex="0"], [tabindex="-1"]'
      );
      
      focusableElements.forEach(element => {
        element.addEventListener('focus', () => {
          this.handleFocus(element);
        });
      });
    });
  }

  /**
   * Handle focus events for better accessibility
   */
  handleFocus(element) {
    // Smooth scroll to focused element
    element.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });

    // Add focus indicator
    element.style.outline = '2px solid #3b82f6';
    element.style.outlineOffset = '2px';
    
    element.addEventListener('blur', () => {
      element.style.outline = '';
      element.style.outlineOffset = '';
    }, { once: true });
  }

  /**
   * Public method to reinitialize component
   */
  refresh() {
    this.components = document.querySelectorAll('.acf-text-and-image');
    this.init();
  }

  /**
   * Destroy component and clean up event listeners
   */
  destroy() {
    // Implementation for cleanup if needed
    this.components.forEach(component => {
      // Remove event listeners, observers, etc.
    });
  }
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  new TextAndImage();
});

// Make available globally for dynamic usage
window.TextAndImage = TextAndImage;

// Export for module usage
export default TextAndImage;
