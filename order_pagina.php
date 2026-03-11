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

        #printer-status {
            margin-top: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #666;
            padding: 10px;
            border-radius: 10px;
            display: none;
        }

        #printer-status.success {
            color: #28a745;
            display: block;
        }

        #printer-status.error {
            color: #dc3545;
            display: block;
        }

        #printer-status.loading {
            color: #007bff;
            display: block;
        }

        .printer-setup-btn {
            background: none;
            border: 2px dashed #ccc;
            color: #999;
            padding: 10px;
            border-radius: 10px;
            margin-top: 10px;
            cursor: pointer;
            font-size: 1rem;
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
            <div id="printer-status"></div>
            <button class="printer-setup-btn" id="setup-printer">Printer Instellen (USB)</button>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let cart = JSON.parse(localStorage.getItem('kiosk_cart') || '[]');
            let selectedDevice = null;

            const PRINTER_VENDORS = [
                0x0483, // STM Microelectronics (Xprinter)
                0x04b8, // Seiko Epson
                0x0456, // Microtek
                0x067b, // Prolific Technology
            ];

            function updatePrinterStatus(msg, type) {
                const statusEl = document.getElementById('printer-status');
                statusEl.textContent = msg;
                statusEl.className = 'status ' + (type || '');
                if (type) statusEl.style.display = 'block';
            }

            async function autoDetectPrinter() {
                if (!navigator.usb) return;
                try {
                    const devices = await navigator.usb.getDevices();
                    const printer = devices.find(d => PRINTER_VENDORS.includes(d.vendorId));
                    if (printer) {
                        selectedDevice = printer;
                        console.log("Printer gevonden:", printer.productName);
                    }
                } catch (e) { console.error(e); }
            }

            async function selectUSBDevice() {
                try {
                    const filters = PRINTER_VENDORS.map(v => ({ vendorId: v }));
                    selectedDevice = await navigator.usb.requestDevice({ filters });
                    updatePrinterStatus("✓ Printer verbonden: " + (selectedDevice.productName || "Onbekend"), "success");
                } catch (e) {
                    updatePrinterStatus("Printer selectie geannuleerd", "error");
                }
            }

            function buildReceipt(pickupNumber) {
                const INIT = "\x1B\x40";
                const CENTER = "\x1B\x61\x01";
                const LEFT = "\x1B\x61\x00";
                const BOLD_ON = "\x1B\x45\x01";
                const BOLD_OFF = "\x1B\x45\x00";
                const CUT = "\x1D\x56\x00";
                const DOUBLE_SIZE = "\x1D\x21\x11"; // Double height and width
                const NORMAL_SIZE = "\x1D\x21\x00";

                let total = 0;
                let itemsText = "";
                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    const name = item.name.substring(0, 22);
                    const price = itemTotal.toFixed(2).replace('.', ',');
                    itemsText += `${item.quantity}x ${name.padEnd(22, " ")} EUR ${price.padStart(6, " ")}\n`;
                });

                const now = new Date();
                const dateStr = now.toLocaleDateString() + " " + now.toLocaleTimeString();

                return INIT +
                    CENTER + BOLD_ON + "KIOSK BESTELLING\n" + BOLD_OFF +
                    "--------------------------------\n" +
                    CENTER + "UW BESTELNUMMER:\n\n" +
                    DOUBLE_SIZE + pickupNumber + NORMAL_SIZE + "\n\n" +
                    "--------------------------------\n" +
                    LEFT + itemsText +
                    "--------------------------------\n" +
                    BOLD_ON + "TOTAAL:           EUR " + total.toFixed(2).replace('.', ',').padStart(8, " ") + BOLD_OFF + "\n\n" +
                    CENTER + dateStr + "\n" +
                    "Bedankt voor uw bezoek!\n" +
                    "\n\n\n\n\n" +
                    CUT;
            }

            async function printReceipt(pickupNumber) {
                try {
                    // Precies dezelfde flow als je werkende test-code:
                    let device = selectedDevice;

                    if (!device) {
                        updatePrinterStatus("Selecteer je printer...", "loading");
                        device = await navigator.usb.requestDevice({
                            filters: PRINTER_VENDORS.map(v => ({ vendorId: v }))
                        });
                        selectedDevice = device;
                    }

                    updatePrinterStatus("Verbinden...", "loading");
                    if (!device.opened) await device.open();
                    await device.selectConfiguration(1);
                    try { await device.claimInterface(0); } catch (e) { }

                    const encoder = new TextEncoder();
                    const receiptData = buildReceipt(pickupNumber);

                    updatePrinterStatus("Bon printen...", "loading");

                    // Gebruik endpoint '1' zoals in je werkende test-code
                    await device.transferOut(1, encoder.encode(receiptData));

                    updatePrinterStatus("✓ Bon geprint!", "success");

                    setTimeout(async () => {
                        try {
                            await device.releaseInterface(0);
                            await device.close();
                        } catch (e) { }
                    }, 1000);
                } catch (err) {
                    selectedDevice = null; // Reset bij fout
                    throw err;
                }
            }

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

            document.getElementById('setup-printer').addEventListener('click', selectUSBDevice);

            document.getElementById('pay-button').addEventListener('click', async () => {
                if (cart.length === 0) return;

                const btn = document.getElementById('pay-button');
                btn.disabled = true;
                btn.innerText = "VERWERKEN...";

                try {
                    // 1. Create order in database
                    updatePrinterStatus("Bestelling opslaan...", "loading");
                    const response = await fetch('api/create_order.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ cart: cart })
                    });

                    const orderResult = await response.json();
                    if (!orderResult.success) {
                        throw new Error(orderResult.message || "Kon bestelling niet opslaan");
                    }

                    const pickupNumber = orderResult.pickup_number;

                    // 2. Try to print
                    try {
                        await printReceipt(pickupNumber);
                    } catch (printError) {
                        console.error("Print error:", printError);
                        if (!confirm("Kon bon niet printen. Toch doorgaan? (Je bestelnummer is " + pickupNumber + ")")) {
                            btn.disabled = false;
                            btn.innerText = "AFREKENEN";
                            return;
                        }
                    }

                    // 3. Success!
                    localStorage.removeItem('kiosk_cart');
                    window.location.href = 'eindpagina.php?pickup_number=' + pickupNumber;

                } catch (error) {
                    updatePrinterStatus("Fout: " + error.message, "error");
                    btn.disabled = false;
                    btn.innerText = "AFREKENEN (PROBEER OPNIEUW)";
                    alert("Er is iets misgegaan: " + error.message);
                }
            });

            autoDetectPrinter();
            renderCart();
        });
    </script>
</body>

</html>