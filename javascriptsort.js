
// Define a function to sort an array of student records using Quick Sort algorithm
function quickSort(arr, field) {
  if (arr.length <= 1) {
    return arr;
  }

  const pivot = arr[0];
  const left = [];
  const right = [];

  for (let i = 1; i < arr.length; i++) {
    if (arr[i][field] < pivot[field]) {
      left.push(arr[i]);
    } else {
      right.push(arr[i]);
    }
  }

  return quickSort(left, field).concat(pivot, quickSort(right, field));
}


