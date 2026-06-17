const fs = require('fs');
if (fs.existsSync('assets/css/tailwind.css')) {
    const css = fs.readFileSync('assets/css/tailwind.css', 'utf8');
    console.log('Contains translate-x-0:', css.includes('translate-x-0') || css.includes('.translate-x-0'));
    console.log('Contains -translate-x-full:', css.includes('-translate-x-full') || css.includes('.-translate-x-full'));
    console.log('Contains md:translate-x-0:', css.includes('md:translate-x-0') || css.includes('\\:translate-x-0'));
    console.log('Contains ease-in-out:', css.includes('ease-in-out') || css.includes('.ease-in-out'));
}
