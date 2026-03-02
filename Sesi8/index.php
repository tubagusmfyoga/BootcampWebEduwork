<?php
session_start();
require_once 'config.php';

// Get all products from database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    $_SESSION['success_msg'] = "Produk berhasil ditambahkan ke keranjang!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online - E-commerce</title>
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
        .product-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
            background-color: #e9ecef;
        }
        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #dc3545;
        }
        .product-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            min-height: 45px;
        }
        .btn-add-cart {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn-add-cart:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
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
        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
            border-radius: 10px;
        }
        .stock-info {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .quantity-input {
            width: 80px;
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
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="cart.php">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                            <?php if (count($_SESSION['cart']) > 0): ?>
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
        <!-- Header Section -->
        <div class="header-section">
            <h1 class="mb-2"><i class="fas fa-store"></i> Selamat Datang di Toko Online Kami</h1>
            <p class="lead mb-0">Temukan produk elektronik berkualitas dengan harga terbaik</p>
        </div>

        <!-- Success Message -->
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success_msg']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_msg']); ?>
        <?php endif; ?>

        <!-- Products Grid -->
        <div class="row g-4 mb-5">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card product-card">
                            <div class="position-relative">
                                <img src="https://via.placeholder.com/300x250?text=<?php echo urlencode($product['name']); ?>" 
                                     alt="<?php echo $product['name']; ?>" class="product-image">
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="badge bg-success position-absolute top-0 end-0 m-2">
                                        Stok: <?php echo $product['stock']; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">Habis</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="product-title"><?php echo $product['name']; ?></h5>
                                <p class="card-text text-muted text-truncate" title="<?php echo $product['description']; ?>">
                                    <?php echo substr($product['description'], 0, 50); ?>...
                                </p>
                                
                                <div class="mt-auto">
                                    <p class="product-price mb-3">
                                        Rp <?php echo number_format($product['price'], 0, ',', '.'); ?>
                                    </p>

                                    <?php if ($product['stock'] > 0): ?>
                                        <form method="POST" class="mb-2">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <div class="input-group mb-2">
                                                <input type="number" name="quantity" class="form-control quantity-input" 
                                                       value="1" min="1" max="<?php echo $product['stock']; ?>">
                                            </div>
                                            <button type="submit" name="add_to_cart" class="btn btn-add-cart w-100 text-white">
                                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                            </button>
                                        </form>
                                        <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary w-100 btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary w-100" disabled>
                                            Stok Habis
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <p class="lead">Belum ada produk yang tersedia</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-store"></i> Toko Online</h5>
                    <p class="text-muted">Toko elektronik online terpercaya dengan produk berkualitas</p>
                </div>
                <div class="col-md-4">
                    <h5>Menu</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-muted text-decoration-none">Beranda</a></li>
                        <li><a href="cart.php" class="text-muted text-decoration-none">Keranjang Belanja</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Hubungi Kami</h5>
                    <p class="text-muted">
                        <i class="fas fa-phone"></i> +62 812 3456 7890<br>
                        <i class="fas fa-envelope"></i> info@tokoonline.com
                    </p>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center text-muted">
                <p>&copy; 2026 Toko Online. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>