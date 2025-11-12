function queryId(data, target, field = "id") {

  if (!Array.isArray(data) || data.length === 0) {
  
    alert("Data is not an array.");
    return false;
  
  }
  
  let index = data.findIndex(item => item[field] === target);
  if (index === -1) {
  
    return null;
  
  }
  
  let keys = Object.keys(data[index]);
  let vals = Object.values(data[index]);
  
  let result = keys.reduce((acc, key, i) => {
  
    acc[key] = vals[i];
    return acc;
  
  }, {});
  
  // alert(result);
  
  return result;

}

function query(data, target, field = "id") {

  // alert(data);
  let result = queryId(data, target, field);
  // alert(result);
  
  // return data[result];
  return result;

}

function array_fill(value, length) {

  return Array.from({ length: length }, () => value);

}