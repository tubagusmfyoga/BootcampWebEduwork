<?php
session_start();
require_once 'config.php';

$product = null;

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }
}

// Add to cart
if (isset($_POST['add_to_cart']) && $product) {
    $quantity = intval($_POST['quantity']);
    
    if (isset($_SESSION['cart'][$product['id']])) {
        $_SESSION['cart'][$product['id']] += $quantity;
    } else {
        $_SESSION['cart'][$product['id']] = $quantity;
    }
    
    $_SESSION['success_msg'] = "Produk berhasil ditambahkan ke keranjang!";
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product ? $product['name'] : 'Produk'; ?> - Toko Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .product-image-main {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            background-color: #e9ecef;
        }
        .product-price {
            font-size: 2.5rem;
            font-weight: bold;
            color: #dc3545;
        }
        .btn-add-cart {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 5px;
            padding: 12px 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-add-cart:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .spec-item {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .cart-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-shopping-bag"></i> Toko Online
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="cart.php">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                                <span class="cart-badge"><?php echo count($_SESSION['cart']); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container -->
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Detail Produk</li>
            </ol>
        </nav>

        <?php if ($product): ?>
            <!-- Product Detail -->
            <div class="row mb-5">
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/500x400?text=<?php echo urlencode($product['name']); ?>" 
                         alt="<?php echo $product['name']; ?>" class="product-image-main">
                </div>
                <div class="col-md-6">
                    <h1 class="mb-3"><?php echo $product['name']; ?></h1>
                    
                    <p class="product-price mb-3">
                        Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                    </p>

                    <div class="mb-3">
                        <p class="lead"><?php echo $product['description']; ?></p>
                    </div>

                    <div class="spec-item">
                        <strong>Status Stok:</strong><br>
                        <?php if ($product['stock'] > 0): ?>
                            <span class="badge bg-success">Tersedia (<?php echo $product['stock']; ?> unit)</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Stok Habis</span>
                        <?php endif; ?>
                    </div>

                    <div class="spec-item">
                        <strong>Ditambahkan:</strong><br>
                        <?php echo date('d M Y H:i', strtotime($product['created_at'])); ?>
                    </div>

                    <?php if ($product['stock'] > 0): ?>
                        <form method="POST" class="mt-4">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah:</label>
                                <input type="number" id="quantity" name="quantity" class="form-control" 
                                       value="1" min="1" max="<?php echo $product['stock']; ?>">
                            </div>
                            <button type="submit" name="add_to_cart" class="btn btn-add-cart text-white me-2">
                                <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </form>
                    <?php else: ?>
                        <div class="mt-4">
                            <button class="btn btn-secondary me-2" disabled>
                                <i class="fas fa-times-circle"></i> Stok Habis
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-triangle"></i> Produk tidak ditemukan!
            </div>
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Halaman Utama
            </a>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center text-muted">
            <p>&copy; 2026 Toko Online. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>