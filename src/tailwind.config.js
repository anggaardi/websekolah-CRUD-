// tailwind.config.js
module.exports = {
    content: [
        './src/**/*.{html,js}', // sesuaikan path dengan proyek Anda
    ],
    theme: {
        extend: {
            keyframes: {
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
            },
            animation: {
                slideUp: 'slideUp 0.8s ease-out forwards',
            },
        },
    },
    plugins: [],
};
