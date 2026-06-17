const path = require('path');
const fg = require('fast-glob');

const contentPaths = fg.sync(path.join(__dirname, 'application/views/**/*.php').replace(/\\/g, '/'));
console.log('Tailwind Config scanning paths:', contentPaths.length);

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: contentPaths,
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        outfit: ['Outfit', 'sans-serif'],
      },
      colors: {
        brand: {
          50: '#f5f7fb',
          100: '#ebf0f7',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
        }
      }
    },
  },
  plugins: [],
}
