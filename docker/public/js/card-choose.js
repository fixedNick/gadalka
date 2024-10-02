let marginSize = 0;

window.onresize = () => {
    marginSize = window.innerHeight / 9;
};

document.addEventListener('DOMContentLoaded', function () {
    marginSize = window.innerHeight / 9;
    document.querySelectorAll('.taro-card').forEach(card => {
        card.querySelector('img').addEventListener('mouseover', function() {
            card.style.marginTop = '-' + marginSize + 'px';
        });
        card.querySelector('img').addEventListener('mouseout', function() {
            card.style.marginTop = '0px';
        })
        card.addEventListener('click', function () {

            card.style.setProperty('margin-top', card.style.marginTop);
            card.style.setProperty('transition', '.3s');
            card.style.setProperty('z-index', '999');
            let percentage = 1;
            if (window.innerWidth < 420) {
                this.style.setProperty('width', '80%');
                this.querySelector('img').style.setProperty('width', '90%');
                this.querySelector('img').style.setProperty('transition', '.3s');
                percentage *= .8 *.9;
            }
            else if (window.innerWidth >= 420) {
                this.style.setProperty('width', '90%');
            }
            document.querySelectorAll('.taro-card').forEach(card => {
                card.classList.add('card-clicked');
            });

            card.querySelector('img').style.setProperty('transition', '.3s');

            let mtVal = ((window.innerHeight / 2)  - 564 / 2);
            let totalMs = 1000;
            let totalPx = mtVal + Math.abs(card.computedStyleMap().get('margin-top').value);

            let parts = totalMs / 50;
            let pxStep = totalPx / parts;

            let currentVal = card.computedStyleMap().get('margin-top').value;

            let counter = 0;
            setInterval(() => {
                if(counter > parts) return;
                counter += 1;
                if (counter >= parts) {
                    setTimeout(() => {
                        card.style.setProperty('transition', '2s');
                        card.style.setProperty('left', 'calc(50% - '+ 171*percentage +'px)');
        
                        setTimeout(() => {
                            card.querySelector('img').style.setProperty('transition', '1.5s');
                            card.querySelector('img').style.setProperty('transform', 'rotateY(180deg)');
                        }, 2000);
                    }, 150);
                    return;
                }
                else {
                    currentVal -= pxStep;
                    card.style.setProperty('margin-top', currentVal + 'px');
                }
            }, 50);
        });
    });
});