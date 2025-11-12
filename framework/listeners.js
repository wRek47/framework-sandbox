let btn = {};

  btn.entrance = document.querySelector("#entrance");
  btn.exit = document.querySelector("#exit");
  btn.north = document.querySelector("#north");
  btn.east = document.querySelector("#east");
  btn.south = document.querySelector("#south");
  btn.west = document.querySelector("#west");
  
  btn.observe = document.querySelector("#observe");

btn.entrance.addEventListener("click", function() {

  if (number.z === 0) { number.z++; }
  if (Math.abs(number.z) > number.product) { number.z = 0; }
  
  updateContent(number);

});

btn.exit.addEventListener("click", function() {

  number.z--;
  if (Math.abs(number.z) > number.product) { number.z = 0; }
  
  updateContent(number);

});

btn.north.addEventListener("click", function() {

  if (number.z === 0) { number.x--; }
  else if (Math.abs(number.z) >= 1) { number.z -= number.y; }
  
  if (Math.abs(number.z) > number.product) { number.z = 0; }
  
  updateContent(number);

});

btn.east.addEventListener("click", function() {

  if (number.z === 0) { number.y++; }
  else if (Math.abs(number.z) >= 1) { number.z++; }
  
  if (Math.abs(number.z) > number.product) { number.z = 0; }
  updateContent(number);

});

btn.south.addEventListener("click", function() {

  if (number.z === 0) { number.x++; }
  else if (Math.abs(number.z) >= 1) { number.z += number.y }
  
  if (Math.abs(number.z) > number.product) { number.z = 0; }
  updateContent(number);

});

btn.west.addEventListener("click", function() {

  if (number.z === 0) { number.y--; }
  else if (Math.abs(number.z) >= 1) { number.z--; }
  
  if (Math.abs(number.z) > number.product) { number.z = 0; }
  updateContent(number);

});

btn.observe.addEventListener("click", function() {

  if (number.z === 0) {
  
    alert("Observing Grid View");
  
  } else {
  
    // let children = number.children;
    let child = number.child(number.z);
    
    child.data = [];
    // child.numbers.forEach(subNumber => {
    
      // child.data.push(query(numbers, subNumber, "id"));
    
    // });
    
    child.data = query(numbers.rows, child.numbers[0], "id");
    alert(number.z + ": " + child.data.content);
    
    // document.write(child.data);
    
    // let previousNumber = number;
    // let currentNumber = new Number(child.size, child.data);
    // alert(child.numbers.size);
  
  }

});

function updateContent(number) {

  updatePosition(number);
  let table = tile(number);

  // alert(number.x);

  let div = element("div");
    div.appendChild(table);
    
  let network = document.querySelector("#network");
    network.innerHTML = div.innerHTML;

}

function updatePosition(number) {

  let pos = document.querySelector("#position");
  
  pos.innerHTML = "[" +
    number.x + ", " +
    number.y + ", " +
    number.z +
  "]";

}