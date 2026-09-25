/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        linen: {
          50: '#FBF8F2',
          100: '#F5EFE3',
          200: '#EBE1CC',
        },
        stone: {
          600: '#8A7F6E',
          700: '#5C5347',
          800: '#3A342B',
          900: '#26221C',
        },
        gold: {
          400: '#C9A45E',
          500: '#B8935A',
          600: '#9C7A45',
        },
        slateblue: {
          500: '#5B7A8C',
          600: '#4A6575',
        },
        navy: {
          700: '#2C4562',
          800: '#203350',
          900: '#16233A',
        },
        olive: {
          500: '#7C8A5C',
          600: '#67744A',
        },
      },
      fontFamily: {
        serif: ['"Fraunces"', 'ui-serif', 'Georgia', 'serif'],
        sans: ['"Inter"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      maxWidth: {
        prose: '68ch',
      },
      boxShadow: {
        soft: '0 1px 2px rgba(38, 34, 28, 0.06), 0 8px 24px -12px rgba(38, 34, 28, 0.18)',
      },
    },
  },
  plugins: [],
}
