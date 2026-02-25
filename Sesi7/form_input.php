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

						<div class="d-flex justify-content-between">
							<button type="submit" class="btn btn-primary">Add Product</button>
							<button type="reset" class="btn btn-secondary">Reset</button>
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
	const nameInput = document.getElementById('name');
	const priceInput = document.getElementById('price');
	const nameFeedback = document.getElementById('nameFeedback');
	const priceFeedback = document.getElementById('priceFeedback');

	function clearFieldError(el, fb){
		el.classList.remove('is-invalid');
		fb.textContent = '';
	}
	function setFieldError(el, fb, msg){
		el.classList.add('is-invalid');
		fb.textContent = msg;
	}

	form.addEventListener('submit', function(e){
		e.preventDefault();
		let hasError = false;
		clearFieldError(nameInput, nameFeedback);
		clearFieldError(priceInput, priceFeedback);

		const name = nameInput.value.trim();
		const price = priceInput.value.trim();

		if (!name) {
			setFieldError(nameInput, nameFeedback, 'Product name is required.');
			hasError = true;
		}

		if (price === '') {
			setFieldError(priceInput, priceFeedback, 'Price is required.');
			hasError = true;
		} else if (isNaN(price) || !isFinite(price)) {
			setFieldError(priceInput, priceFeedback, 'Price must be a valid number.');
			hasError = true;
		} else if (Number(price) < 0) {
			setFieldError(priceInput, priceFeedback, 'Price cannot be negative.');
			hasError = true;
		}

		if (!hasError) {
			form.submit();
		} else {
			const firstInvalid = form.querySelector('.is-invalid');
			if (firstInvalid) firstInvalid.focus();
		}
	});

	[nameInput, priceInput].forEach(function(el){
		el.addEventListener('input', function(){
			const fb = document.getElementById(el.id + 'Feedback');
			clearFieldError(el, fb);
		});
	});

	form.addEventListener('reset', function(){
		// run after reset clears values
		setTimeout(function(){
			[nameInput, priceInput].forEach(function(el){
				const fb = document.getElementById(el.id + 'Feedback');
				clearFieldError(el, fb);
			});
		}, 0);
	});
});
</script>
<script src="../Sesi1/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

