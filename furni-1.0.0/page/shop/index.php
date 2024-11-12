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
if (!isset($_GET['shop'])) {
	$shop = 1;
} else {
	$shop = $_GET['shop'];
}
?>

<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>Sản Phẩm</h1>
				</div>
			</div>
			<div class="col-lg-7">

			</div>
		</div>
	</div>
</div>
<!-- End Hero Section -->



<div class="untree_co-section product-section before-footer-section">
	<div class="container">
		<div class="row">

			<!-- Start Column 1 -->
			<div class="col-12 col-md-4 col-lg-3 mb-5">
				<div class="product-item" onclick="window.location='productdetails.php'">
					<img src="layout/images/CayCamNgotCuaToi.png" class="img-fluid product-thumbnail">
					<h3 class="product-title">Cây Cam Ngọt của Tôi</h3>
					<strong class="product-price">17.000 VND</strong>

					<span class="icon-cross">
						<img src="layout/images/cross.svg" class="img-fluid">
					</span>
				</div>
			</div>
			<!-- End Column 1 -->
			<div class="col-12 col-md-4 col-lg-3 mb-5">
				<div class="product-item" onclick="window.location='productdetails.php'">
					<img src="layout/images/KhongGiaDinh.png" class="img-fluid product-thumbnail">
					<h3 class="product-title">Không Gia Đình</h3>
					<strong class="product-price">35.000 VND</strong>

					<span class="icon-cross">
						<img src="layout/images/cross.svg" class="img-fluid">
					</span>
				</div>
			</div>
			<!-- End Column 4 -->



			<!-- End Column 4 -->

		</div>
	</div>
</div>


<!-- End Footer Section -->


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>
</body>

</html>