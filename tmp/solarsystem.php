<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solar System Simulation</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }

        canvas {
            display: block;
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/three@0.132.2/build/three.min.js"></script>
    <script>
        // Set up the scene, camera, and renderer
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        // Create the sun
        const sunGeometry = new THREE.SphereGeometry(1, 32, 32);
        const sunMaterial = new THREE.MeshBasicMaterial({ color: 0xffff00, wireframe: true });
        const sun = new THREE.Mesh(sunGeometry, sunMaterial);
        scene.add(sun);

        // Define planet properties with realistic distances and speeds
        const planets = [
            { name: "Mercury", distance: 4, speed: 0.02, color: 0xffa500 },
            { name: "Venus", distance: 6, speed: 0.015, color: 0xffc0cb },
            { name: "Earth", distance: 8, speed: 0.01, color: 0x4682b4 },
            { name: "Mars", distance: 10, speed: 0.008, color: 0xff6347 },
            { name: "Jupiter", distance: 14, speed: 0.005, color: 0xdaa520 },
            { name: "Saturn", distance: 18, speed: 0.003, color: 0xcdc1c5 },
            { name: "Uranus", distance: 22, speed: 0.002, color: 0xadd8e6 },
            { name: "Neptune", distance: 26, speed: 0.001, color: 0x4682b4 }
            // Add more planets as needed
        ];

        // Create planets with realistic angles
        const planetObjects = [];
        const fieldLines = new THREE.Object3D();

        planets.forEach((planet, index) => {
            const angle = (index / planets.length) * Math.PI * 2;
            const planetGeometry = new THREE.SphereGeometry(0.3, 32, 32);
            const planetMaterial = new THREE.MeshBasicMaterial({ color: planet.color, wireframe: true });
            const planetObject = new THREE.Mesh(planetGeometry, planetMaterial);

            planetObject.position.set(Math.cos(angle) * planet.distance, 0, Math.sin(angle) * planet.distance);

            scene.add(planetObject);
            planetObjects.push({ object: planetObject, distance: planet.distance, speed: planet.speed });

            // Create magnetic field lines radiating from the sun
            const fieldLine = new THREE.CatmullRomCurve3([
                new THREE.Vector3(Math.cos(angle), 0, Math.sin(angle)),
                new THREE.Vector3(Math.cos(angle) * planet.distance, 0, Math.sin(angle) * planet.distance)
            ]);

            const fieldLinePoints = fieldLine.getPoints(planet.distance);
            const fieldLineGeometry = new THREE.BufferGeometry().setFromPoints(fieldLinePoints);
            const fieldLineMaterial = new THREE.LineBasicMaterial({ color: 0xff0000 });
            const fieldLineMesh = new THREE.Line(fieldLineGeometry, fieldLineMaterial);

            fieldLines.add(fieldLineMesh);
        });

        scene.add(fieldLines);

        // Update function to simulate orbits and apply magnetic forces
        function update() {
            planetObjects.forEach(planet => {
                const { object, distance, speed } = planet;

                // Simulate orbit
                const angle = object.position.angleTo(new THREE.Vector3(1, 0, 0)) + speed;
                object.position.set(Math.cos(angle) * distance, 0, Math.sin(angle) * distance);

                // Apply magnetic force towards the sun
                const forceDirection = new THREE.Vector3(0, 0, 0).sub(object.position).normalize();
                object.position.add(forceDirection.multiplyScalar(0.05));
            });
        }

        // Render function
        function render() {
            update();
            renderer.render(scene, camera);
            requestAnimationFrame(render);
        }

        // Set up camera position
        camera.position.y = 0;
        camera.position.z = 30;

        scene.rotation.x = -Math.PI / 2;
        // scene.rotation.y = -Math.PI / 2;

        // Start rendering
        render();
    </script>
</body>

</html>