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
error_reporting(E_ERROR | E_PARSE);

if (!isset($_SESSION['cart'])) {
	$_SESSION['cart'] = []; // Khởi tạo giỏ hàng nếu chưa có
}

// Xử lý xóa sản phẩm
if (isset($_POST['remove'])) {
	$id_to_remove = $_POST['remove'];
	foreach ($_SESSION['cart'] as $key => $cart_item) {
		if ($cart_item['id'] == $id_to_remove) {
			unset($_SESSION['cart'][$key]);
			break;
		}
	}
}
// Xử lý cập nhật số lượng sản phẩm
if (isset($_POST['quantity'])) {
	$id_to_update = $_POST['id'];
	$new_quantity = $_POST['quantity'];
	foreach ($_SESSION['cart'] as $key => $cart_item) {
		if ($cart_item['id'] == $id_to_update) {
			$str = "SELECT tongSoLuong, soLuongDangThue FROM dausach WHERE maDauSach = $id_to_update";
			$result = $conn->query($str);
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$soLuongConLai = $row['tongSoLuong'] - $row['soLuongDangThue'];
					if ($new_quantity > $soLuongConLai) {
						echo "<script>alert('Không đủ số lượng sách! Chỉ còn {$soLuongConLai} quyển')</script>";
					} else {
						$_SESSION['cart'][$key]['quantity'] = $new_quantity;
						break;
					}
				}
			}
		}
	}
	$total_deposit = 0;
	$total_rent = 0;
	foreach ($_SESSION['cart'] as $cart_item) {
		$total_deposit += $cart_item['deposit'] * $cart_item['quantity'];
		$total_rent += $cart_item['price'] * $cart_item['quantity'];
	}
	$_SESSION['total_deposit'] = $total_deposit;
	$_SESSION['total_rent'] = $total_rent;
}

// Tính toán lại tổng tiền
$total_deposit = 0;
$total_rent = 0;
foreach ($_SESSION['cart'] as $cart_item) {
	$total_deposit += $cart_item['deposit'] * $cart_item['quantity'];
	$total_rent += $cart_item['price'] * $cart_item['quantity'];
}
if (isset($_POST['checkout'])) {
	$_SESSION['total_deposit'] = $total_deposit; // Lưu tổng tiền cọc
	$_SESSION['total_rent'] = $total_rent; // Lưu tổng tiền thuê
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
								<th class="product-quantity">Số lượng</th>
								<th class="product-price">Giá Thuê</th>
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
												style="width: 170px;height: 160px;" alt="Image" class="img-fluid">
										</td>
										<td class="product-name">
											<h2 class="h5 text-black mt-2">
												<?php echo htmlspecialchars($cart_item['name']); ?>
											</h2>
										</td>
										<td>
											<form method="post" class="quantity-form">
												<input type="hidden" name="id" value="<?php echo $cart_item['id']; ?>">
												<input type="number" class="form-control quantity-input" name="quantity"
													style="width: 100px; text-align: center; position: relative; left: 20px"
													value="<?php echo $cart_item['quantity']; ?>" min="1">
												<button type="submit" class="btn btn-primary btn-sm"
													style="position: relative; left:15px">Cập nhật</button>
											</form>
										</td>
										<td><span
												class="product-price"><?php echo number_format($cart_item['price'] * $cart_item['quantity'], 0, '.', '.'); ?>
												VND</span>
										</td>
										<td><span
												class="deposit-display"><?php echo number_format($cart_item['deposit'] * $cart_item['quantity'], 0, '.', '.'); ?>
												VND
											</span>
										</td>
										<td>
											<button type="submit" name="remove" value="<?php echo $cart_item['id']; ?>"
												class="btn btn-black btn-sm"
												style="border-radius: 7px; width: 60px; height: 30px; font-size: large">Xóa</button>

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
								<strong class="text-black" id="total-deposit"><?php $_SESSION['total_deposit'] = $total_deposit;
								echo number_format($total_deposit, 0, '.', '.'); ?>
									VND</strong>
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md-7">
								<span class="text-black">Tổng tiền thuê</span>
							</div>
							<div class="col-md-5" style="text-align: right;">
								<strong class="text-black" id="total-rent"><?php $_SESSION['total_rent'] = $total_rent;
								echo number_format($total_rent, 0, '.', '.'); ?>
									VND</strong>
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
						<!-- Button for Checkout -->
						<!-- Button for Checkout -->
						<div class="row">
							<div class="col-md-12">
								<form method="post" action="">
									<button type="submit" class="btn btn-lg py-3 btn-block" name="checkout"
										style="background-color: #a76d49; color: white !important;">THUÊ SÁCH</button>
								</form>
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

<?php
if (isset($_POST['checkout'])) {
	foreach ($_SESSION['cart'] as $key => $cart_item) {
		$str = "SELECT tongSoLuong, soLuongDangThue FROM dausach WHERE maDauSach = {$cart_item['id']}";
		$result = $conn->query($str);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$soLuongConLai = $row['tongSoLuong'] - $row['soLuongDangThue'];
				if ($cart_item['quantity'] > $soLuongConLai) {
					echo "<script>alert('Không đủ số lượng! Sách {$cart_item['name']} chỉ còn {$soLuongConLai} quyển')</script>";
				} else {
					header("Location: index.php?checkout");
				}
			}
		}
	}

}
?>