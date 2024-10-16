<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="/common/packages/bootstrap/5.3.3/bootstrap.min.css" />
    <script src="/common/packages/bootstrap/5.3.3/bootstrap.bundle.min.js"></script>
    
    <link type="text/css" rel="stylesheet" href="/common/packages/bootstrap/5.3.3/bootstrap-icons.min.css">

    <style type="text/css">
	.coin {
		position: relative;
		transform-style: preserve-3d;
	}
	
    .cube {
        width: 45vmin;
        position: relative;
        transform-style: preserve-3d;
    }
	
    .coin1 {
        width: 150vmin;
        height: 80vmin;
        position: relative;
        transform-style: preserve-3d;
    }
	
    .cube1inner {
        width: 140vmin;
        position: relative;
        transform-style: preserve-3d;
    }
	
    .coin2 {
        width: 40vmin;
        height: 80vmin;
        position: relative;
        transform-style: preserve-3d;
    }
	
    .cube3 {
        width: 20vmin;
        height: 20vmin;
        position: relative;
        transform-style: preserve-3d;
    }
	
    .cube4 {
        width: 10vmin;
        height: 10vmin;
        position: relative;
        transform-style: preserve-3d;
    }

    .face {
        box-shadow: 1px 3px 10px #ccc;
		height: 100%;
        width: 100%;
		background-color: transparent;
        background-color: #f8f9fa;
        background-color: white;
        border: 1px solid #ced4da;
        overflow: auto;
    }
	
	.cube2 > .front, .back, .left, .right, .top, .bottom {
		position: absolute;
		top: 0px;
		left: 0px;
		right: 0px;
		bottom: 0px;
	}

    .coin > .front { transform: translateZ(0.1vmin); }
    .coin > .back { transform: rotateY(180deg) translateZ(0.1vmin); }
    .coin > .right { transform: rotateY(-90deg) translateZ(0.1vmin); }
    .coin > .left { transform: rotateY(90deg) translateZ(0.1vmin); }
    .coin > .top { transform: rotateX(90deg) translateZ(0.1vmin); }
    .coin > .bottom { transform: rotateX(-90deg) translateZ(0.1vmin); }

    .cube > .front { transform: translateZ(22.5vmin); }
    .cube > .back { transform: rotateY(180deg) translateZ(22.5vmin); }
    .cube > .right { transform: rotateY(-90deg) translateZ(22.5vmin); }
    .cube > .left { transform: rotateY(90deg) translateZ(22.5vmin); }
    .cube > .top { transform: rotateX(90deg) translateZ(22.5vmin); }
    .cube > .bottom { transform: rotateX(-90deg) translateZ(22.5vmin); }

    .coin1 > .front { transform: translateZ(75vmin); }
    .coin1 > .back { transform: rotateY(180deg) translateZ(75vmin); }
    .coin1 > .right { transform: rotateY(-90deg) translateZ(75vmin); }
    .coin1 > .left { transform: rotateY(90deg) translateZ(75vmin); }
    .coin1 > .top { transform: rotateX(90deg) translateZ(75vmin); }
    .coin1 > .bottom { transform: rotateX(-90deg) translateZ(75vmin); }

    .cube1inner > .front { transform: translateZ(70vmin); }
    .cube1inner > .back { transform: rotateY(180deg) translateZ(70vmin); }
    .cube1inner > .right { transform: rotateY(-90deg) translateZ(70vmin); }
    .cube1inner > .left { transform: rotateY(90deg) translateZ(70vmin); }
    .cube1inner > .top { transform: rotateX(90deg) translateZ(70vmin); }
    .cube1inner > .bottom { transform: rotateX(-90deg) translateZ(70vmin); }

    .coin2 > .front { transform: translateZ(20vmin); }
    .coin2 > .back { transform: rotateY(180deg) translateZ(20vmin); }
    .coin2 > .right { transform: rotateY(-90deg) translateZ(20vmin); }
    .coin2 > .left { transform: rotateY(90deg) translateZ(20vmin); }
    .coin2 > .top { transform: rotateX(90deg) translateZ(20vmin); }
    .coin2 > .bottom { transform: rotateX(-90deg) translateZ(20vmin); }

    .cube3 > .front { transform: translateZ(10vmin); }
    .cube3 > .back { transform: rotateY(180deg) translateZ(10vmin); }
    .cube3 > .right { transform: rotateY(90deg) translateZ(10vmin); }
    .cube3 > .left { transform: rotateY(-90deg) translateZ(10vmin); }
    .cube3 > .top { transform: rotateX(90deg) translateZ(10vmin); }
    .cube3 > .bottom { transform: rotateX(-90deg) translateZ(10vmin); }

    .cube4 > .front { transform: translateZ(5vmin); }
    .cube4 > .back { transform: rotateY(180deg) translateZ(5vmin); }
    .cube4 > .right { transform: rotateY(90deg) translateZ(5vmin); }
    .cube4 > .left { transform: rotateY(-90deg) translateZ(5vmin); }
    .cube4 > .top { transform: rotateX(90deg) translateZ(5vmin); }
    .cube4 > .bottom { transform: rotateX(-90deg) translateZ(5vmin); }
