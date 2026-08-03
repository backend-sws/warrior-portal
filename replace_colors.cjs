const fs = require('fs');
const path = require('path');

const replacements = {
    '40ba73': '305cde',
    '244a33': '1e3a8a',
    '2f5c43': '1e40af',
    '2d9458': '2563eb',
    '2d5a40': '172554',
    '355642': '1e3a8a',
    '143521': '0f172a',
    '0b1f13': '020617',
    'e7f0e9': 'eff6ff',
    'c1ebd1': 'dbeafe',
    'e3eae5': 'e0e7ff',
};

function walk(dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    list.forEach(function(file) {
        file = path.join(dir, file);
        const stat = fs.statSync(file);
        if (stat && stat.isDirectory()) { 
            results = results.concat(walk(file));
        } else {
            if (file.endsWith('.php') || file.endsWith('.css') || file.endsWith('.js') || file.endsWith('.html')) {
                results.push(file);
            }
        }
    });
    return results;
}

const dirs = [
    'e:/warriors portal/warriors portal/resources/views',
    'e:/warriors portal/warriors portal/resources/css',
];

dirs.forEach(dir => {
    const files = walk(dir);
    files.forEach(file => {
        let content = fs.readFileSync(file, 'utf8');
        let newContent = content;
        
        for (const [oldColor, newColor] of Object.entries(replacements)) {
            const regexLower = new RegExp(oldColor, 'g');
            const regexUpper = new RegExp(oldColor.toUpperCase(), 'g');
            
            newContent = newContent.replace(regexLower, newColor);
            newContent = newContent.replace(regexUpper, newColor.toUpperCase());
        }

        if (content !== newContent) {
            fs.writeFileSync(file, newContent, 'utf8');
            console.log('Updated ' + file);
        }
    });
});
