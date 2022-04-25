(function() {
    const preloader = document.querySelector('.preloader');
    window.addEventListener('load', () => {
        console.log('loaded');
        setInterval(() => {
            if (!preloader.style.opacity) {
                preloader.style.opacity = 1;
            }
            if (preloader.style.opacity > 0.01) {
                preloader.style.opacity -= 0.1;
            }
            else {
                clearInterval(this);
                preloader.remove();
            }
        }, 100);
    });
})();