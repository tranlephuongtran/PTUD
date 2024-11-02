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
					<h1>Cart</h1>
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
							<tr>
								<td class="product-thumbnail">
									<img src="images/CayCamNgotCuaToi.png" style="width: 120px;height: 160px;"
										alt="Image" class="img-fluid">
								</td>
								<td class="product-name">
									<h2 class="h5 text-black">Cây Cam Ngọt Của Tôi</h2>
								</td>
								<td>17.000 VND</td>
								<td>
									<div class="input-group mb-3 d-flex align-items-center quantity-container"
										style="max-width: 120px;">
										<div class="input-group-prepend">
											<button class="btn btn-outline-black decrease"
												type="button">&minus;</button>
										</div>
										<input type="text" class="form-control text-center quantity-amount" value="1"
											placeholder="" aria-label="Example text with button addon"
											aria-describedby="button-addon1">
										<div class="input-group-append">
											<button class="btn btn-outline-black increase" type="button">&plus;</button>
										</div>
									</div>

								</td>
								<td>102.000 VND</td>
								<td><a href="#" class="btn btn-black btn-sm"><button>Xóa</button></a></td>
							</tr>

							<tr>
								<td class="product-thumbnail">
									<img src="images/KhongGiaDinh.png" style="width: 120px;height: 160px;" alt=" Image"
										class="img-fluid">
								</td>
								<td class="product-name">
									<h2 class="h5 text-black">Không Gia Đình</h2>
								</td>
								<td>35.000 VND</td>
								<td>
									<div class="input-group mb-3 d-flex align-items-center quantity-container"
										style="max-width: 120px;">
										<div class="input-group-prepend">
											<button class="btn btn-outline-black decrease"
												type="button">&minus;</button>
										</div>
										<input type="text" class="form-control text-center quantity-amount" value="1"
											placeholder="" aria-label="Example text with button addon"
											aria-describedby="button-addon1">
										<div class="input-group-append">
											<button class="btn btn-outline-black increase" type="button">&plus;</button>
										</div>
									</div>

								</td>
								<td>210.000 VND</td>
								<td><a href="#" class="btn btn-black btn-sm"><button>Xóa</button></a></td>
							</tr>
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
							<div class="col-md-6">
								<span class="text-black">Tổng tiền cọc</span>
							</div>
							<div class="col-md-6 text-right">
								<strong class="text-black">312.000 VND</strong>
							</div>
						</div>
						<div class="row mb-5">
							<div class="col-md-6">
								<span class="text-black">Tổng tiền thuê</span>
							</div>
							<div class="col-md-6 text-right">
								<strong class="text-black">52.000 VND</strong>
							</div>
						</div>
						<div class="row mb-5">
							<div class="col-md-6">
								<span class="text-black"><b>TỔNG TIỀN PHẢI TRẢ</b></span>
							</div>
							<div class="col-md-6 text-right">
								<strong class="text-black">364.000 VND</strong>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-black btn-lg py-3 btn-block"
									onclick="window.location='checkout.php'">THUÊ SÁCH</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
include('footer.php')
	?>


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>