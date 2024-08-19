document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.burger').addEventListener('click', () => {
        const burger = document.querySelector('.burger');
        const header = document.querySelector('.header');

        if(burger.classList.contains('open')) burger.classList.remove('open');
        else burger.classList.add('open');

        if (header.classList.contains('open')) header.classList.remove('open');
        else header.classList.add('open');

        let body = document.querySelector('body');
        if (document.querySelector('.header').classList.contains('open')) {
            document.querySelector('.mobile-links').style.display = 'flex';
            body.style.height = '100vh';
            body.style.overflow = 'hidden';
        }
        else {
            document.querySelector('.mobile-links').style.display = 'none';
            body.style.height = 'auto';
            body.style.overflow = 'auto';
        }
    });
})