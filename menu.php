<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk Menu</title>
    <!-- Link to the main style for kiosk wrapper -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        /* Menu Specific Styles to layout properly in the 700x1920 Kiosk bounds */
        #kiosk-wrapper {
            display: flex;
            flex-direction: column;
            background-color: #f4f6f8;
            /* Overriding the dark green from start screen for better readability */
        }

        /* Header */
        header {
            background-color: #053631;
            color: #deff78;
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        header h1 {
            font-family: 'renos-rough', sans-serif;
            font-size: 3.5rem;
            color: #ff7520;
            text-shadow: 2px 2px 0px #03221f;
            margin: 0;
            line-height: 1;
        }

        .back-btn {
            background: #ff7520;
            color: #053631;
            font-family: 'renos-rough', sans-serif;
            font-size: 1.8rem;
            padding: 0.8rem 1.8rem;
            border-radius: 30px;
            text-decoration: none;
            box-shadow: 0 5px 0 #bf360c;
            display: inline-block;
        }

        .back-btn:active {
            transform: translateY(3px);
            box-shadow: 0 2px 0 #bf360c;
        }

        /* Container using flex row. 
           We place the sidebar on the RIGHT side based on instructions. */
        .layout-container {
            display: flex;
            flex-direction: row;
            flex: 1;
            overflow: hidden;
        }

        /* Product Area (Left side) */
        .product-area {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        /* Hide scrollbar for a cleaner kiosk look */
        .product-area::-webkit-scrollbar {
            width: 8px;
        }

        .product-area::-webkit-scrollbar-track {
            background: transparent;
        }

        .product-area::-webkit-scrollbar-thumb {
            background: #d1d1d1;
            border-radius: 4px;
        }

        /* Category Area (Right side) */
        .category-sidebar {
            width: 220px;
            background-color: #ffffff;
            border-left: 2px solid #e0e0e0;
            box-shadow: -4px 0 15px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            z-index: 5;
        }

        .category-sidebar::-webkit-scrollbar {
            width: 0px;
        }

        /* invisible scrollbar */

        .category-btn {
            padding: 2rem 1rem;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            border: none;
            background: transparent;
            border-bottom: 2px solid #f0f0f0;
            color: #053631;
            cursor: pointer;
            transition: all 0.2s;
            font-family: "Noto Sans", sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .category-btn.active,
        .category-btn:active {
            background-color: #f4f8e8;
            color: #053631;
            border-right: 6px solid #8cd003;
            /* visual indicator */
            box-shadow: inset 4px 0 10px rgba(0, 0, 0, 0.02);
            font-weight: 800;
        }

        /* Category Sections inside Product Area */
        .category-section {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .category-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .category-title {
            font-family: 'renos-rough', sans-serif;
            font-size: 3.5rem;
            color: #053631;
            margin-bottom: 2rem;
            text-transform: uppercase;
            border-bottom: 4px solid #ff7520;
            padding-bottom: 0.5rem;
            display: inline-block;
        }

        /* Product Cards Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            padding-bottom: 4rem;
            /* padding at the bottom for scrolling comfort */
        }

        .product-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            border: 3px solid transparent;
            transition: transform 0.1s, border-color 0.1s;
            cursor: pointer;
        }

        .product-card:active {
            transform: scale(0.97);
            border-color: #8cd003;
        }

        .product-image {
            width: 100%;
            height: 160px;
            object-fit: contain;
            margin-bottom: 1rem;
            filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.1));
        }

        .product-name {
            font-size: smaller;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
            min-height: 55px;
            /* space for 2 lines */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.2;
        }

        .product-desc {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
            min-height: 40px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-meta {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .product-price {
            font-size: 1.6rem;
            font-weight: 900;
            color: #ff7520;
        }

        .product-kcal {
            font-size: 0.9rem;
            font-weight: bold;
            color: #8cd003;
            background: #f4f8e8;
            padding: 0.3rem 0.6rem;
            border-radius: 8px;
        }

        /* Inactivity Modal */
        #inactivity-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        #inactivity-modal.show {
            opacity: 1;
            pointer-events: all;
        }

        .modal-content {
            background: #ffffff;
            padding: 3rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            max-width: 80%;
        }

        .modal-content h2 {
            font-family: 'renos-rough', sans-serif;
            font-size: 3rem;
            color: #ff7520;
            margin-bottom: 1rem;
        }

        .modal-content p {
            font-size: 1.5rem;
            color: #053631;
            margin-bottom: 2rem;
            font-weight: bold;
        }

        .stay-btn {
            background: #8cd003;
            color: #053631;
            font-family: 'renos-rough', sans-serif;
            font-size: 2rem;
            padding: 1rem 3rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 5px 0 #5e8a02;
            transition: transform 0.1s, box-shadow 0.1s;
            text-transform: uppercase;
        }

        .stay-btn:active {
            transform: translateY(3px);
            box-shadow: 0 2px 0 #5e8a02;
        }
    </style>
</head>

<body>

    <main id="kiosk-wrapper">
        <header>
            <h1>BesteL HIER</h1>
        </header>

        <div class="layout-container">
            <!-- Left Side: Products Grid -->
            <div class="product-area" id="products-container">
                <!-- Products will be dynamically injected here -->
            </div>

            <!-- Right Side: Categories Navigation -->
            <div class="category-sidebar" id="categories-container">
                <!-- Category buttons will be dynamically injected here -->
            </div>
        </div>

        <!-- Inactivity Modal -->
        <div id="inactivity-modal">
            <div class="modal-content">
                <h2>Ben je er nog?</h2>
                <p>Raak het scherm aan of klik op 'Ja' om verder te gaan met je bestelling.</p>
                <button class="stay-btn" id="stay-btn">JA, IK BEN ER NOG</button>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            fetch("api/get_menu.php")
                .then(res => res.json())
                .then(data => {
                    const productsContainer = document.getElementById("products-container");
                    const categoriesContainer = document.getElementById("categories-container");

                    // Group products by category
                    const categoriesMap = new Map();

                    data.forEach(item => {
                        if (!categoriesMap.has(item.category)) {
                            categoriesMap.set(item.category, []);
                        }
                        categoriesMap.get(item.category).push(item);
                    });

                    let isFirst = true;

                    categoriesMap.forEach((items, categoryName) => {
                        const safeCategoryClass = categoryName.replace(/\s+/g, '-').toLowerCase();

                        // 1. Create Category Navigation Button (Right Sidebar)
                        const catBtn = document.createElement("button");
                        catBtn.className = `category-btn ${isFirst ? 'active' : ''}`;
                        catBtn.innerText = categoryName;
                        catBtn.dataset.target = safeCategoryClass;

                        catBtn.addEventListener("click", () => {
                            // Highlight the active category button
                            document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
                            catBtn.classList.add('active');

                            // Show the corresponding category products left side
                            document.querySelectorAll('.category-section').forEach(sec => sec.classList.remove('active'));
                            document.getElementById(`section-${safeCategoryClass}`).classList.add('active');

                            // Scroll top for convenience
                            productsContainer.scrollTop = 0;
                        });

                        categoriesContainer.appendChild(catBtn);

                        // 2. Create Category Products Section (Left Content Area)
                        const section = document.createElement("div");
                        section.className = `category-section ${isFirst ? 'active' : ''}`;
                        section.id = `section-${safeCategoryClass}`;

                        // Section Title
                        section.innerHTML = `<h2 class="category-title">${categoryName}</h2>`;

                        // Grid for Products
                        const grid = document.createElement("div");
                        grid.className = "product-grid";

                        items.forEach(item => {
                            // Formatting the price neatly to strings with commas (nl format)
                            const priceFormatted = parseFloat(item.price).toFixed(2).replace('.', ',');

                            // Image fetching logic: load the image directly with fallback
                            let imageSrc = item.image_id ? `assets/${item.image_id}` : 'assets/dino_start.png';

                            grid.innerHTML += `
                                <div class="product-card">
                                    <img src="${imageSrc}" alt="${item.name}" class="product-image" onerror="this.src='assets/dino_start.png'">
                                    <h3 class="product-name">${item.name}</h3>
                                    <p class="product-desc">${item.description ?? ""}</p>
                                    <div class="product-meta">
                                        <span class="product-kcal">${item.calories} kcal</span>
                                        <span class="product-price">€${priceFormatted}</span>
                                    </div>
                                </div>
                            `;
                        });

                        section.appendChild(grid);
                        productsContainer.appendChild(section);

                        isFirst = false;
                    });

                    // --- Inactivity Timer Logic ---
                    let inactivityTimer;
                    let modalTimer;
                    const INACTIVITY_TIME = 15000; // 15 seconds
                    const MODAL_TIME = 10000; // 10 seconds to respond

                    const modal = document.getElementById('inactivity-modal');
                    const stayBtn = document.getElementById('stay-btn');

                    function resetTimer() {
                        clearTimeout(inactivityTimer);
                        clearTimeout(modalTimer);
                        if (modal) modal.classList.remove('show');
                        inactivityTimer = setTimeout(showModal, INACTIVITY_TIME);
                    }

                    function showModal() {
                        if (modal) modal.classList.add('show');
                        modalTimer = setTimeout(() => {
                            window.location.href = 'index.html';
                        }, MODAL_TIME);
                    }

                    // Listen for interactions on the whole document
                    ['click', 'touchstart', 'mousemove', 'scroll'].forEach(evt =>
                        document.addEventListener(evt, resetTimer, true)
                    );

                    if (stayBtn) {
                        stayBtn.addEventListener('click', (e) => {
                            e.stopPropagation(); // prevent document click from firing again unnecessarily
                            resetTimer();
                        });
                    }

                    // Start timer immediately
                    resetTimer();

                })
                .catch(err => console.error("Fout bij het laden van het menu:", err));
        });
    </script>
</body>

</html>