// Elemen-elemen yang akan berubah bahasanya
const title = document.getElementById('title');
const description = document.getElementById('description');

// Data untuk tiap bahasa
const translations = {
    en: {
        title: "Welcome",
        description: "This is a simple bilingual website example."
    },
    id: {
        title: "Selamat Datang",
        description: "Ini adalah contoh situs web dua bahasa yang sederhana."
    }
};

// Fungsi untuk mengubah bahasa
function changeLanguage(language) {
    title.textContent = translations[language].title;
    description.textContent = translations[language].description;
}

// Event listener untuk tombol bahasa
document.getElementById('lang-en').addEventListener('click', function() {
    changeLanguage('en');
});

document.getElementById('lang-id').addEventListener('click', function() {
    changeLanguage('id');
});
