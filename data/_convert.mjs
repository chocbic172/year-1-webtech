// Utility to convert data from assets/product-array.html into useful JSON
// Can be run using Node.js and the following command - `node _convert.js`
import { writeFile } from 'node:fs';
import { hoodies, jumpers, tshirts } from './_rawdata.mjs';

const OUTPUT_FILE = "./data/products.json";
const MINIFY_OUTPUT = true; // "Minify" the JSON output, i.e. remove whitespace

const objFromDataEntry = (dataEntry) => {
  return {
    name: dataEntry[0],
    color: dataEntry[1],
    description: dataEntry[2],
    price: dataEntry[3],
    img: dataEntry[4]
  }
}

const parsedData = {
    hoodies: hoodies.map(objFromDataEntry),
    jumpers: jumpers.map(objFromDataEntry),
    tshirts: tshirts.map(objFromDataEntry)
}

const parsedDataJSON = JSON.stringify(parsedData, null, MINIFY_OUTPUT ? 0 : 2);

// Write the generated JSON data to the output file
writeFile(OUTPUT_FILE, parsedDataJSON, err => {
    if (err) { console.error(err); }
});