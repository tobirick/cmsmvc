var topButtonEl = document.querySelector('.to-top-button');
window.onscroll = function() {
    if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        topButtonEl.classList.add('visible');
    } else {
        topButtonEl.classList.remove('visible');
    }  
};

topButtonEl.addEventListener('click', function() {
    scrollToTop(500);
});

function scrollToTop(scrollDuration) {
    var cosParameter = window.scrollY / 2,
        scrollCount = 0,
        oldTimestamp = performance.now();
    function step (newTimestamp) {
        scrollCount += Math.PI / (scrollDuration / (newTimestamp - oldTimestamp));
        if (scrollCount >= Math.PI) window.scrollTo(0, 0);
        if (window.scrollY === 0) return;
        window.scrollTo(0, Math.round(cosParameter + cosParameter * Math.cos(scrollCount)));
        oldTimestamp = newTimestamp;
        window.requestAnimationFrame(step);
    }
    window.requestAnimationFrame(step);
}