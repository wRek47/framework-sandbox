<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <link rel="stylesheet" href="/common/packages/bootstrap/5.3.3/bootstrap.min.css" />
    <link rel="stylesheet" href="/common/packages/bootstrap/5.3.3/bootstrap-icons.min.css" />
    <script type="text/javascript" src="/common/packages/three/three.min.js"></script>
    <script type="text/javascript" src="/common/packages/canvasMS/player.movement.js"></script>
</head>
<body>

<div class="container-fluid">
    <div class="row mt-3">
        <aside class="col-12 col-md-4 col-lg-3">
<section id="leftSidebar" class="card rounded-0">
    <header class="card-header">
        <span class="card-title">Left Sidebar</span>
    </header>

    <aside class="card-body">
<?php

$nav = new Navigation(
);
    $nav->links = [
        create_hyperlink("Home", "home"),
        create_hyperlink("Versions", "versions"),
        create_hyperlink("Systems", "systems"),
        create_hyperlink("Structures", "structures"),
        create_hyperlink("Relativity", "relativity")
    ];

?>
<nav class="nav flex-column">
<? foreach ($nav->links as $link): ?>
    <a class="nav-item nav-link" href="<?= $link->href; ?>"><?= $link->text; ?></a>
<? unset($link); endforeach; ?>
</nav><? unset($nav); ?>
    </aside>
</section>
        </aside>
        <aside class="col-12 col-md-8 col-lg-9">
<? if (crumb_id(1) == "home"): ?>
<? $var = $cms; include INDEX; ?>
<? elseif (crumb_id(1) == "versions"): $versions = $cms->versions; ?>
<? if (crumb_id(2) == "pages"): ?>
<? else: ?>
<section class="card rounded-0 mb-3">
    <header class="card-header"><span class="card-title">Version Manager</span></header>
    <aside class="card-body">
        <p class="mb-0">Versions teach FrameWork how to create and navigate a website and its layout using systems, structures and surfaces.</p>
    </aside>
</section>

<table class="table border">
    <thead>
        <th class="bg-secondary text-light text-center">ID</th>
        <th class="bg-secondary text-light w-50">Title</th>
        <th class="bg-secondary text-light">Created</th>
    </thead>
    <tbody>
<? foreach ($versions as $id => $version): ?>
<? if ($version->id == crumb_value(1)): ?>
<tr class="">
    <td class="bg-primary text-light text-center"><?= $version->id; ?></td>
    <? $link = create_hyperlink($version->title, "versions:" . $version->id); ?><td class="bg-primary text-light"><a class="text-light" href="<?= $link->href; ?>"><?= $link->text; ?></a></td><? unset($link); ?>
    <td class="bg-primary text-light"><?= format_date("F Y", $version->created); ?></td>
</tr>
<tr>
    <td colspan="6">
<ul class="list-group rounded-0"><? $version->files = cursor($version->folder); ?>
    <li class="list-group-item">Files: <?= $version->folder; ?></li>
</ul>

<?php

if (!isset($_GET['path'])): $_GET['path'] = ""; endif;
$_GET['path'] = $version->folder . ltrim($_GET['path'], "/");

$nav = new Navigation([], [], ["class" => "nav flex-column text-center"]);

$filesys = cursor(str_replace($version->folder, "", $_GET['path']), $version->files);

foreach ($version->files->tree as $key => $item): $item->local = str_replace($version->folder, "", $item->local);
if ($item->type == "file"): array_push($nav->links, new NavLink(hyperlink("filesys", ["path" => $item->local], true), $item->local));
else: array_push($nav->links, new NavLink(hyperlink("filesys", ["path" => $item->local], true), $item->local));
endif;
unset($key, $item); endforeach;

$currentItem = $_GET['path'] ? cursor($_GET['path'], $filesys) : $filesys;
if (!$currentItem): $currentItem = $filesys; endif;

if ($currentItem->type == "folder"): $filesys = $currentItem; endif;
if ($currentItem->type == "file"): $filesys = cursor(str_replace($currentItem->name, "", $currentItem->local)); endif;

