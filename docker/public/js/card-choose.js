document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.t-card').forEach(card => {
        card.addEventListener('click', function () {
            card.style.transition = '1s';
            const cardWidth = 342;
            const cardHeight = 564;
            const windowWidth = window.innerWidth;
            card.style.setProperty('z-index', 18);

            const wHeight = document.querySelector('.taro-section').computedStyleMap().get('height').value;
            if (wHeight < cardHeight) {
                card.style.setProperty('height', wHeight * .9 + 'px');
            }

            const topPosition = '-' + (wHeight / 2) + 'px';    
            card.style.setProperty('top', topPosition);
            
            if (windowWidth >= 611) {
                const leftPosition = (windowWidth / 2 - cardWidth / 2) + 'px';
                card.style.setProperty('left', leftPosition);
            }
        });
    });
});