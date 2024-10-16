// Function to handle keypress events
function handleKeyPress(event) {

    // let boundary = { floor: -49, ceiling: 24, perimeter: 24 };
    console.log(event.key);

    let strafe = {
        pos: camera.position,
        speed: 1,
        x: { min: 0, max: 0, canMoveUp: true, canMoveDown: true },
        y: { min: 0, max: 0, canMoveUp: false, canMoveDown: false },
        z: { min: 0, max: 0, canMoveUp: true, canMoveDown: true },

        left: 'a',
        right: 'd',
        forward: 'w',
        backward: 's',
        upward: 'q',
        downward: 'e'
        // inward: 'q',
        // outward: 'e'
    };

    let canFly = false;
    if (canFly) { strafe.y = { canMoveUp: true, canMoveDown: true } }

    switch (event.key) {
        case strafe.forward:
            if (strafe.z.canMoveDown) {
                strafe.pos.x += strafe.speed;
            }
        break;

        case strafe.backward:
            if (strafe.z.canMoveUp) {
                strafe.pos.x -= strafe.speed;
            }
        break;

        case strafe.left:
            if (strafe.x.canMoveDown) {
                strafe.pos.z -= strafe.speed;
            }
        break;

        case strafe.right:
            if (strafe.x.canMoveUp) {
                strafe.pos.z += strafe.speed;
            }
        break;

        case strafe.upward:
            if (strafe.y.canMoveUp) {
                strafe.pos.y += strafe.speed;
            }
        break;

        case strafe.downward:
            if (strafe.y.canMoveDown) {
                strafe.pos.y -= strafe.speed;
            }
        break;
    }

    // console.log(camera.position);
}

function handleMouseClick(event) {

    console.log(rotateStructure);
    rotateStructure = rotateStructure ? false : true;

}

function handleMouseMovement(event) {
    mouse.position.x = (event.clientX - window.innerWidth / 2);
    mouse.position.y = (event.clientY - window.innerHeight / 2);

    // camera.lookAt(0, 0, 0);

    // Counter the inversion when facing backwards
    /* if (camera.rotation.x > Math.PI/2 || camera.rotation.x < -Math.PI/2) {
        camera.rotation.y -= mouseY;
        camera.rotation.z -= mouseX;
    } else {
        camera.rotation.y += mouseY;
        camera.rotation.x += mouseX;
    } */
}