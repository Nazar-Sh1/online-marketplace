let currentIndex = 1;

function showSlide(index) {
    const items = document.querySelector('.carousel__items');
    const totalSlides = document.querySelectorAll('.carousel__item').length;

    // Оновлюємо індекс для безперервного циклу
    currentIndex = index;

    // Якщо ми на першому клоні (після останнього реального слайда), перенаправляємо на перший реальний слайд
    if (currentIndex === totalSlides - 1) {
        setTimeout(() => {
            items.style.transition = 'none';
            currentIndex = 1;
            items.style.transform = `translateX(-${currentIndex * 33.333}%)`;
        }, 500);
    }

    // Якщо ми на останньому клоні (перед першим реальним слайдом), перенаправляємо на останній реальний слайд
    if (currentIndex === 0) {
        setTimeout(() => {
            items.style.transition = 'none';
            currentIndex = totalSlides - 2;
            items.style.transform = `translateX(-${currentIndex * 33.333}%)`;
        }, 500);
    }

    // Рухаємо карусель
    items.style.transition = 'transform 0.5s ease';
    items.style.transform = `translateX(-${currentIndex * 33.333}%)`;
}

function nextSlide() {
    showSlide(currentIndex + 1);
}

function prevSlide() {
    showSlide(currentIndex - 1);
}

// Показуємо початкову позицію
document.addEventListener("DOMContentLoaded", () => {
    const items = document.querySelector('.carousel__items');
    items.style.transform = `translateX(-${currentIndex * 33.333}%)`;
});
