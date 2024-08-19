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

            this.style.setProperty('transition', '.3s');
            this.style.setProperty('z-index', '999');
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

            this.querySelector('img').style.setProperty('transition', '.3s');
            this.style.setProperty('transition', 'bottom 1.5s');
            this.style.setProperty('bottom', '25%');

            setTimeout(() => {
                this.style.setProperty('transition', '2s');
                this.style.setProperty('left', 'calc(50% - '+ 171*percentage +'px)');

                setTimeout(() => {
                    this.querySelector('img').style.setProperty('transition', '1.5s');
                    this.querySelector('img').style.setProperty('transform', 'rotateY(180deg)');
                }, 2000);
            }, 1500);
            

        });
    });
});