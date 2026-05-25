const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const destPath = path.join(__dirname, 'public', 'storage');
const srcPath = path.join(__dirname, 'storage', 'app', 'public');

const isVercel = process.env.VERCEL === '1';

if (isVercel) {
    console.log('Running on Vercel. Cleaning up public/storage...');
    try {
        fs.rmSync(destPath, { recursive: true, force: true });
    } catch (e) {
        console.log('Error cleaning public/storage:', e.message);
    }
}

let isSymlink = false;
try {
    const stat = fs.lstatSync(destPath);
    if (stat.isSymbolicLink()) {
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
