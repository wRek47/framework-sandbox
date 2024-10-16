let coinSliders = [];

function rotateCoin(coin_id, slider_id) {

    const coin = document.getElementById(coin_id);

    const rotationSlider = document.getElementById(slider_id);
    // const rotationXSlider = document.getElementById(coin_id + 'RotationXSlider');

    coin.style.transform = `rotateY(${rotationSlider.value}deg) rotateX(0deg)`;

}