let coinSliders = [];

function rotateCoin(coinId, sliderId) {
    let coin = document.getElementById(coinId);
    let slider = document.getElementById(sliderId);
    
    slider.addEventListener('input', function() {
        coin.style.transform = `rotateY(${this.value}deg) rotateX(0deg)`;
    });
}

class Coin {
    constructor(elementId, sliderElementId) {
        this.elementId = elementId;
        this.sliderElementId = sliderElementId;
        this.currentRotationX = 0;
        this.currentRotationY = 0;
        this.listen();
    }

    sliderScript() {
        let script = document.createElement("script");
        script.innerHTML = 'coinSliders.push({ coin: "' + this.elementId + '", slider: "' + this.sliderElementId + '" }); rotateCoin("' + this.elementId + '", "' + this.sliderElementId + '");';
        return script;
    }

    listen() {
        document.body.appendChild(this.sliderScript());
    }
}

let coin = new Coin("coin", "rotationSlider");