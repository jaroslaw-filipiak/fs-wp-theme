import archiver from 'archiver';
import { createWriteStream, readFileSync } from 'fs';
import { join, dirname } from 'path';
import { fileURLToPath } from 'url';

const __dirname = dirname(fileURLToPath(import.meta.url));
const themeDir = join(__dirname, '..');

// Read version from style.css
const styleCss = readFileSync(join(themeDir, 'style.css'), 'utf8');
const versionMatch = styleCss.match(/Version:\s*(.+)/i);
const version = versionMatch ? versionMatch[1].trim() : '0.0.0';

const zipName = `fajnestarocie-ver-${version}.zip`;
const outputPath = join(themeDir, '..', zipName);

console.log(`Creating ${zipName}...`);

// Create output stream
const output = createWriteStream(outputPath);
const archive = archiver('zip', { zlib: { level: 9 } });

// Listen for events
output.on('close', () => {
  const sizeMB = (archive.pointer() / 1024 / 1024).toFixed(2);
  console.log(`\nTheme packaged successfully!`);
  console.log(`Output: ${outputPath}`);
  console.log(`Size: ${sizeMB} MB`);
});

archive.on('warning', (err) => {
  if (err.code === 'ENOENT') {
    console.warn('Warning:', err.message);
  } else {
    throw err;
  }
});

archive.on('error', (err) => {
  throw err;
});

// Pipe archive to output
archive.pipe(output);

// Add files with exclusions
archive.glob('**/*', {
  cwd: themeDir,
  ignore: [
    'node_modules/**',
    'CLAUDE.md',
    'CHANGELOG.md',
    '.git/**',
    '.gitignore',
    'scripts/**',
    '*.log',
    '.env',
    '.DS_Store',
    'package-lock.json'
  ],
  dot: false
});

// Finalize
archive.finalize();
