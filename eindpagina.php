<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk Bestel App - Einde</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>

    <main id="kiosk-wrapper">
        <!-- Eind Scherm -->
        <section id="end-screen" class="screen active">
            <div class="confetti-container" id="confetti-container"></div>

            <div class="content-wrapper end-content">
                <div class="success-checkmark scale-in">
                    <svg viewBox="0 0 52 52" class="checkmark">
                        <circle cx="26" cy="26" r="25" fill="none" class="checkmark__circle" />
                        <path fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" class="checkmark__check" />
                    </svg>
                </div>

                <h1 class="thank-you-text slide-up">DANK JE WEL!</h1>
                <p class="order-complete-text slide-up-delay">JE BESTELLING IS COMPLEET</p>
                <p class="preparing-text slide-up-delay-2">We maken je bestelling klaar.</p>

                <div class="mascot-container-small">
                    <img src="assets/dino_end.png" alt="Eating Dino" class="dino-eating sway">
                </div>

                <!-- Terug naar start -->
                <a href="index.html" id="home-btn" class="secondary-button slide-up-delay-3"
                    style="text-decoration: none; display: inline-block;">TERUG NAAR START</a>
            </div>
        </section>
    </main>

    <script src="js/script.js"></script>
</body>

</html>