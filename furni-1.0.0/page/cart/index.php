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
$total_deposit = 0;
$total_rent = 0;
foreach ($_SESSION['cart'] as $cart_item) {
    $total_deposit += $cart_item['deposit'];
    $total_rent += $cart_item['price'];
}
?>
<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>Giỏ hàng</h1>
				</div>
			</div>
			<div class="col-lg-7">

			</div>
		</div>
	</div>
</div>
<!-- End Hero Section -->



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
											<img src="layout/images/<?php echo htmlspecialchars($cart_item['image']); ?>" style="width: 120px;height: 160px;" alt="Image" class="img-fluid">
										</td>
										<td class="product-name">
											<h2 class="h5 text-black mt-2"><?php echo htmlspecialchars($cart_item['name']); ?></h2>
										</td>
										<td><?php echo number_format($cart_item['price'], 0, '.', '.'); ?> VND</td>
										<td>
											<div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;margin-left: 35px;">
												<?php echo $cart_item['quantity']; ?>
											</div>
										</td>
										<td><?php echo number_format($cart_item['deposit'], 0, '.', '.'); ?> VND</td>
										<td>
											<a href="cart/index.php?remove=<?php echo $cart_item['id']; ?>" class="btn btn-black btn-sm">
												<button style="border-radius: 7px; width: 60px;height: 30px;">Xóa</button>
											</a>
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
				<!-- TRỐNG ND-->
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
						<div class="row mb-3">
							<div class="col-md-7">
								<span class="text-black">Tổng tiền cọc</span>
							</div>
							<div class="col-md-5" style="text-align: right;">
								<strong class="text-black"><?php echo number_format($total_deposit, 0, '.', '.'); ?> VND</strong>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-7">
								<span class="text-black">Tổng tiền thuê</span>
							</div>
							<div class="col-md-5" style="text-align: right;">
								<strong class="text-black"><?php echo number_format($total_rent, 0, '.', '.'); ?> VND</strong>
							</div>
						</div>
						<div class="row mb-5">
							<div class="col-md-7">
								<span class="text-black"><b>TỔNG TIỀN PHẢI TRẢ</b></span>
							</div>
							<div class="col-md-5" style="text-align: right;">
								<strong class="text-black"><?php echo number_format($total_deposit + $total_rent, 0, '.', '.'); ?> VND</strong>
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




<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>