if ($filesys != $version->files AND $filesys->name != ""):
    // adding in a loop to handle current filesystem quadrants would go here
    // to-do: instead of just adding onto links, add congruent panels of links.
    foreach ($filesys->tree as $key => $item): $item->local = str_replace($version->folder, "", $item->local);
    if ($item->type == "file"): array_push($nav->links, new NavLink(hyperlink("filesys", ["path" => $item->local], true), $item->local));
    else: array_push($nav->links, new NavLink(hyperlink("filesys", ["path" => $item->local], true), $item->local));
    endif;
    unset($key, $item); endforeach;
endif;

$content = "No file selected.";
if ($currentItem->type == "file"): $content = highlight_string($currentItem->contents, true); endif;

$card = new BootstrapCard("file_manager", "card rounded-0 mt-3", null, new BootstrapRow([
    new BootstrapColumn($nav, "col-12 col-lg-3 col-md-4"),
    new BootstrapColumn($content, "col-12 col-lg-9 col-md-8")
]), null); unset($nav);

include BOOTSTRAP;

?>

<section class="card rounded-0 mt-3 d-none">
    <header class="card-header">
        Sitemap
    </header>

    <aside class="card-body d-flex justify-content-around">
        <figure class="bg-dark me-4 mb-0">
            <figcaption class="text-light text-center py-2 border-bottom">Flowchart</figcaption>
            <div id="sceneCanvas3" class="bg-black d-flex justify-content-around align-items-center" style="height: 40vh; width: 40vh;">
                <!-- i class="bi bi-play-fill fs-1 text-white"></i -->
            </div>
        </figure>

        <figure class="bg-dark mx-4 mb-0">
            <figcaption class="bg-dark text-light text-center py-2 border-bottom">Outside</figcaption>
            <div id="sceneCanvas" class="bg-black" style="height: 40vh; width: 40vh;"></div>
        </figure>

        <figure class="bg-dark ms-4 mb-0">
            <figcaption class="text-light text-center py-2 border-bottom">Inside</figcaption>
            <div id="sceneCanvas2" class="bg-black" style="height: 40vh; width: 40vh;"></div>
        </figure>
<script>
const container = document.getElementById('sceneCanvas');
const container2 = document.getElementById('sceneCanvas2');
const container3 = document.getElementById('sceneCanvas3');

const scene = new THREE.Scene();
const scene3 = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 10000);
const camera2 = new THREE.PerspectiveCamera(75, container2.clientWidth / container2.clientHeight, 0.1, 10000);
const camera3 = new THREE.PerspectiveCamera(75, container3.clientWidth / container3.clientHeight, 0.1, 10000);

const renderer = new THREE.WebGLRenderer();
const renderer2 = new THREE.WebGLRenderer();
const renderer3 = new THREE.WebGLRenderer();

renderer.setSize(container.clientWidth, container.clientHeight);
renderer.setAnimationLoop(animate);

renderer2.setSize(container2.clientWidth, container2.clientHeight);
renderer2.setAnimationLoop(animate2);

renderer3.setSize(container3.clientWidth, container3.clientHeight);
renderer3.setAnimationLoop(animate3);

container.appendChild(renderer.domElement);
container2.appendChild(renderer2.domElement);
container3.appendChild(renderer3.domElement);

const mouse = { position: { x: 0, y: 0 } }
const objects = [];

let rollOver = {
    structure: {
        mesh: new THREE.Mesh(
            new THREE.BoxGeometry(),
            new THREE.MeshBasicMaterial({ color: Math.random() * 0xffffff, wireframe: true })
        )
    }
}

buildingSize = 100;
const gridHelper = new THREE.GridHelper(1000, 50);
scene.add(gridHelper);

const raycaster = new THREE.Raycaster();

let siteMap = {
    size: 10000,
    label: "Sitemap",
    plane: { mesh: new THREE.Mesh(
        new THREE.PlaneGeometry(1000, 1000),
        new THREE.MeshBasicMaterial({ visible: false })
    ) },

    structure: {}
};

siteMap.plane.mesh.rotation.set(-Math.PI / 2, 0, 0);
scene.add(siteMap.plane.mesh);

const lighting = {
    ambient: new THREE.AmbientLight(0x777777, 3),
    directional: new THREE.DirectionalLight(0xffffff, 3)
};

// scene.add(lighting.ambient);

lighting.directional.position.set(0, 100, 0);
scene.add(lighting.directional);

