<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">
<style>
	a {
		text-decoration: none;
	}
</style>
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
			<?php
			$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
			if ($conn) {
				$str = "SELECT *FROM dausach d Join sach s on d.maDauSach = s.maDauSach GROUP BY d.maDauSach";
				$result = $conn->query($str);
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						$gia = number_format($row['giaThue'], 0, '.', '.');

						echo "<div class='col-12 col-md-4 col-lg-3 mb-5'>
						<a href = 'index.php?product={$row['maDauSach']}'>
				<div class='product-item'>
					<img src='layout/images/{$row['hinhAnh']}' class='img-fluid product-thumbnail'>
					<h3 class='product-title'>{$row['tenDauSach']}</h3>
					<strong class='product-price'>$gia VND</strong>

					<span class='icon-cross'>
						<img src='layout/images/cross.svg' class='img-fluid'>
					</span>
				</div>
			</div></a>";
					}
				}
			}
			?>


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