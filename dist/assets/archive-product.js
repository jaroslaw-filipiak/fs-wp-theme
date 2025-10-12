class s{constructor(){this.container=document.querySelector(".product-grid"),this.loader=document.querySelector(".infinite-scroll-loader"),this.currentPage=1,this.maxPages=parseInt(document.querySelector(".product-grid")?.dataset.maxPages||1),this.isLoading=!1,this.categoryId=document.querySelector(".product-grid")?.dataset.categoryId||"",this.observer=null,this.container&&this.maxPages>1&&this.init()}init(){const e=document.querySelector(".pagination-container");e&&(e.style.display="none"),this.createSentinel(),this.setupObserver()}createSentinel(){this.sentinel=document.createElement("div"),this.sentinel.className="infinite-scroll-sentinel",this.sentinel.style.height="1px",this.container.parentNode.insertBefore(this.sentinel,this.loader)}setupObserver(){const e={root:null,rootMargin:"200px",threshold:0};this.observer=new IntersectionObserver(t=>{t.forEach(r=>{r.isIntersecting&&!this.isLoading&&this.currentPage<this.maxPages&&this.loadMoreProducts()})},e),this.observer.observe(this.sentinel)}async loadMoreProducts(){if(this.isLoading||this.currentPage>=this.maxPages)return;this.isLoading=!0,this.showLoader();const e=this.currentPage+1;try{const t=new URL(window.location.origin+"/wp-json/fajnestarocie/v1/products");t.searchParams.append("page",e),this.categoryId&&t.searchParams.append("category",this.categoryId);const r=await fetch(t.toString());if(!r.ok)throw new Error("Błąd ładowania produktów");const i=await r.json();i.products&&i.products.length>0&&(this.appendProducts(i.products),this.currentPage=e,this.currentPage>=this.maxPages&&(this.observer.disconnect(),this.hideLoader()))}catch(t){console.error("Błąd podczas ładowania produktów:",t),this.showError()}finally{this.isLoading=!1,this.currentPage<this.maxPages&&this.hideLoader()}}appendProducts(e){const t=document.createDocumentFragment();e.forEach(r=>{const i=this.createProductElement(r);t.appendChild(i)}),this.container.appendChild(t)}createProductElement(e){const t=document.createElement("div");return t.className="product-item group fade-in",t.innerHTML=`
      <a href="${e.permalink}" class="block group">
        <img loading="lazy"
             class="block w-full group-hover:opacity-80 transition-opacity duration-200 mb-6 object-cover ${e.imageClass}"
             src="${e.image}"
             alt="${e.title}">
        <div>
          <h4 class="text-xl font-medium group-hover:text-teal-600 transition duration-200 mb-3">
            ${e.title}
          </h4>
          <p class="text-gray-700 mb-4 text-sm">
            ${e.excerpt}
          </p>
          <div class="text-md font-bold text-teal-900">
            ${e.price}
          </div>
        </div>
      </a>
    `,t}showLoader(){this.loader&&(this.loader.classList.remove("hidden"),this.loader.classList.add("visible"))}hideLoader(){this.loader&&(this.loader.classList.remove("visible"),this.loader.classList.add("hidden"))}showError(){const e=document.createElement("div");e.className="infinite-scroll-error text-center py-8",e.innerHTML=`
      <p class="text-red-600 mb-4">Wystąpił błąd podczas ładowania produktów.</p>
      <button class="retry-button h-12 inline-flex mt-3 py-1 px-5 items-center justify-center font-medium border transition duration-200 bg-transparent border-zinc-500 text-zinc-500 hover:bg-zinc-800 hover:text-white">
        Spróbuj ponownie
      </button>
    `,e.querySelector(".retry-button").addEventListener("click",()=>{e.remove(),this.isLoading=!1,this.loadMoreProducts()}),this.loader.parentNode.insertBefore(e,this.loader)}}document.addEventListener("DOMContentLoaded",()=>{new s});
