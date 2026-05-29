const fs = require('fs');
const path = require('path');
const { createWorker } = require('tesseract.js');
const Jimp = require('jimp');

async function testOCR(imagePath) {
    console.log("Original Image:", imagePath);
    
    // Test 1: No preprocessing
    try {
        const worker1 = await createWorker('ind');
        const ret1 = await worker1.recognize(imagePath);
        console.log("=== RAW OCR (No Preprocessing) ===");
        console.log(ret1.data.text);
        await worker1.terminate();
    } catch(e) {
        console.error(e);
    }

    // Test 2: Grayscale + Normalize + Contrast
    try {
        const image = await Jimp.read(imagePath);
        const processedPath = imagePath + '_test.jpg';
        image.grayscale().normalize().contrast(0.2).write(processedPath);
        
        await new Promise(r => setTimeout(r, 500));
        
        const worker2 = await createWorker('ind');
        const ret2 = await worker2.recognize(processedPath);
        console.log("\n=== RAW OCR (Grayscale + Normalize + Contrast 0.2) ===");
        console.log(ret2.data.text);
        await worker2.terminate();
    } catch(e) {
        console.error(e);
    }
}

testOCR(process.argv[2]);
