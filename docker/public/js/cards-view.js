// on load func for cards view
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.t-card');

    // get size of window
    let windowWidth = window.innerWidth;
    const totalCards = cards.length;

    const v_spaceBetweenCards = 35;

    let availableWidth = windowWidth < 1024 ? windowWidth * 0.9 : windowWidth * 0.7;
    let additionalSpace = (windowWidth - availableWidth) / 2;
    const cardWidth = 342;
    availableWidth -= cardWidth;
    
    const h_spaceBetweenCards = availableWidth / (totalCards - 1);
    for(let i = 0; i < totalCards; i++) {
        if (windowWidth >= 611) {
            cards[i].style.left = (additionalSpace + h_spaceBetweenCards * i) + 'px';
        }
        else {
            cards[i].style.top = v_spaceBetweenCards * i + 'px';
        }
    }
})