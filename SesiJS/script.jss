// Data Array Produk
const produk = [
  {
    id: 1,
    nama: "Laptop Gaming Pro",
    gambar:
      "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&h=300&fit=crop",
    deskripsi: "Laptop gaming dengan performa tinggi dan grafis terbaik",
    harga: 15000000,
    kategori: "Elektronik",
  },
  {
    id: 2,
    nama: "Smartphone Android",
    gambar:
      "https://images.unsplash.com/photo-1511707267537-b85faf00021e?w=400&h=300&fit=crop",
    deskripsi: "Smartphone dengan kamera 108MP dan baterai tahan lama",
    harga: 5000000,
    kategori: "Elektronik",
  },
  {
    id: 3,
    nama: "Kaos Premium",
    gambar:
      "https://images.unsplash.com/photo-1577701132604-40967e7ae5e2?w=400&h=300&fit=crop",
    deskripsi: "Kaos berkualitas tinggi dengan desain eksklusif",
    harga: 150000,
    kategori: "Fashion",
  },
  {
    id: 4,
    nama: "Celana Jeans",
    gambar:
      "https://images.unsplash.com/photo-1542272604-787c62d465d1?w=400&h=300&fit=crop",
    deskripsi: "Celana jeans branded dengan potongan modern",
    harga: 250000,
    kategori: "Fashion",
  },
  {
    id: 5,
    nama: "Kopi Premium 500gr",
    gambar:
      "https://images.unsplash.com/photo-1559056199-641a0ac8b3f4?w=400&h=300&fit=crop",
    deskripsi: "Kopi specialty grade dari daerah Sumatera",
    harga: 85000,
    kategori: "Makanan",
  },
  {
    id: 6,
    nama: "Coklat Belgia Impor",
    gambar:
      "https://images.unsplash.com/photo-1599599810694-b5ac4dd5ccf1?w=400&h=300&fit=crop",
    deskripsi: "Coklat premium dari Belgia, rasanya yang nikmat",
    harga: 95000,
    kategori: "Makanan",
  },
  {
    id: 7,
    nama: "Blender Elektronik",
    gambar:
      "https://images.unsplash.com/photo-1578194494058-a3fb3e2b0d6f?w=400&h=300&fit=crop",
    deskripsi: "Blender dengan kapasitas 2L dan motor 1000W",
    harga: 450000,
    kategori: "Peralatan Rumah",
  },
  {
    id: 8,
    nama: "Set Panci Masak",
    gambar:
      "https://images.unsplash.com/photo-1578194494058-a3fb3e2b0d6f?w=400&h=300&fit=crop",
    deskripsi: "Panci 5 piece dari material stainless steel",
    harga: 350000,
    kategori: "Peralatan Rumah",
  },
  {
    id: 9,
    nama: "Sepeda Gunung",
    gambar:
      "https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop",
    deskripsi: "Sepeda gunung dengan 21 kecepatan dan ban bertepi",
    harga: 2500000,
    kategori: "Olahraga",
  },
  {
    id: 10,
    nama: "Dumbbell Set",
    gambar:
      "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=300&fit=crop",
    deskripsi: "Set dumbbell 20kg dengan harga terjangkau",
    harga: 350000,
    kategori: "Olahraga",
  },
  {
    id: 11,
    nama: "Helm Safety",
    gambar:
      "https://images.unsplash.com/photo-1569163139394-de4798aa62b3?w=400&h=300&fit=crop",
    deskripsi: "Helm safety standar SNI dengan ventilasi baik",
    harga: 125000,
    kategori: "Olahraga",
  },
  {
    id: 12,
    nama: "Smartwatch Canggih",
    gambar:
      "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop",
    deskripsi: "Smartwatch dengan banyak fitur kesehatan dan olahraga",
    harga: 1200000,
    kategori: "Elektronik",
  },
];

// State untuk menyimpan produk yang ditampilkan
let produkTampil = [...produk];

// Fungsi Format Harga
function formatRupiah(harga) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(harga);
}

// Fungsi Tampilkan Produk
function tampilkanProduk(daftarProduk) {
  const container = document.getElementById("productsContainer");
  const emptyState = document.getElementById("emptyState");
  const countSpan = document.getElementById("productCount");

  // Jika tidak ada produk
  if (daftarProduk.length === 0) {
    container.innerHTML = "";
    emptyState.style.display = "block";
    countSpan.textContent = "0";
    return;
  }

  // Tampilkan produk
  emptyState.style.display = "none";
  countSpan.textContent = daftarProduk.length;

  container.innerHTML = daftarProduk
    .map(
      (p) => `
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="product-image-wrapper">
                    <img src="${p.gambar}" class="card-img-top" alt="${p.nama}">
                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">${p.kategori}</span>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-truncate">${p.nama}</h5>
                    <p class="card-text text-muted flex-grow-1">${p.deskripsi}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-success fw-bold">${formatRupiah(p.harga)}</span>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-cart-plus"></i> Beli
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `,
    )
    .join("");
}

// Fungsi Filter Produk
function filterProducts() {
  const searchInput = document
    .getElementById("searchInput")
    .value.toLowerCase();
  const categoryFilter = document.getElementById("categoryFilter").value;
  const priceFilter = document.getElementById("priceFilter").value;

  // Filter berdasarkan pencarian
  produkTampil = produk.filter((p) => {
    const matchSearch =
      p.nama.toLowerCase().includes(searchInput) ||
      p.deskripsi.toLowerCase().includes(searchInput);
    const matchCategory =
      categoryFilter === "" || p.kategori === categoryFilter;
    return matchSearch && matchCategory;
  });

  // Urutkan berdasarkan harga
  if (priceFilter === "low-to-high") {
    produkTampil.sort((a, b) => a.harga - b.harga);
  } else if (priceFilter === "high-to-low") {
    produkTampil.sort((a, b) => b.harga - a.harga);
  }

  tampilkanProduk(produkTampil);
}

// Fungsi Reset Filter
function resetFilters() {
  document.getElementById("searchInput").value = "";
  document.getElementById("categoryFilter").value = "";
  document.getElementById("priceFilter").value = "";
  produkTampil = [...produk];
  tampilkanProduk(produkTampil);
}

// Inisialisasi - Tampilkan produk saat halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
  tampilkanProduk(produk);
});
