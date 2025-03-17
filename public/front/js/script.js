//  هنا القسم الخاص في الصيدليات القريبة  section 2


// Pagination variables
let currentPage = 0;
const itemsPerPage = 8;

// DOM elements
const pharmacyCardsContainer = document.getElementById('pharmacyCards');
const prevButton = document.querySelector('.nav-button.prev');
const nextButton = document.querySelector('.nav-button.next');
const paginationText = document.getElementById('paginationText');
const pharmacyCards = document.querySelectorAll('.pharmacy-card');

// Calculate total pages
const totalItems = pharmacyCards.length;
const totalPages = Math.ceil(totalItems / itemsPerPage);

// Function to show/hide pharmacy cards based on current page
function updateVisibleCards() {
  // Calculate start and end indexes for the current page
  const startIndex = currentPage * itemsPerPage;
  const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

  // Hide all cards first
  pharmacyCards.forEach((card, index) => {
    if (index >= startIndex && index < endIndex) {
      card.style.display = 'flex'; // Show cards for the current page
    } else {
      card.style.display = 'none'; // Hide other cards
    }
  });

  // Update pagination text
  paginationText.textContent = `${currentPage + 1} / ${totalPages}`;

  // Hide pagination elements if not needed
  if (totalItems <= itemsPerPage) {
    prevButton.style.display = 'none';
    nextButton.style.display = 'none';
    document.querySelector('.pagination-indicator').style.display = 'none';
  } else {
    prevButton.style.display = 'flex';
    nextButton.style.display = 'flex';
    document.querySelector('.pagination-indicator').style.display = 'block';
  }
}

// Navigation event handlers
prevButton.addEventListener('click', () => {
  if (currentPage > 0) {
    currentPage--;
  } else {
    currentPage = totalPages - 1; // Loop back to the last page
  }
  updateVisibleCards();
});

nextButton.addEventListener('click', () => {
  if (currentPage < totalPages - 1) {
    currentPage++;
  } else {
    currentPage = 0; // Loop back to the first page
  }
  updateVisibleCards();
});

// Initialize the page
document.addEventListener('DOMContentLoaded', () => {
  updateVisibleCards();
});








//  القسم الخاص في التعليقات

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Get testimonial elements
  const testimonialCards = document.querySelectorAll('.testimonial-card');
  const prevBtn = document.getElementById('prev-btn');
  const nextBtn = document.getElementById('next-btn');

  let currentIndex = 0;
  const totalTestimonials = testimonialCards.length;

  // Function to show a specific testimonial
  function showTestimonial(index) {
    // Hide all testimonials
    testimonialCards.forEach(card => {
      card.classList.remove('active');
    });

    // Show the selected testimonial
    testimonialCards[index].classList.add('active');
  }

  // Function to show next testimonial
  function showNextTestimonial() {
    currentIndex = (currentIndex + 1) % totalTestimonials;
    showTestimonial(currentIndex);
  }

  // Function to show previous testimonial
  function showPrevTestimonial() {
    currentIndex = (currentIndex - 1 + totalTestimonials) % totalTestimonials;
    showTestimonial(currentIndex);
  }

  // Add click event listeners to navigation buttons
  if (prevBtn) {
    prevBtn.addEventListener('click', showPrevTestimonial);
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', showNextTestimonial);
  }

  // Auto rotate testimonials every 7 seconds
  const autoRotate = setInterval(showNextTestimonial, 7000);

  // Stop rotation when user interacts with navigation
  [prevBtn, nextBtn].forEach(btn => {
    if (btn) {
      btn.addEventListener('click', function() {
        clearInterval(autoRotate);
      });
    }
  });

  // Ensure the first testimonial is shown when the page loads
  showTestimonial(currentIndex);
});








//   منتجات طبية
document.addEventListener('DOMContentLoaded', function() {
  // Get carousel elements
  const carousel = document.getElementById('productCarousel');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');

  // Get all product cards in the carousel
  const productCards = carousel.querySelectorAll('.product-card');

  // Calculate items per view based on screen width
  function getItemsPerView() {
    if (window.innerWidth < 640) {
      return 1;
    } else if (window.innerWidth < 768) {
      return 2;
    } else if (window.innerWidth < 1024) {
      return 3;
    } else {
      return 4;
    }
  }

  // Initial items per view
  let itemsPerView = getItemsPerView();
  let currentIndex = 0;

  // Update button visibility
  function updateButtonsVisibility() {
    prevBtn.style.display = currentIndex > 0 ? 'flex' : 'none';
    nextBtn.style.display = currentIndex < productCards.length - itemsPerView ? 'flex' : 'none';
  }

  // Scroll to next item
  function scrollNext() {
    if (currentIndex < productCards.length - itemsPerView) {
      currentIndex++;
      scrollToCurrentIndex();
    }
    updateButtonsVisibility();
  }

  // Scroll to previous item
  function scrollPrev() {
    if (currentIndex > 0) {
      currentIndex--;
      scrollToCurrentIndex();
    }
    updateButtonsVisibility();
  }

  // Scroll to current index
  function scrollToCurrentIndex() {
    const itemWidth = carousel.scrollWidth / productCards.length;
    carousel.scrollTo({
      left: currentIndex * itemWidth,
      behavior: 'smooth'
    });
  }

  // Handle window resize
  function handleResize() {
    const newItemsPerView = getItemsPerView();
    if (newItemsPerView !== itemsPerView) {
      itemsPerView = newItemsPerView;
      // Ensure currentIndex is valid after resize
      if (currentIndex > productCards.length - itemsPerView) {
        currentIndex = Math.max(0, productCards.length - itemsPerView);
      }
      scrollToCurrentIndex();
      updateButtonsVisibility();
    }
  }

  // Add event listeners
  prevBtn.addEventListener('click', scrollPrev);
  nextBtn.addEventListener('click', scrollNext);
  window.addEventListener('resize', handleResize);

  // Initialize
  updateButtonsVisibility();
});
