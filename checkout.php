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
include('header.php')
	?>

<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>Checkout</h1>
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
							<th>Mã Sách</th>
							<th>Tên Sách</th>
							<th>Số Lượng</th>
							<th>Giá Thuê</th>
							<th style="text-align: left;">Tiền Cọc</th>

						</thead>
						<tbody>
							<tr>
								<td>TT001</td>
								<td>Cây Cam Ngọt CỦa Tôi</td>
								<td style="text-align: center;"><strong>1</strong></td>
								<td>17.000 VND</td>
								<td style="text-align: right;">102.000 VND</td>
							</tr>
							<tr>
								<td>KD001</td>
								<td>Không Gia Đình </td>
								<td style="text-align: center;"><strong>1</strong></td>
								<td>35.000 VND</td>
								<td style="text-align: right;">210.000 VND</td>
							</tr>



						</tbody>
					</table>




				</div>
			</div>
			<div class="col-md-5git">
				<!-- <div class="row mb-5">
					<div class="col-md-12">
						<h2 class="h3 mb-3 text-black">Coupon Code</h2>
						<div class="p-3 p-lg-5 border bg-white">

							<label for="c_code" class="text-black mb-3">Enter your coupon code if you have one</label>
							<div class="input-group w-75 couponcode-wrap">
								<input type="text" class="form-control me-2" id="c_code" placeholder="Coupon Code"
									aria-label="Coupon Code" aria-describedby="button-addon2">
								<div class="input-group-append">
									<button class="btn btn-black btn-sm" type="button" id="button-addon2">Apply</button>
								</div>
							</div>

						</div>
					</div>
				</div> -->
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
											<select id="cars" name="cars"
												style="border-radius: 10px;width: 200px;height: 30px;">
												<option value="0">Vui lòng chọn</option>
												<option value="1">Khuyến mãi 10%</option>
												<option value="2">Khuyến mãi 10%</option>
												<option value="3">Khuyến mãi 10%</option>
												<option value="4">Khuyến mãi 10%</option>
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
												<td class="text-black font-weight-bold"><strong>Tổng Tiền Cọc</strong>
												</td>
												<td class="text-black" style="text-align: right;">312.000 VND</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Tổng Tiền Thuê</strong>
												</td>
												<td class="text-black" style="text-align: right;">52.000 VND</td>
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
												<td class="text-black" style="text-align: right;">- 10.000 VND</td>
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
									onclick="window.location='thankyou.html'">Thuê Sách</button>
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
<?php
include('footer.php')
	?>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>