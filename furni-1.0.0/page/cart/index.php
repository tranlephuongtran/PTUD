<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">
<?php
if (!isset($_GET['cart'])) {
	$cart = 1;
} else {
	$cart = $_GET['cart'];
}
?>
<?php
if (isset($_POST['remove'])) {
	$id_to_remove = $_POST['remove'];
	foreach ($_SESSION['cart'] as $key => $cart_item) {
		if ($cart_item['id'] == $id_to_remove) {
			unset($_SESSION['cart'][$key]);
			break; // Thoát khỏi vòng lặp sau khi đã xóa
		}
	}
}

// Tính toán lại tổng tiền
$total_deposit = 0;
$total_rent = 0;
foreach ($_SESSION['cart'] as $cart_item) {
	$total_deposit += $cart_item['deposit'];
	$total_rent += $cart_item['price'];
}
?>
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>Giỏ hàng</h1>
				</div>
			</div>
			<div class="col-lg-7">
			</div>
		</div>
	</div>
</div>

<div class="untree_co-section before-footer-section">
	<div class="container">
		<div class="row mb-5">
			<form class="col-md-12" method="post">
				<div class="site-blocks-table">
					<table class="table">
						<thead>
							<tr>
								<th class="product-thumbnail">Hình Ảnh</th>
								<th class="product-name">Tên Sách</th>
								<th class="product-price">Giá Thuê</th>
								<th class="product-quantity">Số lượng</th>
								<th class="product-total">Tiền cọc</th>
								<th class="product-remove">Thao tác</th>
							</tr>
						</thead>
						<tbody style="font-size: larger">
							<?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
								<?php foreach ($_SESSION['cart'] as $cart_item): ?>
									<tr>
										<td class="product-thumbnail">
											<img src="layout/images/<?php echo htmlspecialchars($cart_item['image']); ?>"
												style="width: 120px;height: 160px;" alt="Image" class="img-fluid">
										</td>
										<td class="product-name">
											<h2 class="h5 text-black mt-2"><?php echo htmlspecialchars($cart_item['name']); ?>
											</h2>
										</td>
										<td><span
												class="product-price"><?php echo number_format($cart_item['price'], 0, '.', '.'); ?>
												VND</span></td>
										<td>
											<input type="number" class="form-control quantity-input"
												value="<?php echo $cart_item['quantity']; ?>" min="1"
												data-price="<?php echo $cart_item['price']; ?>"
												data-deposit="<?php echo $cart_item['deposit']; ?>"
												data-id="<?php echo $cart_item['id']; ?>" onchange="updateCart(this)">
										</td>
										<td><span
												class="deposit-display"><?php echo number_format($cart_item['deposit'], 0, '.', '.'); ?>
												VND</span></td>
										<td>
											<button type="submit" name="remove" value="<?php echo $cart_item['id']; ?>"
												class="btn btn-black btn-sm"
												style="border-radius: 7px; width: 60px;height: 30px; font-size: large">Xóa</button>

										</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="6" class="text-center">Giỏ hàng trống</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>

		<div class="row">
			<div class="col-md-6">
				<!-- Empty column for layout -->
			</div>
			<div class="col-md-6 pl-5">
				<div class="row justify-content-end">
					<div class="col-md-7">
						<div class="row">
							<div class="col-md-12 text-right border-bottom mb-5">
								<h3 class="text-black h4 text-uppercase">Tổng</h3>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-7">
								<span class="text-black">Tổng tiền cọc</span>
							</div>
							<div class="col-md-5" style="text-align: right;">
								<strong class="text-black"
									id="total-deposit"><?php echo number_format($total_deposit, 0, '.', '.'); ?>
									VND</strong>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-7">
								<span class="text-black">Tổng tiền thuê</span>
							</div>
							<div class="col-md-5" style="text-align: right;">
								<strong class="text-black"
									id="total-rent"><?php echo number_format($total_rent, 0, '.', '.'); ?> VND</strong>
							</div>
						</div>
						<div class="row mb-5">
							<div class="col-md-7">
								<span class="text-black"><b>TỔNG TIỀN THANH TOÁN</b></span>
							</div>
							<div class="col-md-5" style="text-align: right;">
								<strong class="text-black"
									id="total-payment"><?php echo number_format($total_deposit, 0, '.', '.'); ?>
									VND</strong>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-black btn-lg py-3 btn-block"
									onclick="window.location='index.php?checkout'">THUÊ SÁCH</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function updateCart(input) {
		const quantity = parseInt(input.value);
		const price = parseInt(input.getAttribute('data-price'));
		const deposit = parseInt(input.getAttribute('data-deposit'));
		const itemId = input.getAttribute('data-id');

		// Calculate new rent and deposit values
		const newRent = price * quantity;
		const newDeposit = deposit * quantity;

		// Update the display for this item
		const row = input.closest('tr');
		row.querySelector('.deposit-display').textContent = newDeposit.toLocaleString() + " VND";
		row.querySelector('.product-price').textContent = newRent.toLocaleString() + " VND";
		// Update total rent and deposit globally
		let totalRent = 0;
		let totalDeposit = 0;
		document.querySelectorAll('.quantity-input').forEach(function (input) {
			const rowPrice = parseInt(input.getAttribute('data-price'));
			const rowDeposit = parseInt(input.getAttribute('data-deposit'));
			const rowQuantity = parseInt(input.value);
			totalRent += rowPrice * rowQuantity;
			totalDeposit += rowDeposit * rowQuantity;
		});

		// Update total values on the page
		document.getElementById('total-deposit').textContent = totalDeposit.toLocaleString() + " VND";
		document.getElementById('total-rent').textContent = totalRent.toLocaleString() + " VND";
		document.getElementById('total-payment').textContent = totalDeposit.toLocaleString() + " VND";
	}
</script>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>