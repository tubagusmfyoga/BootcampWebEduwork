<?php
// Server-side validation and result display for product input
$errors = [];
$name = '';
$price = '';
$description = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name === '') {
        $errors[] = 'Product name is required.';
    }
    if ($price === '') {
        $errors[] = 'Price is required.';
    } elseif (!is_numeric($price)) {
        $errors[] = 'Price must be a number.';
    } elseif ((float)$price < 0) {
        $errors[] = 'Price cannot be negative.';
    }

    if (empty($errors)) {
        $success = true;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Result</title>
    <link rel="stylesheet" href="../Sesi1/bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">Product Submission Result</h3>

                    <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
                        <div class="alert alert-info">No data submitted. Use the form to submit a product.</div>
                        <a href="form_input.php" class="btn btn-primary">Open Input Form</a>
                    <?php else: ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $e): ?>
                                        <li><?php echo htmlspecialchars($e); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <a href="form_input.php" class="btn btn-secondary">Back to Form</a>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success">Product validated and accepted.</div>
                            <ul class="list-group mb-4">
                                <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></li>
                                <li class="list-group-item"><strong>Price:</strong> <?php echo htmlspecialchars($price); ?></li>
                                <li class="list-group-item"><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($description)); ?></li>
                            </ul>
                            <a href="form_input.php" class="btn btn-primary">Add Another</a>
                        <?php endif; ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../Sesi1/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
