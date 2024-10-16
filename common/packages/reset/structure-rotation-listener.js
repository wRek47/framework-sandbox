document.body.addEventListener('input', function() {

    // coinSlideListener(coinSlide);
	coinSliders.forEach(function(label) { coinSlideListener(label.coin, label.slider); });

});

function coinSlideListener(coin_id, slider_id) {

    const coin = document.getElementById(coin_id);
    const rotationSlider = document.getElementById(slider_id);

	if (rotationSlider) {
	    rotationSlider.addEventListener('input', function() {
	        coin.style.transform = `rotateY(${this.value}deg) rotateX(0deg)`;
	    });
	}

}