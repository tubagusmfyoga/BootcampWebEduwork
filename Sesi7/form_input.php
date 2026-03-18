<?php
// Simple product input form with basic POST handling and validation
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
	}
	if ($stock === '') {
		$errors[] = 'Stock is required.';
	} elseif (!is_numeric($stock)) {
		$errors[] = 'Stock must be a number.';
	} elseif ($stock < 0) {
		$errors[] = 'Stock cannot be negative.';
	}

	if ($category === '') {
		$errors[] = 'Category is required.';
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
	<title>Input Product</title>
	<link rel="stylesheet" href="../Sesi1/bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body">
					<h3 class="card-title mb-4">Input New Product</h3>

					<?php if (!empty($errors)): ?>
						<div class="alert alert-danger">
							<ul class="mb-0">
								<?php foreach ($errors as $e): ?>
									<li><?php echo htmlspecialchars($e); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

					<?php if ($success): ?>
						<div class="alert alert-success">
							Product added successfully (demo). Below are the submitted values:
						</div>
						<ul class="list-group mb-4">
							<li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></li>
							<li class="list-group-item"><strong>Price:</strong> <?php echo htmlspecialchars($price); ?></li>
							<li class="list-group-item"><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($description)); ?></li>
							<li class="list-group-item"><strong>Category:</strong> <?php echo htmlspecialchars($category); ?></li>
							<li class="list-group-item"><strong>Stock:</strong> <?php echo htmlspecialchars($stock); ?></li>	
						</ul>
					<?php endif; ?>

					<form method="post" action="form_valid.php" id="productForm" novalidate>
						<div class="mb-3">
							<label for="name" class="form-label">Product Name</label>
							<input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
							<div class="invalid-feedback" id="nameFeedback"></div>
						</div>

						<div class="mb-3">
							<label for="price" class="form-label">Price</label>
							<input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>">
							<div class="invalid-feedback" id="priceFeedback"></div>
						</div>

						<div class="mb-3">
							<label for="description" class="form-label">Description</label>
							<textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($description); ?></textarea>
						</div>
						<!-- CATEGORY -->
						<div class="mb-3">
							<label class="form-label">Category</label>
							<select class="form-select" name="category" id="category">
								<option value="">-- Select Category --</option>
								<option value="Elektronik" <?= $category=='Elektronik'?'selected':'' ?>>Elektronik</option>
								<option value="Fashion" <?= $category=='Fashion'?'selected':'' ?>>Fashion</option>
								<option value="Home" <?= $category=='Home'?'selected':'' ?>>Home</option>
								<option value="Beauty" <?= $category=='Beauty'?'selected':'' ?>>Beauty</option>
							</select>
							<div class="invalid-feedback" id="categoryFeedback"></div>
						</div>

						<!-- STOCK -->
						<div class="mb-3">
							<label class="form-label">Stock</label>
							<input type="number" class="form-control" id="stock" name="stock" value="<?= htmlspecialchars($stock); ?>">
							<div class="invalid-feedback" id="stockFeedback"></div>
						</div>
						<div class="d-flex justify-content-between">
							<button type="submit" class="btn btn-primary">Add Product</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
	const form = document.getElementById('productForm');

	const name = document.getElementById('name');
	const price = document.getElementById('price');
	const stock = document.getElementById('stock');
	const category = document.getElementById('category');

	function setError(el, msg){
		el.classList.add('is-invalid');
		document.getElementById(el.id + 'Feedback').textContent = msg;
	}
	function clearError(el){
		el.classList.remove('is-invalid');
		document.getElementById(el.id + 'Feedback').textContent = '';
	}

	form.addEventListener('submit', function(e){
		e.preventDefault();
		let valid = true;

		[name, price, stock, category].forEach(clearError);

		if (name.value.trim() === '') {
			setError(name, 'Product name is required.');
			valid = false;
		}

		if (price.value.trim() === '' || isNaN(price.value)) {
			setError(price, 'Price must be a valid number.');
			valid = false;
		}

		if (stock.value.trim() === '') {
			setError(stock, 'Stock is required.');
			valid = false;
		} else if (isNaN(stock.value) || Number(stock.value) < 0) {
			setError(stock, 'Stock must be positive number.');
			valid = false;
		}

		if (category.value === '') {
			setError(category, 'Category is required.');
			valid = false;
		}

		if (valid) form.submit();
	});
});
</script>
<script src="../Sesi1/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

