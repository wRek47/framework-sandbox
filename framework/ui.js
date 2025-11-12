let element = function (tag) {
    return document.createElement(tag); }

function tile(number) {

  let table = element("table");
    table.setAttribute("class", "table table-bordered mb-0");
  
  // alert(number.x);
  
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
  
  return table;

}