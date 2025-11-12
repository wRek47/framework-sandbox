let element = function (tag) {
    return document.createElement(tag); }

function tile(number) {

  let table = element("table");
    table.setAttribute("class", "table table-bordered mb-0");
  
  // alert(number.x + ", " + number.y);
  
  if (Math.abs(number.x) > 0 && Math.abs(number.y) > 0) {
  
    let node;
    let z = 0; for (let i = 1; i <= Math.abs(number.x); i++) {
  
      let row = element("tr");
    
      for (let j = 1; j <= Math.abs(number.y); j++) {
    
        z++;
        
        let emptyNode = new Node(z, "...", "");
        let col = element("td");
        
        if (z == number.z) { col.setAttribute("class", "bg-secondary"); }
        
        // alert(i);
        node = number.node(i, j);
        
        if (!node) { node = emptyNode; }
        if (node.parent) { node = emptyNode; }
        
        // let currentParent = number.parent(node.parent.current);
        // alert(currentParent);
        
        if (!node.content) {
        
          node.content = "Empty Cell";
        
        }
      
        number.children[z] = node;
        
        col.innerHTML = node.content;
        row.appendChild(col);
      
      }
      
      table.appendChild(row);
    
    }
  
  } else if (Math.abs(number.x) > 0 && Math.abs(number.z) > 0) {
  
    let node;
    let z = 0;
    
    for (let i = 1; i <= Math.abs(number.x); i++) {
    
      z++;
      
      let row = element("tr");
      
      let col = element("td");
      
      col.innerHTML = "TODO: Row Contents.";
      
      row.appendChild(col);
      
      table.appendChild(row);
    
    }
  
  } else if (Math.abs(number.y) > 0 && Math.abs(number.z) > 0) {
  
    let row = element("tr");
    
    let node;
    let z = 0;
    
    for (let i = 1; i <= Math.abs(number.y); i++) {
    
      let col = element("td");
      
      col.innerHTML = "TODO: Columns Contents.";
      
      row.appendChild(col);
    
    }
    
    table.appendChild(row);
  
  } else if (Math.abs(number.y) > 0) {
  
    let row = element("tr");
    
    let col = element("td");
    
    let z = number.z + number.y;
    col.innerHTML = z;
    
    row.appendChild(col);
    
    table.appendChild(row);
  
  } else if (Math.abs(number.x) > 0) {
  
    let row = element("tr");
    
    let col = element("td");
    
    let z = 2 * number.x;
    col.innerHTML = z;
    
    row.appendChild(col);
    
    table.appendChild(row);
  
  } else {
  
    let row = element("tr");
    
    let col = element("td");
    
    col.innerHTML = "0";
    
    row.appendChild(col);
    
    table.appendChild(row);
  
  }
  
  return table;

}