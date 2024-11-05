/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  darkMode: 'media', // Ou remova essa linha para usar o padrão 'media'
  theme: {
    extend: {},
  },
  plugins: [],
};
