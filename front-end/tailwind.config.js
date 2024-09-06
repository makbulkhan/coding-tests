/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./index.html', './src/**/*.{html,js}'],
  theme: {
    extend: {
      colors: {
        'clr-free': '#0db0c0',
        'clr-standard': '#0069cc',
        'clr-pro': '#ff8853',
        'clr-enterprise': '#2c2c2c',
        'clr-btn': '#01818f',
        'clr-footer': '#2c2c2c',
        'clr-border': '#e5e7e6',
        'clr-gray': '#faf8f9',
      },
      fontFamily: {
        'soehne': ['Soehne', 'Corbel', 'Arial']
      }
    },
  },
  plugins: [],
}