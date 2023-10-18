<head>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const filterButton = document.getElementById("filter-button");
    const filterDropdown = document.getElementById("filter-dropdown");

    filterButton.addEventListener("click", function () {
      filterDropdown.classList.toggle("hidden");
    });

    // Handle checkbox changes and filtering
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
      checkbox.addEventListener("change", function () {
        filterProducts();
      });
    });

    function filterProducts() {
      const products = document.querySelectorAll(".grid a");
      const selectedPriceRanges = [];

      checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
          selectedPriceRanges.push(checkbox.id.replace("filter-price-", ""));
        }
      });

      products.forEach(function (product) {
        const priceElement = product.querySelector(".text-lg");
        const price = parseFloat(priceElement.textContent.replace("€", ""));

        if (selectedPriceRanges.length === 0 || selectedPriceRanges.includes(getPriceRange(price))) {
          product.style.display = "block";
        } else {
          product.style.display = "none";
        }
      });
    }

    function getPriceRange(price) {
      if (price <= 20) {
        return "1";
      } else if (price <= 50) {
        return "2";
      } else {
        return "3";
      }
    }
  });
</script>
</head>
<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <div class="mt-4 mb-8">
                <div class="relative inline-block text-left">
                    <button id="filter-button" type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out">
                        Filter op prijs
                    </button>
                    <div id="filter-dropdown" class="hidden absolute z-20 mt-2 bg-white border border-gray-300 rounded-lg shadow-lg w-60">
                        <div class="p-4 space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" id="filter-price-1" class="form-checkbox">
                                <span class="ml-2">Prijs 1 - €0 to €20</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" id="filter-price-2" class="form-checkbox">
                                <span class="ml-2">Prijs 2 - €20 to €50</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" id="filter-price-3" class="form-checkbox">
                                <span class="ml-2">Prijs 3 - €50+</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
</div>