<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jouw Bestelling</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        #kiosk-wrapper {
            display: flex;
            flex-direction: column;
            background-color: #f4f6f8;
        }

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
            font-size: 3rem;
            color: #ff7520;
            text-shadow: 2px 2px 0px #03221f;
            margin: 0;
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
        }

        .order-content {
            flex: 1;
            padding: 2.5rem;
            overflow-y: auto;
        }

        .order-title {
            font-family: 'renos-rough', sans-serif;
            font-size: 3.5rem;
            color: #053631;
            margin-bottom: 2rem;
            text-align: center;
            text-transform: uppercase;
        }

        .cart-items-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .cart-item {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid #eee;
        }

        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-size: 1.6rem;
            font-weight: 800;
            color: #053631;
            margin-bottom: 0.3rem;
        }

        .item-price {
            font-size: 1.3rem;
            color: #ff7520;
            font-weight: bold;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            background: #f0f0f0;
            padding: 0.5rem 1rem;
            border-radius: 30px;
        }

        .qty-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: none;
            background: #053631;
            color: #deff78;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .qty-num {
            font-size: 1.6rem;
            font-weight: 800;
            min-width: 30px;
            text-align: center;
        }

        .footer-payment {
            padding: 3rem;
            background: white;
            border-radius: 40px 40px 0 0;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .total-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 0 1rem;
        }

        .total-label {
            font-size: 1.8rem;
            font-weight: 700;
            color: #666;
        }

        .total-amount {
            font-size: 3rem;
            font-weight: 900;
            color: #053631;
        }

        .pay-btn {
            width: 100%;
            background: #8cd003;
            color: #053631;
            font-family: 'renos-rough', sans-serif;
            font-size: 3rem;
            padding: 1.5rem;
            border: none;
            border-radius: 60px;
            cursor: pointer;
            box-shadow: 0 8px 0 #5e8a02;
            transition: transform 0.1s;
            text-transform: uppercase;
            text-decoration: none;
            display: block;
        }

        .pay-btn:active {
            transform: translateY(4px);
            box-shadow: 0 4px 0 #5e8a02;
        }

        .empty-cart-msg {
            text-align: center;
            margin-top: 5rem;
        }

        .empty-cart-msg p {
            font-size: 1.8rem;
            color: #666;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    <main id="kiosk-wrapper">
        <header>
            <a href="menu.php" class="back-btn">TERUG</a>
            <h1>JOUW MANDJE</h1>
            <div style="width: 80px;"></div>
        </header>

        <section class="order-content">
            <h2 class="order-title">Overzicht</h2>
            <div id="cart-items" class="cart-items-list">
                <!-- Items will be here -->
            </div>

            <div id="empty-msg" class="empty-cart-msg" style="display: none;">
                <p>Je mandje is nog leeg.</p>
                <a href="menu.php" class="secondary-button">GA TERUG NAAR MENU</a>
            </div>
        </section>

        <section class="footer-payment" id="payment-section">
            <div class="total-container">
                <span class="total-label">TOTAAL</span>
                <span class="total-amount" id="grand-total">€0,00</span>
            </div>
            <button class="pay-btn" id="pay-button">AFREKENEN</button>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let cart = JSON.parse(localStorage.getItem('kiosk_cart') || '[]');

            function renderCart() {
                const container = document.getElementById('cart-items');
                const emptyMsg = document.getElementById('empty-msg');
                const paymentSection = document.getElementById('payment-section');
                const grandTotal = document.getElementById('grand-total');

                container.innerHTML = '';

                if (cart.length === 0) {
                    emptyMsg.style.display = 'block';
                    paymentSection.style.display = 'none';
                    return;
                }

                emptyMsg.style.display = 'none';
                paymentSection.style.display = 'block';

                let total = 0;

                cart.forEach((item, index) => {
                    total += item.price * item.quantity;
                    const priceFormatted = (item.price * item.quantity).toFixed(2).replace('.', ',');

                    let imageSrc = item.image_filename
                        ? `assets/img/${item.image_filename}`
                        : 'assets/dino_start.png';

                    const itemEl = document.createElement('div');
                    itemEl.className = 'cart-item';
                    itemEl.innerHTML = `
                        <img src="${imageSrc}" alt="${item.name}">
                        <div class="item-details">
                            <h3 class="item-name">${item.name}</h3>
                            <p class="item-price">€${priceFormatted}</p>
                        </div>
                        <div class="quantity-controls">
                            <button class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
                            <span class="qty-num">${item.quantity}</span>
                            <button class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
                        </div>
                    `;
                    container.appendChild(itemEl);
                });

                grandTotal.innerText = `€${total.toFixed(2).replace('.', ',')}`;
            }

            function syncLocalStorage() {
                localStorage.setItem('kiosk_cart', JSON.stringify(cart));
            }

            window.updateQty = (index, change) => {
                cart[index].quantity += change;
                if (cart[index].quantity <= 0) {
                    cart.splice(index, 1);
                }
                syncLocalStorage();
                renderCart();
            };

            document.getElementById('pay-button').addEventListener('click', () => {
                // In a real kiosk, this would trigger a payment terminal.
                // Here we just navigate to the end page.
                localStorage.removeItem('kiosk_cart'); // Clear cart after "payment"
                window.location.href = 'eindpagina.php';
            });

            renderCart();
        });
    </script>
</body>

</html>