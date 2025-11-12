class Node {

  constructor(x, label, content) {
  
    this.id = x;
    this.label = label;
    this.content = content;
  
  }

}

class Number {

  constructor(units, data = undefined) {
  
    this.value = 0;
    this.units = units;
    
    // alert(units.length);
    
    this.x = 0; this.y = 0; this.z = 0;
    if (units.length >= 1) { this.x = units[0]; }
    if (units.length >= 2) { this.y = units[1]; }
    if (units.length >= 3) { this.z = units[2]; }
    
    this.value = units.length;
    this.product = this.x * this.y;
    
    this.alignments = this.align(data);
    
    this.children = [];
  
  }
  
  align(data) {
  
    let sheet = [];
      // let sheetSize = this.product;
    
    // let sheetColumn = array_fill("", this.y);
    // sheet = array_fill(sheetColumn, this.x);
    for (let i = 0; i < this.x; i++) {
    
      sheet[i] = [];
      
      for (let j = 0; j < this.y; j++) {
      
        sheet[i].push("");
        // new Node(new Number(1, 1), "...", ""));
      
      }
    
    }
    
    
    let z = 0; data.forEach(item => {
    
      let [x, y] = item.position;
      let cell = { x: x - 1, y: y - 1 }
      
      sheet[cell.x][cell.y] = item;
      
      z++;
    
    });
    
    return sheet;
  
  }
  
  /* connect(trajectory) {
  
    let dpad = [
      "north" => [0, -1],
      "northeast" => [1, -1],
      "east" => [1, 0],
      "southeast" => [1, 1],
      "south" => [0, 1],
      "southwest" => [-1, 1],
      "west" => [-1, 0],
      "northwest" => [-1, -1]
    ];
    
    let [x1, y1] = [this.x, this.y];
    let [x2, y2] = dpad[trajectory];
    let [dx, dy] = [x1 + x2, y1 + y2];
    
    
  
  } */
  
  node(x, y) {
  
    x -= 1; y -= 1;
    let result = this.alignments[x][y];
    
    return result;
  
  }
  
  child(z) { return this.children[z]; }

}