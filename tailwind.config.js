export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        poppins: ["Poppins", "sans-serif"],
        inter: ["Inter", "sans-serif"],
        roboto: ["Roboto", "sans-serif"],
        helvetica: ["Helvetica", "Arial", "sans-serif"],
        sans: [
          "Inter", 
          "Poppins", 
          "Roboto", 
          "Helvetica", 
          "Arial", 
          "ui-sans-serif", 
          "system-ui", 
          "sans-serif",
        ],
      },
    },
  },
  plugins: [],
};
