(function () {
  const container = document.getElementById("productGrid");
  if (!container) return;

  // State management
  let view = "grid";
  let currentFilter = "all";
  let searchTerm = "";
  let sortKey = "created";
  let sortDir = "desc";

  // Pagination state
  let currentPage = 1;
  let pageSize = 12;
  let allCards = [];
  let filteredCards = [];

  // Pagination elements
  const paginationWrapper = document.getElementById("paginationWrapper");
  const paginationInfo = document.getElementById("paginationInfo");
  const paginationNav = document.getElementById("paginationNav");
  const pageNumbers = document.getElementById("pageNumbers");
  const firstPageBtn = document.getElementById("firstPageBtn");
  const prevPageBtn = document.getElementById("prevPageBtn");
  const nextPageBtn = document.getElementById("nextPageBtn");
  const lastPageBtn = document.getElementById("lastPageBtn");
  const pageSizeSelect = document.getElementById("pageSize");

  const getCards = () =>
    Array.from(container.querySelectorAll(".product-card"));

  // Initialize cards array
  function initializeCards() {
    allCards = getCards();
    if (allCards.length > 0) {
      setupPagination();
    }
  }

  function applyFilters() {
    filteredCards = allCards.filter((card) => {
      const name = card.dataset.name || "";
      const sku = card.dataset.sku || "";
      const active = card.dataset.active === "1";
      const sale = card.dataset.sale === "1";
      const stock = parseFloat(card.dataset.stock || "0");
      const low = card.dataset.low === "1" || (stock > 0 && stock < 10);
      const out = card.dataset.out === "1" || stock === 0;

      let filterPass = true;
      switch (currentFilter) {
        case "active":
          filterPass = active;
          break;
        case "sale":
          filterPass = sale;
          break;
        case "low":
          filterPass = low;
          break;
        case "out":
          filterPass = out;
          break;
        default:
          filterPass = true;
      }

      const matchesSearch =
        !searchTerm || name.includes(searchTerm) || sku.includes(searchTerm);
      return filterPass && matchesSearch;
    });

    // Reset to first page when filters change
    currentPage = 1;
    updatePagination();
    displayCurrentPage();
  }

  function applySort() {
    const dirFactor = sortDir === "asc" ? 1 : -1;
    filteredCards.sort((a, b) => {
      let av, bv;
      switch (sortKey) {
        case "price":
          av = parseFloat(a.dataset.price || "0");
          bv = parseFloat(b.dataset.price || "0");
          break;
        case "stock":
          av = parseFloat(a.dataset.stock || "0");
          bv = parseFloat(b.dataset.stock || "0");
          break;
        case "fav":
          av = parseFloat(a.dataset.fav || "0");
          bv = parseFloat(b.dataset.fav || "0");
          break;
        case "created":
          av = parseFloat(a.dataset.created || "0");
          bv = parseFloat(b.dataset.created || "0");
          break;
        case "name":
        default:
          av = a.dataset.name || "";
          bv = b.dataset.name || "";
          return av.localeCompare(bv) * dirFactor;
      }
      return (av - bv) * dirFactor;
    });

    displayCurrentPage();
  }

  function setupPagination() {
    if (allCards.length <= 6) {
      // Don't show pagination if we have very few items
      paginationWrapper.style.display = "none";
      return;
    }

    paginationWrapper.style.display = "flex";

    // Page size selector
    pageSizeSelect.addEventListener("change", function () {
      const newSize = this.value;
      if (newSize === "all") {
        pageSize = filteredCards.length || allCards.length;
        paginationWrapper.style.display = "none";
      } else {
        pageSize = parseInt(newSize);
        paginationWrapper.style.display = "flex";
      }
      currentPage = 1;
      updatePagination();
      displayCurrentPage();
    });

    // Navigation buttons
    firstPageBtn.addEventListener("click", () => goToPage(1));
    prevPageBtn.addEventListener("click", () => goToPage(currentPage - 1));
    nextPageBtn.addEventListener("click", () => goToPage(currentPage + 1));
    lastPageBtn.addEventListener("click", () => {
      const totalPages = Math.ceil(filteredCards.length / pageSize);
      goToPage(totalPages);
    });
  }

  function updatePagination() {
    if (pageSizeSelect.value === "all") {
      paginationWrapper.style.display = "none";
      return;
    }

    const totalItems = filteredCards.length;
    const totalPages = Math.ceil(totalItems / pageSize);

    if (totalPages <= 1) {
      paginationWrapper.style.display = "none";
      return;
    }

    paginationWrapper.style.display = "flex";

    // Update pagination info
    const startItem = Math.min((currentPage - 1) * pageSize + 1, totalItems);
    const endItem = Math.min(currentPage * pageSize, totalItems);
    paginationInfo.textContent = `Showing ${startItem}-${endItem} of ${totalItems} products`;

    // Update navigation buttons
    firstPageBtn.classList.toggle("disabled", currentPage === 1);
    prevPageBtn.classList.toggle("disabled", currentPage === 1);
    nextPageBtn.classList.toggle("disabled", currentPage === totalPages);
    lastPageBtn.classList.toggle("disabled", currentPage === totalPages);

    // Generate page numbers
    generatePageNumbers(totalPages);
  }

  function generatePageNumbers(totalPages) {
    pageNumbers.innerHTML = "";

    if (totalPages <= 7) {
      // Show all pages if 7 or fewer
      for (let i = 1; i <= totalPages; i++) {
        pageNumbers.appendChild(createPageButton(i));
      }
    } else {
      // Smart pagination with ellipsis
      if (currentPage <= 4) {
        // Show: 1 2 3 4 5 ... last
        for (let i = 1; i <= 5; i++) {
          pageNumbers.appendChild(createPageButton(i));
        }
        pageNumbers.appendChild(createEllipsis());
        pageNumbers.appendChild(createPageButton(totalPages));
      } else if (currentPage >= totalPages - 3) {
        // Show: 1 ... last-4 last-3 last-2 last-1 last
        pageNumbers.appendChild(createPageButton(1));
        pageNumbers.appendChild(createEllipsis());
        for (let i = totalPages - 4; i <= totalPages; i++) {
          pageNumbers.appendChild(createPageButton(i));
        }
      } else {
        // Show: 1 ... current-1 current current+1 ... last
        pageNumbers.appendChild(createPageButton(1));
        pageNumbers.appendChild(createEllipsis());
        for (let i = currentPage - 1; i <= currentPage + 1; i++) {
          pageNumbers.appendChild(createPageButton(i));
        }
        pageNumbers.appendChild(createEllipsis());
        pageNumbers.appendChild(createPageButton(totalPages));
      }
    }
  }

  function createPageButton(pageNum) {
    const btn = document.createElement("button");
    btn.className = "page-btn";
    btn.textContent = pageNum;
    btn.classList.toggle("active", pageNum === currentPage);
    btn.addEventListener("click", () => goToPage(pageNum));
    return btn;
  }

  function createEllipsis() {
    const span = document.createElement("span");
    span.className = "pagination-dots";
    span.innerHTML = "&hellip;";
    return span;
  }

  function goToPage(page) {
    const totalPages = Math.ceil(filteredCards.length / pageSize);
    if (page < 1 || page > totalPages || page === currentPage) return;

    currentPage = page;
    updatePagination();
    displayCurrentPage();

    // Smooth scroll to top of products
    container.scrollIntoView({ behavior: "smooth", block: "start" });
  }

  function displayCurrentPage() {
    // Hide all cards
    allCards.forEach((card) => {
      card.style.display = "none";
      card.classList.add("d-none");
    });

    if (pageSizeSelect.value === "all") {
      // Show all filtered cards
      filteredCards.forEach((card) => {
        card.style.display = "";
        card.classList.remove("d-none");
      });
    } else {
      // Show current page cards
      const startIndex = (currentPage - 1) * pageSize;
      const endIndex = Math.min(startIndex + pageSize, filteredCards.length);

      for (let i = startIndex; i < endIndex; i++) {
        if (filteredCards[i]) {
          filteredCards[i].style.display = "";
          filteredCards[i].classList.remove("d-none");
        }
      }
    }

    // Re-append cards in correct order
    filteredCards.forEach((card) => {
      if (!card.classList.contains("d-none")) {
        container.appendChild(card);
      }
    });
  }

  // Search
  const input = document.getElementById("productSearch");
  if (input) {
    input.addEventListener("input", function (e) {
      searchTerm = (e.target.value || "").toLowerCase().trim();
      applyFilters();
    });
  }

  // Filter pills
  document.querySelectorAll(".filter-pill").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      document
        .querySelectorAll(".filter-pill")
        .forEach((b) => b.classList.remove("active"));
      this.classList.add("active");
      currentFilter = this.dataset.filter || "all";
      applyFilters();
    });
  });

  // Sort options
  document.querySelectorAll(".sort-option").forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      sortKey = this.dataset.sort || "name";
      sortDir = this.dataset.dir || "asc";
      applySort();
    });
  });

  // View toggle
  document.querySelectorAll(".view-toggle").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      document
        .querySelectorAll(".view-toggle")
        .forEach((b) => b.classList.remove("active"));
      this.classList.add("active");
      view = this.dataset.view || "grid";
      container.classList.toggle("list-view", view === "list");
    });
  });

