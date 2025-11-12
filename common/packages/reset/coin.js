/* let coins = [new Coin("flowchart", "flowchartSlider")];
coinListener(coins); */

let coins = [];
    // coins.push(new Coin("flowchart", "flowchartSlider"));

function coinListener(coins) {

    document.body.addEventListener("input", function() {
        coins.forEach(coin => { coin.listen(); coin.sliderListener(); }); });

}

class Coin {

    constructor(elementId, sliderElementId) {
    
        this.elementId = elementId;
        this.sliderElementId = sliderElementId;

        this.listen();

        this.currentRotationX = 0;
        this.currentRotationY = 0;
    
    }
    
    sliderScript() {
    
        let script = element("script");
            script.innerHTML = 'coinSliders.push({ coin: "' + this.elementId + '", slider: "' + this.sliderElementId + '" }); rotateCoin("' + this.elementId + '", "' + this.sliderElementId + '");';

        return script;
    
    }

    listen() { document.body.appendChild(this.sliderScript()); }

    sliderListener() {
    
        const coin = document.getElementById(this.elementId);
        let slider = document.getElementById(this.sliderElementId);

        if (slider) {
        
            slider.addEventListener('input', function() {
            
                coin.style.transform = `rotateY(${this.value}deg) rotateX(0deg)`;
            
            });
        
        }
    
    }

}