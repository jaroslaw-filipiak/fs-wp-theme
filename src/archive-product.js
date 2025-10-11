import './archive-product.scss';

class InfiniteScrollProducts {
  constructor() {
    this.container = document.querySelector('.product-grid');
    this.loader = document.querySelector('.infinite-scroll-loader');
    this.currentPage = 1;
    this.maxPages = parseInt(document.querySelector('.product-grid')?.dataset.maxPages || 1);
    this.isLoading = false;
    this.categoryId = document.querySelector('.product-grid')?.dataset.categoryId || '';
    this.observer = null;

    if (this.container && this.maxPages > 1) {
      this.init();
    }
  }

  init() {
    // Ukryj standardową paginację
    const pagination = document.querySelector('.pagination-container');
    if (pagination) {
      pagination.style.display = 'none';
    }

    // Utwórz sentinel element (element obserwowany)
    this.createSentinel();

    // Inicjalizuj Intersection Observer
    this.setupObserver();
  }

  createSentinel() {
    // Element, który będzie obserwowany - gdy wejdzie w viewport, załaduje kolejną stronę
    this.sentinel = document.createElement('div');
    this.sentinel.className = 'infinite-scroll-sentinel';
    this.sentinel.style.height = '1px';
    this.container.parentNode.insertBefore(this.sentinel, this.loader);
  }

  setupObserver() {
    const options = {
      root: null, // viewport
      rootMargin: '200px', // załaduj 200px przed dotarciem do elementu
      threshold: 0
    };

    this.observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !this.isLoading && this.currentPage < this.maxPages) {
          this.loadMoreProducts();
        }
      });
    }, options);

    this.observer.observe(this.sentinel);
  }

  async loadMoreProducts() {
    if (this.isLoading || this.currentPage >= this.maxPages) {
      return;
    }

    this.isLoading = true;
    this.showLoader();

    const nextPage = this.currentPage + 1;

    try {
      // Użyj WordPress REST API
      const url = new URL(window.location.origin + '/wp-json/fajnestarocie/v1/products');
      url.searchParams.append('page', nextPage);
      if (this.categoryId) {
        url.searchParams.append('category', this.categoryId);
      }

      const response = await fetch(url.toString());

      if (!response.ok) {
        throw new Error('Błąd ładowania produktów');
      }

      const data = await response.json();

      if (data.products && data.products.length > 0) {
        this.appendProducts(data.products);
        this.currentPage = nextPage;

        // Jeśli to była ostatnia strona, wyłącz observer
        if (this.currentPage >= this.maxPages) {
          this.observer.disconnect();
          this.hideLoader();
        }
      }
    } catch (error) {
      console.error('Błąd podczas ładowania produktów:', error);
      this.showError();
    } finally {
      this.isLoading = false;
      if (this.currentPage < this.maxPages) {
        this.hideLoader();
      }
    }
  }

  appendProducts(products) {
    const fragment = document.createDocumentFragment();

    products.forEach(product => {
      const productElement = this.createProductElement(product);
      fragment.appendChild(productElement);
    });

    this.container.appendChild(fragment);
  }

  createProductElement(product) {
    const div = document.createElement('div');
    div.className = 'product-item group fade-in';

    div.innerHTML = `
      <a href="${product.permalink}" class="block group">
        <img loading="lazy"
             class="block w-full group-hover:opacity-80 transition-opacity duration-200 mb-6 object-cover ${product.imageClass}"
             src="${product.image}"
             alt="${product.title}">
        <div>
          <h4 class="text-xl font-medium group-hover:text-teal-600 transition duration-200 mb-3">
            ${product.title}
          </h4>
          <p class="text-gray-700 mb-4 text-sm">
            ${product.excerpt}
          </p>
          <div class="text-md font-bold text-teal-900">
            ${product.price}
          </div>
        </div>
      </a>
    `;

    return div;
  }

  showLoader() {
    if (this.loader) {
      this.loader.classList.remove('hidden');
      this.loader.classList.add('visible');
    }
  }

  hideLoader() {
    if (this.loader) {
      this.loader.classList.remove('visible');
      this.loader.classList.add('hidden');
    }
  }

  showError() {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'infinite-scroll-error text-center py-8';
    errorDiv.innerHTML = `
      <p class="text-red-600 mb-4">Wystąpił błąd podczas ładowania produktów.</p>
      <button class="retry-button h-12 inline-flex mt-3 py-1 px-5 items-center justify-center font-medium border transition duration-200 bg-transparent border-zinc-500 text-zinc-500 hover:bg-zinc-800 hover:text-white">
        Spróbuj ponownie
      </button>
    `;

    const retryButton = errorDiv.querySelector('.retry-button');
    retryButton.addEventListener('click', () => {
      errorDiv.remove();
      this.isLoading = false;
      this.loadMoreProducts();
    });

    this.loader.parentNode.insertBefore(errorDiv, this.loader);
  }
}

// Inicjalizacja po załadowaniu DOM
document.addEventListener('DOMContentLoaded', () => {
  new InfiniteScrollProducts();
});
