const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const destPath = path.join(__dirname, 'public', 'storage');
const srcPath = path.join(__dirname, 'storage', 'app', 'public');

const publicPath = path.join(__dirname, 'public');
console.log('__dirname:', __dirname);
console.log('public exists:', fs.existsSync(publicPath));
if (fs.existsSync(publicPath)) {
    const stats = fs.statSync(publicPath);
    console.log('public isDirectory:', stats.isDirectory());
    console.log('public isFile:', stats.isFile());
    console.log('public isSymbolicLink:', fs.lstatSync(publicPath).isSymbolicLink());
}

let isSymlink = false;
try {
    if (fs.existsSync(destPath) && fs.lstatSync(destPath).isSymbolicLink()) {
        isSymlink = true;
    }
} catch (e) {}

if (isSymlink) {
    console.log('public/storage is a symbolic link, skipping copy.');
} else {
    console.log('Copying storage assets from storage/app/public to public/storage...');
    function copyDir(src, dest) {
        if (!fs.existsSync(src)) return;
        fs.mkdirSync(dest, { recursive: true });
        let entries = fs.readdirSync(src, { withFileTypes: true });

        for (let entry of entries) {
            let srcP = path.join(src, entry.name);
            let destP = path.join(dest, entry.name);

            if (entry.isDirectory()) {
                copyDir(srcP, destP);
            } else {
                fs.copyFileSync(srcP, destP);
            }
        }
    }
    copyDir(srcPath, destPath);
    console.log('Assets copied successfully.');
}

console.log('Running vite build...');
execSync('vite build', { stdio: 'inherit' });