let outside = new THREE.Mesh(
    new THREE.BoxGeometry(50, 20, 50, 10, 10, 10),
    new THREE.MeshBasicMaterial({ color: Math.random() * 0xffffff, wireframe: true })
);

outside.position.set(0, 10, 0);
outside.rotation.set(0, 0, 0);

let rotateStructure = false;

scene.add(outside);

// Create tori with individual trajectories within the scene
const numTori = <?= count($cms->pages); ?> * 5;
const tori = [];

let selectedTorusIndex = null;

let torus;
let x = -20;
let z = -10;

for (let i = 0; i < numTori; i++) {

    torus = new THREE.Mesh(
        new THREE.BoxGeometry(5, 5, 5, 5, 5, 5),
        new THREE.MeshBasicMaterial({ color: Math.random() * 0xffffff, wireframe: true })
    );
    
    torus.position.set(x, -7.5, z);
    torus.rotation.set(0, 0, 0);

    tori.push({
        mesh: torus
    });

    x += 10;

    if (i > 0 && i % 4 == 0) { z += 10; x = -20; };

    outside.add(torus);

}

// console.log(tori);

camera.position.set(0, 4, 80);

container.addEventListener('keypress', handleKeyPress);
// container.addEventListener('mousemove', handleMouseMovement);
container.addEventListener('click', handleMouseClick);

// container2.addEventListener();

function animate() {

    // camera.lookAt(0, 0, 0);
    // camera.lookAt(mouse.position.x, mouse.position.y * -1, 0);
    // console.log(mouse.position);
    // camera.rotation.y += (-mouse.position.x - camera.rotation.y) * 0.01; // Smooth camera movement

    for (i = 0; i < tori.length; i++) {
    
        // tori[i].mesh.rotation.y += 0.01;
    
    }
    
    if (rotateStructure) { outside.rotation.y += 0.01; }
    // camera.position.x += 0.1;
    // camera.position.z -= 5;

    renderer.render(scene, camera);

}

camera2.position.set(0, 10, 20);

function animate2() {

    renderer2.render(scene, camera2);

}

camera3.position.set(0, 60, 0);
camera3.rotation.set(-Math.PI / 2, 0, 0);

function animate3() {

    renderer3.render(scene, camera3);

}
</script>
    </aside>
</section>

<div class="row row-cols-3 mt-3 d-none">
    <aside class="col">
<section class="card rounded-0">
    <header class="card-header">Landscape</header>
    <aside class="card-body"><? $var = $cms->version->landscape->flowchart; include INDEX; ?></aside>
</section>
    </aside>

    <aside class="col">
<section class="card rounded-0">
    <header class="card-header">Surfaces</header>
    <aside class="card-body"><? $var = $cms->version->landscape->surfaces; include INDEX; ?></aside>
</section>
    </aside>

    <aside class="col">
<section class="card rounded-0">
    <header class="card-header">Structure<? // count($version->surfaces); ?></header>
    <aside class="card-body"><? $var = $cms->version->landscape->structure; include INDEX; ?></aside>
</section>
    </aside>
</div>
<? # $var = $version; include INDEX; ?>
    </td>
</tr>
<? else: ?>
<tr>
    <td class="text-center"><?= $version->id; ?></td>
    <? $link = create_hyperlink($version->title, "versions:" . $version->id); ?><td><a href="<?= $link->href; ?>"><?= $link->text; ?></a></td>
    <td><?= format_date("F Y", $version->created); ?></td>
</tr>
<? endif; ?>
<? unset($version); endforeach; unset($versions); ?>
    </tbody>
</table>
<? endif; ?>
<? elseif (crumb_id(1) == "structures"): $structures = $cms->version->structures; ?>
<table class="table border">
    <thead>
        <th class="w-50">Structure Name</th>
        <th>Type</th>
        <th class="text-center">File Count</th>
    </thead>
    <tbody>
<? foreach ($structures as $id => $structure): ?>
<tr>
    <td><?= $structure->name; ?></td>
    <td><?= $structure->type; ?></td>
    <td class="text-center"><?= count($structure->files); ?></td>
</tr>
<? unset($id, $structure); endforeach; ?>
    </tbody>
</table>
<? endif; ?>
        </aside>
    </div>
</div>

</body>
</html>