</style>
<script>
let coinSliders = [];

function rotateCoin(coin_id) {
    const coin = document.getElementById(coin_id);
    const rotationSlider = document.getElementById(coin_id + 'RotationSlider');
    coin.style.transform = `rotateY(${rotationSlider.value}deg) rotateX(0deg)`;
}
</script>
</head>
<body class="bg-light">
<div class="container-fluid">
<div class="row pe-4">
    <aside class="col-12 col-md-4 col-lg-3">
<nav class="p-3">
<nav class="nav mb-3">
    <input type="range" min="-90" max="180" value="0" step="1" class="slider" id="sidebarRotationSlider" />
    <input type="range" min="-90" max="90" value="0" step="1" class="slider d-none" id="sidebarRotationXSlider" />
</nav>

        <section id="sidebar" class="coin2 mx-auto">
            <aside class="face front">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Main Menu</span></header>

<aside class="card-body">
<nav class="nav flex-column">
    <a class="nav-item nav-link" href="/?page=home">Home</a>
    <a class="nav-item nav-link" href="/?page=portfolio">My Portfolio</a>
    <a class="nav-item nav-link" href="/?page=marketplace">My Marketplace</a>
</nav>
</aside>
</section>
            </aside>
            <aside class="face back">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Untitled Surface</span></header>
<aside class="card-body"></aside>
</section>
            </aside>
            <aside class="face left d-none">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Untitled Surface</span></header>
<aside class="card-body"></aside>
</section>
            </aside>
            <aside class="face right d-none">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Untitled Surface</span></header>
<aside class="card-body"></aside>
</section>
            </aside>
        </section>
<script>
rotateCoin("sidebar");
coinSliders.push("sidebar");
</script>
</nav>
    </aside>

    <aside class="col-12 col-md-8 col-lg-9">
<main class="container-fluid pt-3">
<nav class="nav mb-3">
    <input type="range" min="0" max="180" value="0" step="1" class="slider" id="mainPortfolioRotationSlider" />
    <input type="range" min="-90" max="90" value="0" step="1" class="slider d-none" id="mainPortfolioRotationXSlider" />
</nav>

        <section id="mainPortfolio" class="coin mx-auto">
            <aside class="face front">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header">
    <span class="card-title"><a href="/?page=portfolio&surface=mainPortfolio:0">My Portfolio</a></span>
</header>

<aside class="card-body">
<main class="container-fluid">
<nav class="nav mb-3">
    <input type="range" min="-90" max="180" value="0" step="1" class="slider" id="aboutShowcaseRotationSlider" />
    <input type="range" min="-90" max="90" value="0" step="1" class="slider d-none" id="aboutShowcaseRotationXSlider" />
</nav>

        <section id="aboutShowcase" class="cube1inner mx-auto">
            <aside class="face front">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Untitled Surface</span></header>
<aside class="card-body">
</aside>
</section>
            </aside>
            <aside class="face back">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Untitled Surface</span></header>
<aside class="card-body">
<? for ($i = 0; $i <= rand(5, 25); $i++): ?>
Hello world #<?= $i; ?><br />
<? endfor; unset($i); ?>
</aside>
</section>
            </aside>
            <aside class="face left">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Untitled Surface</span></header>
<aside class="card-body"></aside>
</section>
            </aside>
            <aside class="face right">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Untitled Surface</span></header>
<aside class="card-body"></aside>
</section>
            </aside>
        </section>
<script>
rotateCoin("aboutShowcase");
coinSliders.push("aboutShowcase");
</script>
</main>
</aside>
</section>
<section class="alert alert-success rounded-0 mx-3">I can add items here.</section>
            </aside>
            <aside class="face back">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Untitled Surface</span></header>
<aside class="card-body"></aside>
</section>
            </aside>
            <aside class="face left d-none">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Untitled Surface</span></header>
<aside class="card-body"></aside>
</section>
            </aside>
            <aside class="face right d-none">
<section class="card border-0 rounded-0 mb-3">
<header class="card-header"><span class="card-title">Untitled Surface</span></header>
<aside class="card-body">
</aside>
</section>
            </aside>
        </section>
<script>
rotateCoin("mainPortfolio");
coinSliders.push("mainPortfolio");
</script>
</main>
    </aside>
</div>
</div>

<script>
document.body.addEventListener('input', function() {

    // coinSlideListener(coinSlide);
	coinSliders.forEach(function(label) { coinSlideListener(label); });

});

function coinSlideListener(coin_id) {

    const coin = document.getElementById(coin_id);

    const rotationSlider = document.getElementById(coin_id + 'RotationSlider');

	if (rotationSlider) {
	    rotationSlider.addEventListener('input', function() {
	        coin.style.transform = `rotateY(${this.value}deg) rotateX(0deg)`;
	    });
	}

}
</script>
</body>
</html>
