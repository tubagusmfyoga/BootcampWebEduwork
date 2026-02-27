<?php
session_start();
require_once 'config.php';

$cart_items = [];
$total = 0;

// Get cart items from database
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cart_ids = implode(',', array_keys($_SESSION['cart']));
    $sql = "SELECT * FROM products WHERE id IN ($cart_ids)";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $quantity = $_SESSION['cart'][$row['id']];
            $subtotal = $row['price'] * $quantity;
            $total += $subtotal;
            
            $row['quantity'] = $quantity;
            $row['subtotal'] = $subtotal;
            $cart_items[] = $row;
        }
    }
}

// Update quantity
if (isset($_POST['update_quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if ($quantity > 0) {
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        unset($_SESSION['cart'][$product_id]);
    }
    
    header("Location: cart.php");
    exit();
}

// Remove item
if (isset($_GET['remove'])) {
    $product_id = intval($_GET['remove']);
    unset($_SESSION['cart'][$product_id]);
    
    $_SESSION['success_msg'] = "Produk dihapus dari keranjang!";
    header("Location: cart.php");
    exit();
}

// Clear cart
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    $_SESSION['success_msg'] = "Keranjang belanja dikosongkan!";
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Toko Online</title>
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
        .cart-item {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            background-color: white;
        }
        .product-image-cart {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            background-color: #e9ecef;
        }
        .summary-box {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 20px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .summary-total {
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #dc3545;
        }
        .btn-checkout {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 5px;
            padding: 12px 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-checkout:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
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
        .quantity-control {
            width: 100px;
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
                        <a class="nav-link active position-relative" href="cart.php">
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
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h1>
            <a href="index.php" class="btn btn-outline-primary">
                <i class="fas fa-plus-circle"></i> Lanjut Belanja
            </a>
        </div>

        <!-- Success Message -->
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success_msg']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_msg']); ?>
        <?php endif; ?>

        <?php if (count($cart_items) > 0): ?>
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="https://via.placeholder.com/150x150?text=<?php echo urlencode($item['name']); ?>" 
                                         alt="<?php echo $item['name']; ?>" class="product-image-cart">
                                </div>
                                <div class="col-md-5">
                                    <h5><?php echo $item['name']; ?></h5>
                                    <p class="text-muted"><?php echo substr($item['description'], 0, 50); ?>...</p>
                                    <p class="fw-bold">Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></p>
                                </div>
                                <div class="col-md-4">
                                    <form method="POST" class="d-flex align-items-center gap-2">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                               min="1" max="<?php echo $item['stock']; ?>" class="form-control quantity-control">
                                        <button type="submit" name="update_quantity" class="btn btn-sm btn-info">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                    <div class="mt-2">
                                        <p class="text-muted">Subtotal:<br>
                                           <span class="text-danger fw-bold">
                                               Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?>
                                           </span>
                                        </p>
                                    </div>
                                    <a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Hapus item ini?');">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Summary -->
                <div class="col-lg-4">
                    <div class="summary-box">
                        <h4 class="mb-4"><i class="fas fa-receipt"></i> Ringkasan Pesanan</h4>
                        
                        <div class="summary-item">
                            <span>Total Barang:</span>
                            <span><?php echo count($cart_items); ?> produk</span>
                        </div>
                        
                        <div class="summary-item">
                            <span>Subtotal:</span>
                            <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                        </div>

                        <div class="summary-item">
                            <span>Ongkos Kirim:</span>
                            <span>Rp 0</span>
                        </div>

                        <div class="summary-item summary-total">
                            <span>Total:</span>
                            <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                        </div>

                        <button class="btn btn-checkout text-white mt-4" onclick="alert('Fitur checkout masih dalam pengembangan')">
                            <i class="fas fa-credit-card"></i> Lanjut ke Pembayaran
                        </button>

                        <a href="cart.php?clear=1" class="btn btn-outline-danger w-100 mt-2" 
                           onclick="return confirm('Kosongkan keranjang?');">
                            <i class="fas fa-trash-alt"></i> Kosongkan Keranjang
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Empty Cart -->
            <div class="empty-cart">
                <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                <h3 class="text-muted">Keranjang Anda Masih Kosong</h3>
                <p class="text-muted mb-4">Mulai belanja dan tambahkan produk favorit Anda ke keranjang</p>
                <a href="index.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag"></i> Mulai Belanja
                </a>
            </div>
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