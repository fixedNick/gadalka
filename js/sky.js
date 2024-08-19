function createStar() {

    document.querySelectorAll('.bg-stars').forEach(function(section) {
        let star = document.createElement('div');
        star.classList.add('star');
        star.style.left = `${Math.random() * 100}%`;
        star.style.top = `${Math.random() * 100}%`;
        star.style.animationDuration = `${Math.random() * 3 + 2}s`;
        section.appendChild(star);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    for (let i = 0; i < 100; i++) {
        createStar();
    }
});