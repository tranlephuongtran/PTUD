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
if (!isset($_GET['checkout'])) {
	$checkout = 1;
} else {
	$checkout = $_GET['checkout'];
}
$khuyenMai = $_SESSION['total_rent'];
$total_deposit = number_format($_SESSION['total_deposit'], 0, ',', ',') ?? 0;
$total_rent = number_format($_SESSION['total_rent'], 0, ',', ',') ?? 0;
?>

<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>Xác nhận hóa đơn</h1>
				</div>
			</div>
			<div class="col-lg-7">

			</div>
		</div>
	</div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section">
	<div class="container">
		<div class="row">
			<div class="col-md-7 mb-5 mb-md-0">
				<h2 class="h3 mb-3 text-black">THÔNG TIN ĐƠN HÀNG</h2>
				<div class="p-3 p-lg-5 border bg-white">
					<table class="table site-block-order-table mb-5">
						<thead>
							<th>Mã Đầu Sách</th>
							<th>Tên Sách</th>
							<th>Số Lượng</th>
							<th>Giá Thuê</th>
							<th style="text-align: left;">Tiền Cọc</th>

						</thead>
						<tbody>
							<?php
							foreach ($_SESSION['cart'] as $item) {
								$price = number_format($item['price'] * $item['quantity'], 0, ',', ',');
								$deposit = number_format($item['deposit'] * $item['quantity'], 0, ',', ',');
								echo "<tr>
								<td>{$item['id']}</td>
								<td>{$item['name']}</td>
								<td style='text-align: center;'><strong>{$item['quantity']}</strong></td>
								<td>{$price}</td>
								<td style='text-align: right;'>{$deposit} VND</td>
							</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-5">
				<div class="row mb-5">
					<div class="col-md-12">
						<h2 class="h3 mb-3 text-black">TỔNG HÓA ĐƠN</h2>
						<div class=" p-5 border bg-white">
							<div class="border mb-3">
								<table class="table">
									<tbody>
										<td>
											<label class="text-black font-weight-bold" for="cars">
												<b>Áp dụng Khuyến Mãi</b>
											</label>
										</td>
										<td style="text-align: right;">
											<select name="km" style="border-radius: 10px;width: 200px;height: 30px;">
												<option value="0">Vui lòng chọn</option>
												<?php
												$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
												if ($conn) {
													$str = "SELECT *FROM khuyenmai";
													$result = $conn->query($str);
													if (mysqli_num_rows($result) > 0) {
														while ($row = mysqli_fetch_assoc($result)) {
															echo "<option value='{$row['phanTramKM']}'>{$row['tenKM']}</option>";
														}
													}
												}
												?>
											</select>
										</td>
									</tbody>


								</table>
							</div>
							<div class="border  mb-3">
								<div class="col-md-12">
									<table class="table site-block-order-table mb-5">
										<tbody>
											<tr>
												<td class="text-black font-weight-bold"><strong>Tổng Tiền Thuê</strong>
												</td>
												<td class="text-black" style="text-align: right;">
													<?php echo $total_rent ?> VND
												</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Tổng Tiền Cọc</strong>
												</td>
												<td class="text-black" style="text-align: right;">
													<?php echo $total_deposit ?> VND
												</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Ưu Đãi Thành
														Viên</strong>
												</td>
												<td class="text-black font-weight-bold" style="text-align: right;">-
													5.200
													VND
												</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Khuyến Mãi</strong></td>
												<td class="text-black" style="text-align: right;">-
													<?php echo $khuyenMai ?> VND
												</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Tổng Tiền Thuê Sau Ưu
														Đãi</strong>
												</td>
												<td class="text-black" style="text-align: right;">36.800 VND</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Phí Ship</strong>
												</td>
												<td class="text-black" style="text-align: right;">30.000 VND</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Tổng Tiền Cọc Thanh
														Toán</strong>
												</td>
												<td class="text-black" style="text-align: right;"><strong>378.800
														VND</strong>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>


							<div class="form-group">
								<button class="btn btn-black btn-lg py-3 btn-block"
									onclick="window.location='index.php?confirmpayment'">Xác nhận</button>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- </form> -->
</div>
</div>


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>