//   // Enhanced delete confirmation
//   document.querySelectorAll(".btn-delete").forEach((btn) => {
//     btn.addEventListener("click", function (e) {
//       e.preventDefault();
//       const form = this.closest("form");
//       const productName = this.closest(".product-card")
//         .querySelector(".card-title")
//         .textContent.trim();

//       // Modern confirmation dialog
//       if (
//         confirm(
//           `Are you sure you want to delete "${productName}"?\n\nThis action cannot be undone.`
//         )
//       ) {
//         // Add loading state
//         this.innerHTML = '<i class="bi bi-hourglass-split"></i>';
//         this.disabled = true;
//         form.submit();
//       }
//     });
//   });

  // Enhanced hover effects
  function setupHoverEffects() {
    getCards().forEach((card) => {
      const img = card.querySelector(".product-image-wrap img");
      const quickBtn = card.querySelector(".quick-preview-btn");

      card.addEventListener("mouseenter", function () {
        if (img && !card.classList.contains("d-none")) {
          img.style.transform = "scale(1.1)";
        }
        if (quickBtn && !card.classList.contains("d-none")) {
          quickBtn.style.opacity = "1";
          quickBtn.style.transform = "translate(-50%, -50%) scale(1)";
        }
      });

      card.addEventListener("mouseleave", function () {
        if (img) img.style.transform = "scale(1)";
        if (quickBtn) {
          quickBtn.style.opacity = "0";
          quickBtn.style.transform = "translate(-50%, -50%) scale(0.8)";
        }
      });
    });
  }

  // Keyboard navigation support
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      // Close any open modals
      const openModals = document.querySelectorAll(".modal.show");
      openModals.forEach((modal) => {
        const bsModal = bootstrap.Modal.getInstance(modal);
        if (bsModal) bsModal.hide();
      });
    }

    // Pagination keyboard shortcuts
    if (e.ctrlKey || e.metaKey) {
      switch (e.key) {
        case "ArrowLeft":
          e.preventDefault();
          if (currentPage > 1) goToPage(currentPage - 1);
          break;
        case "ArrowRight":
          e.preventDefault();
          const totalPages = Math.ceil(filteredCards.length / pageSize);
          if (currentPage < totalPages) goToPage(currentPage + 1);
          break;
      }
    }
  });

  // Image loading handling
  document.querySelectorAll(".product-image-wrap img").forEach((img) => {
    if (img.complete) {
      img.classList.add("loaded");
    } else {
      img.addEventListener("load", function () {
        this.classList.add("loaded");
      });
      img.addEventListener("error", function () {
        this.classList.add("loaded"); // Still fade in even if error
        console.warn("Failed to load product image:", this.src);
      });
    }
  });

  // Enable Bootstrap tooltips if present
  if (window.bootstrap) {
    const tooltipTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  }

  // Initialize everything
  initializeCards();
  applyFilters();
  applySort();
  setupHoverEffects();
})();
