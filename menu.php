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

        /* Cart Bar (Bottom Fixed) */
        .cart-bar {
            background-color: #053631;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.3);
            z-index: 20;
            transform: translateY(100%);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.320, 1.275);
        }

        .cart-bar.active {
            transform: translateY(0);
        }

        .cart-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .cart-count-badge {
            background: #ff7520;
            color: #053631;
            font-family: 'renos-rough', sans-serif;
            font-size: 1.8rem;
            width: 55px;
            height: 55px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            box-shadow: 0 4px 0 #bf360c;
        }

        .cart-total-text {
            color: #deff78;
            font-size: 1.8rem;
            font-weight: 800;
        }

        .checkout-btn {
            background: #8cd003;
            color: #053631;
            font-family: 'renos-rough', sans-serif;
            font-size: 2.2rem;
            padding: 1rem 3.5rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 5px 0 #5e8a02;
            transition: transform 0.1s, box-shadow 0.1s;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
        }

        .checkout-btn:active {
            transform: translateY(3px);
            box-shadow: 0 2px 0 #5e8a02;
        }

        /* Product Card Animation for adding to cart */
        @keyframes pulse-green {
            0% {
                box-shadow: 0 0 0 0 rgba(140, 208, 3, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(140, 208, 3, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(140, 208, 3, 0);
            }
        }

        .product-card.added {
            animation: pulse-green 0.5s ease-out;
            border-color: #8cd003;
            background-color: #f4f8e8;
        }

        /* Product Detail Modal Styles */
        #product-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(8px);
        }

        #product-modal.show {
            display: flex;
        }

        .custom-modal-content {
            background: #f4f6f8;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            border-radius: 30px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: modalSlideUp 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        @keyframes modalSlideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-body {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* Step 1 Styles */
        .step-details {
            text-align: center;
        }

        .modal-product-img {
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            margin-bottom: 2rem;
            filter: drop-shadow(0 15px 15px rgba(0, 0, 0, 0.1));
        }

        .modal-product-name {
            font-family: 'renos-rough', sans-serif;
            font-size: 3rem;
            color: #053631;
            margin-bottom: 1rem;
        }

        .modal-product-kcal {
            font-size: 1.2rem;
            background: #8cd003;
            color: #053631;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 1.5rem;
            font-weight: 800;
        }

        .modal-product-desc {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #444;
            margin-bottom: 2rem;
        }

        /* Step 2 Styles */
        .step-dips {
            display: none;
        }

        .dips-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .dip-card {
            background: white;
            padding: 1rem;
            border-radius: 15px;
            border: 3px solid transparent;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .dip-card.selected {
            border-color: #ff7520;
            background: #fff8f4;
        }

        .dip-card img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 0.5rem;
        }

        .dip-name {
            font-weight: 800;
            display: block;
            margin-bottom: 0.3rem;
        }

        .dip-price {
            color: #ff7520;
            font-weight: 900;
        }

        /* Modal Footer */
        .modal-footer {
            padding: 2rem;
            background: white;
            display: flex;
            gap: 1rem;
            box-shadow: 0 -10px 20px rgba(0, 0, 0, 0.05);
        }

        .modal-btn {
            flex: 1;
            padding: 1.5rem;
            border-radius: 50px;
            border: none;
            font-family: 'renos-rough', sans-serif;
            font-size: 1.8rem;
            cursor: pointer;
            text-transform: uppercase;
            transition: transform 0.1s;
        }

        .btn-cancel {
            background: #eee;
            color: #666;
        }

        .btn-next {
            background: #ff7520;
            color: white;
        }

        .btn-add {
            background: #8cd003;
            color: #053631;
        }

        .modal-btn:active {
            transform: translateY(3px);
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

        <!-- Sticky Cart Bar -->
        <div class="cart-bar" id="cart-bar">
            <div class="cart-info">
                <div class="cart-count-badge" id="cart-count">0</div>
                <div class="cart-total-text" id="cart-total">Totaal: €0,00</div>
            </div>
            <a href="order_pagina.php" class="checkout-btn" id="checkout-link">VERDER</a>
        </div>

        <!-- Inactivity Modal -->
        <div id="inactivity-modal">
            <div class="modal-content">
                <h2>Ben je er nog?</h2>
                <p>Raak het scherm aan of klik op 'Ja' om verder te gaan met je bestelling.</p>
                <button class="stay-btn" id="stay-btn">JA, IK BEN ER NOG</button>
            </div>
        </div>

        <!-- Product Customization Modal -->
        <div id="product-modal">
            <div class="custom-modal-content">
                <div class="modal-body">
                    <!-- Step 1: Product Deatils -->
                    <div id="modal-step-1" class="step-details">
                        <img id="modal-img" src="" alt="" class="modal-product-img">
                        <h2 id="modal-name" class="modal-product-name">Product Naam</h2>
                        <div id="modal-kcal" class="modal-product-kcal">0 kcal</div>
                        <p id="modal-desc" class="modal-product-desc">Beschrijving komt hier...</p>
                    </div>

                    <!-- Step 2: Signature Dips -->
                    <div id="modal-step-2" class="step-dips">
                        <h2 class="modal-product-name" style="font-size: 2.2rem; margin-bottom: 0.5rem;">KIES JE DIP
                        </h2>
                        <p style="text-align:center; color:#666;">Wil je er een heerlijke signature dip bij?</p>
                        <div id="dips-container" class="dips-grid">
                            <!-- Dips injected here -->
                        </div>
                    </div>

                    <!-- Step 3: Side Dishes -->
                    <div id="modal-step-3" class="step-dips">
                        <h2 class="modal-product-name" style="font-size: 2.2rem; margin-bottom: 0.5rem;">KIES JE SIDE
                            DISH</h2>
                        <p style="text-align:center; color:#666;">Maak je maaltijd compleet met een bijgerecht!</p>
                        <div id="sides-container" class="dips-grid">
                            <!-- Sides injected here -->
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="modal-btn btn-cancel" id="modal-cancel-btn">Annuleren</button>
                    <button class="modal-btn btn-next" id="modal-next-btn">Volgende</button>
                    <button class="modal-btn btn-add" id="modal-add-btn" style="display:none;">Toevoegen</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let cart = [];
            let currentSelectedProduct = null;
            let selectedDips = [];
            let selectedSides = [];
            let allMenuData = [];

            const productModal = document.getElementById('product-modal');
            const step1 = document.getElementById('modal-step-1');
            const step2 = document.getElementById('modal-step-2');
            const step3 = document.getElementById('modal-step-3');
            const nextBtn = document.getElementById('modal-next-btn');
            const addBtn = document.getElementById('modal-add-btn');
            const cancelBtn = document.getElementById('modal-cancel-btn');

            let currentStep = 1;

            function openProductModal(product) {
                currentSelectedProduct = product;
                selectedDips = [];
                selectedSides = [];
                currentStep = 1;

                showStep(1);

                // Fill data
                document.getElementById('modal-img').src = product.image_filename ? `assets/img/${product.image_filename}` : 'assets/dino_start.png';
                document.getElementById('modal-name').innerText = product.name;
                document.getElementById('modal-kcal').innerText = `${product.calories} kcal`;
                document.getElementById('modal-desc').innerText = product.description || "Geen beschrijving beschikbaar.";

                productModal.classList.add('show');
            }

            function showStep(step) {
                currentStep = step;
                step1.style.display = (step === 1) ? 'block' : 'none';
                step2.style.display = (step === 2) ? 'block' : 'none';
                step3.style.display = (step === 3) ? 'block' : 'none';

                if (step === 1) {
                    nextBtn.style.display = 'block';
                    addBtn.style.display = 'none';
                    cancelBtn.innerText = 'Annuleren';
                } else if (step === 2) {
                    nextBtn.style.display = 'block';
                    addBtn.style.display = 'none';
                    cancelBtn.innerText = 'Vorige';
                    renderChoices("Signature Dips", "dips-container", selectedDips);
                } else if (step === 3) {
                    nextBtn.style.display = 'none';
                    addBtn.style.display = 'block';
                    cancelBtn.innerText = 'Vorige';
                    renderChoices("Sides & Small Plates", "sides-container", selectedSides);
                }
                updateAddButtonPrice();
            }

            function renderChoices(categoryName, containerId, selectedArray) {
                const container = document.getElementById(containerId);
                container.innerHTML = '';

                const items = allMenuData.filter(item => item.category === categoryName);

                items.forEach(item => {
                    const card = document.createElement('div');
                    card.className = `dip-card ${selectedArray.find(s => s.product_id === item.product_id) ? 'selected' : ''}`;
                    const img = item.image_filename ? `assets/img/${item.image_filename}` : 'assets/dino_start.png';
                    const priceFormatted = parseFloat(item.price).toFixed(2).replace('.', ',');

                    card.innerHTML = `
                        <img src="${img}" alt="${item.name}">
                        <span class="dip-name">${item.name}</span>
                        <span class="dip-price">+€${priceFormatted}</span>
                    `;

                    card.addEventListener('click', () => {
                        card.classList.toggle('selected');
                        const index = selectedArray.findIndex(s => s.product_id === item.product_id);
                        if (index > -1) {
                            selectedArray.splice(index, 1);
                        } else {
                            selectedArray.push(item);
                        }
                        updateAddButtonPrice();
                    });

                    container.appendChild(card);
                });
            }

            function closeProductModal() {
                productModal.classList.remove('show');
            }

            function updateAddButtonPrice() {
                if (!currentSelectedProduct) return;
                let totalPrice = parseFloat(currentSelectedProduct.price);
                selectedDips.forEach(d => totalPrice += parseFloat(d.price));
                selectedSides.forEach(s => totalPrice += parseFloat(s.price));
                addBtn.innerText = `Toevoegen (€${totalPrice.toFixed(2).replace('.', ',')})`;
            }

            nextBtn.addEventListener('click', () => {
                showStep(currentStep + 1);
            });

            cancelBtn.addEventListener('click', () => {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
                } else {
                    closeProductModal();
                }
            });

            addBtn.addEventListener('click', () => {
                addToCart(currentSelectedProduct);
                selectedDips.forEach(d => addToCart(d));
                selectedSides.forEach(s => addToCart(s));
                closeProductModal();
            });

            function updateCartUI() {
                const cartBar = document.getElementById('cart-bar');
                const cartCount = document.getElementById('cart-count');
                const cartTotal = document.getElementById('cart-total');

                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

                if (totalItems > 0) {
                    cartBar.classList.add('active');
                } else {
                    cartBar.classList.remove('active');
                }

                cartCount.innerText = totalItems;
                cartTotal.innerText = `Totaal: €${totalPrice.toFixed(2).replace('.', ',')}`;

                // Save cart to localStorage for order_pagina.php
                localStorage.setItem('kiosk_cart', JSON.stringify(cart));
            }

            function addToCart(product) {
                const existing = cart.find(item => item.product_id === product.product_id);
                if (existing) {
                    existing.quantity += 1;
                } else {
                    cart.push({
                        ...product,
                        quantity: 1
                    });
                }
                updateCartUI();
            }

            fetch("api/get_menu.php")
                .then(res => res.json())
                .then(data => {
                    allMenuData = data;
                    const productsContainer = document.getElementById("products-container");
                    const categoriesContainer = document.getElementById("categories-container");

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

                        const catBtn = document.createElement("button");
                        catBtn.className = `category-btn ${isFirst ? 'active' : ''}`;
                        catBtn.innerText = categoryName;
                        catBtn.dataset.target = safeCategoryClass;

                        catBtn.addEventListener("click", () => {
                            document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
                            catBtn.classList.add('active');
                            document.querySelectorAll('.category-section').forEach(sec => sec.classList.remove('active'));
                            document.getElementById(`section-${safeCategoryClass}`).classList.add('active');
                            productsContainer.scrollTop = 0;
                        });

                        categoriesContainer.appendChild(catBtn);

                        const section = document.createElement("div");
                        section.className = `category-section ${isFirst ? 'active' : ''}`;
                        section.id = `section-${safeCategoryClass}`;
                        section.innerHTML = `<h2 class="category-title">${categoryName}</h2>`;

                        const grid = document.createElement("div");
                        grid.className = "product-grid";

                        items.forEach(item => {
                            const priceFormatted = parseFloat(item.price).toFixed(2).replace('.', ',');
                            let imageSrc = item.image_filename
                                ? `assets/img/${item.image_filename}`
                                : 'assets/dino_start.png';

                            const card = document.createElement("div");
                            card.className = "product-card";
                            card.innerHTML = `
                                <img src="${imageSrc}" alt="${item.name}" class="product-image">
                                <h3 class="product-name">${item.name}</h3>
                                <p class="product-desc">${item.description ?? ""}</p>
                                <div class="product-meta">
                                    <span class="product-kcal">${item.calories} kcal</span>
                                    <span class="product-price">€${priceFormatted}</span>
                                </div>
                            `;

                            card.addEventListener("click", () => {
                                // If it's already a dip, maybe don't open the modal to avoid recursion? 
                                // Actually, user might want dips for dips? Probably not.
                                // But the prompt says "wanneer je een product-card aandrukt".
                                // If the product IS a signature dip, maybe just add it?
                                // Let's check if it belongs to Signature Dips.
                                if (item.category === "Signature Dips") {
                                    addToCart(item);
                                    card.classList.add('added');
                                    setTimeout(() => card.classList.remove('added'), 500);
                                } else {
                                    openProductModal(item);
                                }
                            });

                            grid.appendChild(card);
                        });

                        section.appendChild(grid);
                        productsContainer.appendChild(section);
                        isFirst = false;
                    });

                    // --- Inactivity Timer Logic ---
                    let inactivityTimer;
                    let modalTimer;
                    const INACTIVITY_TIME = 30000;
                    const MODAL_TIME = 15000;

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
                            localStorage.removeItem('kiosk_cart');
                            window.location.href = 'index.html';
                        }, MODAL_TIME);
                    }

                    ['click', 'touchstart', 'mousemove', 'scroll'].forEach(evt =>
                        document.addEventListener(evt, resetTimer, true)
                    );

                    if (stayBtn) {
                        stayBtn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            resetTimer();
                        });
                    }

                    resetTimer();

                    // Initial UI sync
                    const savedCart = localStorage.getItem('kiosk_cart');
                    if (savedCart) {
                        cart = JSON.parse(savedCart);
                        updateCartUI();
                    }
                })
                .catch(err => console.error("Fout bij het laden van het menu:", err));
        });
    </script>
</body>

</html>