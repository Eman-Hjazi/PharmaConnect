// App state
let activeCategory = 'all';
let currentPage = 1;
let productsPerPage = 8;
let totalPages = 2;
let favorites = {};

// DOM Elements
const categoryTabsContainer = document.getElementById('categoryTabs');
const productGridContainer = document.getElementById('productGrid');
const paginationContainer = document.getElementById('pagination');

// Initialize the app
function initApp() {
  setupCategoryTabs();
  setupProductInteractions();
  setupPagination();
  filterProducts();
  updateActivePage();
}

// Setup category tabs interactions
function setupCategoryTabs() {
  const tabs = categoryTabsContainer.querySelectorAll('.category-tab');
  tabs.forEach(tab => {
    tab.addEventListener('click', function() {
      const category = this.getAttribute('data-category');
      if (category !== activeCategory) {
        // Update active category
        activeCategory = category;
        // Reset to page 1
        currentPage = 1;

        // Update active tab UI
        tabs.forEach(t => t.classList.remove('active'));
        this.classList.add('active');

        // Apply filtering
        filterProducts();
        updateActivePage();
        updatePagination();
      }
    });
  });
}

// Setup product interactions (favorites & cart)
function setupProductInteractions() {
  // Favorite button interactions
  const favoriteButtons = document.querySelectorAll('.favorite-button');
  favoriteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const productId = this.getAttribute('data-id');
      toggleFavorite(productId, this);
    });
  });

//   // Cart button interactions
//   const cartButtons = document.querySelectorAll('.cart-button');
//   cartButtons.forEach(button => {
//     button.addEventListener('click', function() {
//       const productId = this.getAttribute('data-id');
//       addToCart(productId);
//     });
//   });
}

// Filter products based on active category
function filterProducts() {
  const allProducts = productGridContainer.querySelectorAll('.product-card');

  allProducts.forEach(product => {
    const productCategory = product.getAttribute('data-category');
    if (activeCategory === 'all' || productCategory === activeCategory) {
      product.classList.add('active');
    } else {
      product.classList.remove('active');
      product.classList.remove('current-page');
    }
  });

  // Recalculate pagination
  const filteredProducts = productGridContainer.querySelectorAll('.product-card.active');
  totalPages = Math.ceil(filteredProducts.length / productsPerPage) || 1;
}

// Update active page products
function updateActivePage() {
  const activeProducts = productGridContainer.querySelectorAll('.product-card.active');

  activeProducts.forEach((product, index) => {
    const productPage = Math.floor(index / productsPerPage) + 1;

    if (productPage === currentPage) {
      product.classList.add('current-page');
    } else {
      product.classList.remove('current-page');
    }
  });

  // Scroll to top
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Setup pagination interactions
function setupPagination() {
  // Page button click handlers
  document.querySelectorAll('.page-button[data-page]').forEach(button => {
    button.addEventListener('click', function() {
      const page = parseInt(this.getAttribute('data-page'));
      if (page !== currentPage) {
        currentPage = page;
        updateActivePage();
        updatePagination();
      }
    });
  });

  // Previous page button
  const prevButton = document.getElementById('prev-page');
  if (prevButton) {
    prevButton.addEventListener('click', function() {
      if (currentPage > 1) {
        currentPage--;
        updateActivePage();
        updatePagination();
      }
    });
  }

  // Next page button
  const nextButton = document.getElementById('next-page');
  if (nextButton) {
    nextButton.addEventListener('click', function() {
      if (currentPage < totalPages) {
        currentPage++;
        updateActivePage();
        updatePagination();
      }
    });
  }
}

// Update pagination UI
function updatePagination() {
  // Update active page button
  const pageButtons = document.querySelectorAll('.page-button[data-page]');
  pageButtons.forEach(button => {
    const page = parseInt(button.getAttribute('data-page'));
    if (page === currentPage) {
      button.classList.add('active');
    } else {
      button.classList.remove('active');
    }
  });

  // Update prev/next buttons state
  const prevButton = document.getElementById('prev-page');
  const nextButton = document.getElementById('next-page');

  if (prevButton) {
    prevButton.disabled = currentPage === 1;
  }

  if (nextButton) {
    nextButton.disabled = currentPage === totalPages;
  }
}

// Toggle favorite status
function toggleFavorite(productId, button) {
  favorites[productId] = !favorites[productId];

  // Update icon
  const icon = button.querySelector('.favorite-icon');
  if (favorites[productId]) {
    icon.classList.remove('fa-regular');
    icon.classList.add('fa-solid');
    showToast('تمت الإضافة للمفضلة');
  } else {
    icon.classList.remove('fa-solid');
    icon.classList.add('fa-regular');
    showToast('تمت الإزالة من المفضلة');
  }
}

// // Add to cart
// function addToCart(productId) {
//   const product = document.querySelector(`.product-card[data-id="${productId}"]`);
//   if (product) {
//     const productName = product.querySelector('.product-name').textContent;
//     showToast(`تمت الإضافة للسلة: ${productName} - 150 ر.س`);
//   }
// }

// // Show toast notification
// function showToast(message) {
//   const toast = document.getElementById('toast');

//   // Set message and show toast
//   toast.textContent = message;
//   toast.style.display = 'block';

//   // Hide after 2 seconds
//   setTimeout(() => {
//     toast.style.display = 'none';
//   }, 2000);
// }


// Initialize the app when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', initApp);
