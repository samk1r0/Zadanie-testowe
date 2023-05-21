/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      content:{
        'loopIcon': 'url(./src/assets/loop.svg)'
      }
    },
  },
  plugins: [],
}

