const fs = require('fs');
const path = require('path');

// Simple recursive file finder to see what files exist and match
function walk(dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(file => {
        const fullPath = path.join(dir, file);
        const stat = fs.statSync(fullPath);
        if (stat && stat.isDirectory()) {
            results = results.concat(walk(fullPath));
        } else {
            if (file.endsWith('.php')) {
                results.push(fullPath);
            }
        }
    });
    return results;
}

const viewsDir = path.join(__dirname, 'application', 'views');
console.log('Views directory exists:', fs.existsSync(viewsDir));
if (fs.existsSync(viewsDir)) {
    const files = walk(viewsDir);
    console.log('Total PHP files found:', files.length);
    console.log('First 5 files:', files.slice(0, 5));
}
