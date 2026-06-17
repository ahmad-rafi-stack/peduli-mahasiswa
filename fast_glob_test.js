const fg = require('fast-glob');

console.log('Relative with forward slashes (no ./):');
try {
    const res = fg.sync('application/views/**/*.php');
    console.log('Count:', res.length, res.slice(0, 3));
} catch (e) { console.error(e); }

console.log('Relative with ./ and forward slashes:');
try {
    const res = fg.sync('./application/views/**/*.php');
    console.log('Count:', res.length, res.slice(0, 3));
} catch (e) { console.error(e); }

console.log('Absolute with forward slashes:');
try {
    const res = fg.sync('C:/xampp/htdocs/www.peduli-mahasiswa.com/application/views/**/*.php');
    console.log('Count:', res.length, res.slice(0, 3));
} catch (e) { console.error(e); }
