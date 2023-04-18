/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.js", "./*/**/*.php"],
  theme: {
    extend: {
      colors:{
        'BrightL': '#A6CC42',
        'DeepB': '#0454BB',
        'BrightB': '#04ACEB',
        'MidnightB':'#082558',
        'Blanco': '#FFF',
        'GrisO': '#707070'
      },
     fontFamily:{
        'Poppins': ['Poppins', 'sans-serif'],
      },
      screens: {
        'phone': {'min': '240px'},
        'tablet': {'min': '401px'},
        'laptop': {'min': '540px'},
        'desktop': {'min': '776px'}
      }
  },
  },
  plugins: [],
}

