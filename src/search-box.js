export default function handleSearchBox() {
  let search;
  let searchTrigger;
  document.addEventListener('DOMContentLoaded', function () {
    search = document.getElementById('search');
    searchTrigger = document.querySelector('.search-trigger');

    if (!searchTrigger) return;
    if (!search) return;

    searchTrigger.addEventListener('click', function () {
      search.classList.toggle('is-search-visible');
    });
  });
}
