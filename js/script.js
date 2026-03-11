document.addEventListener('DOMContentLoaded', () => {
    function enterFullscreen() {
        const elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen().catch(() => {
                // Browsers block fullscreen without user gesture.
                // This will fail on page load but succeed on the first click.
            });
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    }

    // Function to trigger fullscreen only ONCE on the first interaction
    const triggerOnce = () => {
        enterFullscreen();
        // Remove listeners so it doesn't force fullscreen again after exiting
        document.removeEventListener('click', triggerOnce);
        document.removeEventListener('touchstart', triggerOnce);
    };

    // Attempt on load (will likely be blocked, but good to have)
    enterFullscreen();

    // Listen for the first click/touch to trigger fullscreen
    document.addEventListener('click', triggerOnce);
    document.addEventListener('touchstart', triggerOnce);
});
