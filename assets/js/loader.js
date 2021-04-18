let button = document.querySelector('button.send-request');
let loaderImage = document.querySelector('img.loader');

button.addEventListener('click', () => {
    button.style.display = "none";
    loaderImage.style.display = "block";
})

