// books.js

const books = [
    {
        title: "Atomic Habits",
        image: "assets/atomic.jpg",
        desc: "Panduan untuk membentuk kebiasaan positif dan menghentikan kebiasaan buruk.",
        year: "2021",
        pages: 320,
        author: "James Clear",
        genre: "Self-help"
    },
    {
        title: "Laskar Pelangi",
        image: "assets/laskar.jpg",
        desc: "Kisah inspiratif dari anak-anak miskin di Belitung.",
        year: "2005",
        pages: 529,
        author: "Andrea Hirata",
        genre: "Novel"
    },
    // Tambah buku lainnya...
];

const container = document.getElementById('book-list');

books.forEach(book => {
    const card = document.createElement('div');
    card.className = 'book-card';
    card.innerHTML = `
    <img src="${book.image}" alt="${book.title}" />
    <div class="title">${book.title}</div>
    <button class="yellow" onclick='openModal(${JSON.stringify(book)})'>Lihat</button>
  `;
    container.appendChild(card);
});

function openModal(book) {
    document.getElementById('modalImage').src = book.image;
    document.getElementById('modalTitle').innerText = book.title;
    document.getElementById('modalDesc').innerText = book.desc;
    document.getElementById('modalYear').innerText = book.year;
    document.getElementById('modalPages').innerText = book.pages;
    document.getElementById('modalAuthor').innerText = book.author;
    document.getElementById('modalGenre').innerText = book.genre;
    document.getElementById('bookModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('bookModal').style.display = 'none';
}
