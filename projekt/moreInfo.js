document.addEventListener("DOMContentLoaded", function() {
            // 1. Получаем параметры из URL
            const urlParams = new URLSearchParams(window.location.search);
            const postText = urlParams.get('text');
            const postImg = urlParams.get('img');

            // 2. Находим элементы на странице
            const textElement = document.querySelector(".vyvodteksta");
            const imgContainer = document.querySelector(".imgtop");

            // 3. Вставляем текст
            if (postText) {
                textElement.textContent = postText;
            }

            // 4. Устанавливаем картинку как background-image
            if (postImg) {
                imgContainer.style.backgroundImage = `url('${postImg}')`;
                // Добавляем важные свойства стиля через JS, чтобы не менять CSS файл
                imgContainer.style.backgroundSize = "cover";
                imgContainer.style.backgroundPosition = "center";
            }
        });

const logoname = document.querySelector(".LogoName");

logoname.addEventListener('click', function(){
    window.location.href = "index.php";
})
