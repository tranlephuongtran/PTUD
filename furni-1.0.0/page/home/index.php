<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<style>
	.testimonial-section {
		padding: 3rem 0 7rem 0;
	}

	.testimonial-slider-wrap {
		position: relative;
	}

	.testimonial-slider-wrap .tns-inner {
		padding-top: 30px;
	}

	.testimonial-slider-wrap .item .testimonial-block blockquote {
		font-size: 16px;
	}

	@media (min-width: 768px) {
		.testimonial-slider-wrap .item .testimonial-block blockquote {
			line-height: 32px;
			font-size: 18px;
		}
	}

	.testimonial-slider-wrap .item .testimonial-block .author-info .author-pic {
		margin-bottom: 20px;
	}

	.testimonial-slider-wrap .item .testimonial-block .author-info .author-pic img {
		width: 90px;
		height: 90px;
		border-radius: 50%;
	}

	.testimonial-slider-wrap .item .testimonial-block .author-info h3 {
		font-size: 14px;
		font-weight: 700;
		color: #2f2f2f;
		margin-bottom: 0;
	}

	.testimonial-slider-wrap #testimonial-nav {
		position: absolute;
		top: 50%;
		z-index: 99;
		width: 100%;
		display: none;
	}

	@media (min-width: 768px) {
		.testimonial-slider-wrap #testimonial-nav {
			display: block;
		}
	}

	.testimonial-slider-wrap #testimonial-nav>span {
		cursor: pointer;
		position: absolute;
		width: 58px;
		height: 58px;
		line-height: 58px;
		border-radius: 50%;
		background: rgba(59, 93, 80, 0.1);
		color: #2f2f2f;
		-webkit-transition: 0.3s all ease;
		-o-transition: 0.3s all ease;
		transition: 0.3s all ease;
	}

	.testimonial-slider-wrap #testimonial-nav>span:hover {
		/* background: #3b5d50; */
		background: #a76d49;
		color: #ffffff;
	}

	.testimonial-slider-wrap #testimonial-nav span .fa-chevron-left,
	.testimonial-slider-wrap #testimonial-nav span .fa-chevron-right {
		line-height: 3.4;
	}

	.testimonial-slider-wrap #testimonial-nav .prev {
		left: -10px;
	}

	.testimonial-slider-wrap #testimonial-nav .next {
		right: 0;
	}

	.testimonial-slider-wrap .tns-nav {
		position: absolute;
		bottom: -50px;
		left: 50%;
		-webkit-transform: translateX(-50%);
		-ms-transform: translateX(-50%);
		transform: translateX(-50%);
	}

	.testimonial-slider-wrap .tns-nav button {
		background: none;
		border: none;
		display: inline-block;
		position: relative;
		width: 0 !important;
		height: 7px !important;
		margin: 2px;
	}

	.testimonial-slider-wrap .tns-nav button:active,
	.testimonial-slider-wrap .tns-nav button:focus,
	.testimonial-slider-wrap .tns-nav button:hover {
		outline: none;
		-webkit-box-shadow: none;
		box-shadow: none;
		background: none;
	}

	.testimonial-slider-wrap .tns-nav button:before {
		display: block;
		width: 7px;
		height: 7px;
		left: 0;
		top: 0;
		position: absolute;
		content: "";
		border-radius: 50%;
		-webkit-transition: 0.3s all ease;
		-o-transition: 0.3s all ease;
		transition: 0.3s all ease;
		background-color: #d6d6d6;
	}

	.testimonial-slider-wrap .tns-nav button:hover:before,
	.testimonial-slider-wrap .tns-nav button.tns-nav-active:before {
		background-color: #a76d49;
	}
</style>
<?php
require_once 'myclass/products.php';

$product = new Product();
$result = $product->getHighlightedBooks();
$resultVrB = $product->getViralBooks();
$resultDmB = $product->getDemoBooks();
?>

<!doctype html>
<html lang="en">
<?php
if (!isset($_GET['home'])) {
	$home = 1;
} else {
	$home = $_GET['home'];
}
?>

<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row "> <!-- justify-content-between -->
			<div class="col-lg-5"> <!-- Cập nhật lại Tiếng Việt  -->
				<div class="intro-excerpt">
					<h1>Thế Giới Sách <span clsas="d-block">Của Bạn</span></h1>
					<p class="mb-4">Khám phá hàng ngàn cuốn sách hấp dẫn từ mọi thể loại, giúp bạn mở rộng kiến thức và
						khơi nguồn cảm hứng.</p>
					<p><a href="" class="btn btn-secondary me-2">Mua Ngay</a><a href="#"
							class="btn btn-white-outline">Khám Phá</a></p>
				</div>
			</div>

			<div class="col-lg-7">
				<div class="hero books-slider">
					<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-inner">
							<div class="carousel-item active">
								<a href="#" class="swiper-slide"><img src="layout/images/book1.png" alt=""></a>
								<a href="#" class="swiper-slide"><img src="layout/images/book2.png" alt=""></a>
								<a href="#" class="swiper-slide"><img src="layout/images/book3.png" alt=""></a>
							</div>

							<div class="carousel-item">
								<a href="#" class="swiper-slide"><img src="layout/images/book4.png" alt=""></a>
								<a href="#" class="swiper-slide"><img src="layout/images/book5.png" alt=""></a>
								<a href="#" class="swiper-slide"><img src="layout/images/book6.png" alt=""></a>
							</div>

						</div>
					</div>
					<img src="layout/images/stand.png" class="stand" alt="">
				</div>
			</div>
			<!-- <div class="hero books-slider">
				<div class="swiper-wrapper">
					<a href="#" class="swiper-slide"><img src="images/book1.png" alt=""></a>
					<a href="#" class="swiper-slide"><img src="images/book2.png" alt=""></a>
					<a href="#" class="swiper-slide"><img src="images/book3.png" alt=""></a>
					<a href="#" class="swiper-slide"><img src="images/book4.png" alt=""></a>
					<a href="#" class="swiper-slide"><img src="images/book5.png" alt=""></a>
					<a href="#" class="swiper-slide"><img src="images/book6.png" alt=""></a>
				</div>
				<img src="images/stand.png" class="stand" alt="">
			</div> -->
		</div>
	</div>
</div>
<!-- End Hero Section

<!- Start Product Section -->
<div class="product-section">
	<div class="container">
		<div class="row">
			<!-- Sửa lại Tiếng Việt và tinh chỉnh vài chi tiết -->
			<!-- Start Column 1 -->
			<div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
				<h2 class="mb-4 section-title">Sách chất lượng, đọc thả ga.</h2>
				<p class="mb-4">Thư viện với hàng ngàn đầu sách đa dạng thể loại, từ văn học kinh điển đến truyện tranh
					hiện đại, đáp ứng mọi nhu cầu đọc của bạn. </p>
				<p><a href="index.php?shop" class="btn">Khám phá ngay</a></p>
			</div>
			<!-- End Column 1 -->

			<!-- Start Column 2 -->
			<div class="col-lg-9 col-md-8">
				<div class="carousel-container">
					<div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
						<div class="carousel-inner">
							<!-- Slide 1 with three products -->
							<div class="carousel-item active">
								<div class="row">
									<div class="col-md-4">
										<a class="product-item" href="cart.html">
											<img src="layout/images/book7.png" class="img-fluid product-thumbnail">
											<h3 class="product-title">Văn học</h3>
											<strong class="product-price">$12.00</strong>

											<span class="icon-cross">
												<img src="layout/images/cross.svg" class="img-fluid">
											</span>
										</a>
										<!-- End Column 2 -->
									</div>

									<!-- Start Column 3 -->
									<div class="col-md-4">
										<a class="product-item" href="cart.html">
											<img src="layout/images/book8.png" class="img-fluid product-thumbnail">
											<h3 class="product-title">Lịch Sử</h3>
											<strong class="product-price">$18.00</strong>

											<span class="icon-cross">
												<img src="layout/images/cross.svg" class="img-fluid">
											</span>
										</a>
										<!-- End Column 3 -->
									</div>

									<!-- Start Column 4 -->
									<div class="col-md-4">
										<a class="product-item" href="cart.html">
											<img src="layout/images/book9.png" class="img-fluid product-thumbnail">
											<h3 class="product-title">Âm Nhạc</h3>
											<strong class="product-price">$15.00</strong>

											<span class="icon-cross">
												<img src="layout/images/cross.svg" class="img-fluid">
											</span>
										</a>
										<!-- End Column 4 -->
									</div>
								</div>
							</div>
							<!-- Slide 2 with three more products -->
							<div class="carousel-item">
								<div class="row">
									<div class="col-md-4">
										<a class="product-item" href="cart.html">
											<img src="layout/images/book11.png" class="img-fluid product-thumbnail">
											<h3 class="product-title">Văn Thơ</h3>
											<strong class="product-price">$12.00</strong>

											<span class="icon-cross">
												<img src="layout/images/cross.svg" class="img-fluid">
											</span>
										</a>

									</div>

									<div class="col-md-4">
										<a class="product-item" href="cart.html">
											<img src="layout/images/book12.png" class="img-fluid product-thumbnail">
											<h3 class="product-title">Văn Thơ</h3>
											<strong class="product-price">$12.00</strong>

											<span class="icon-cross">
												<img src="layout/images/cross.svg" class="img-fluid">
											</span>
										</a>

									</div>

									<div class="col-md-4">
										<a class="product-item" href="cart.html">
											<img src="layout/images/book13.png" class="img-fluid product-thumbnail">
											<h3 class="product-title">Văn Thơ</h3>
											<strong class="product-price">$12.00</strong>

											<span class="icon-cross">
												<img src="layout/images/cross.svg" class="img-fluid">
											</span>
										</a>

									</div>
								</div>
							</div>
						</div>

						<!--Nút điều khiển trước (carousel-control-prev) & sau (carousel-control-next) -->
						<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide"
							data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide"
							data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Product Section -->

<!-- Start Why Choose Us Section -->
<div class="why-choose-section">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-6">
				<h2 class="section-title">Tại sao chọn chúng tôi</h2>
				<p>Đừng lo lắng, hãy chọn sự an toàn và chất lượng. Chúng tôi cam kết mang đến dịch vụ
					cho thuê sách tốt nhất với sự hài lòng của khách hàng là ưu tiên hàng đầu.</p>

				<div class="row my-5">
					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="layout/images/truck.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Fast &amp; Miễn Phí Vận Chuyển</h3>
							<p> Dành cho đơn hàng có giá trị lớn hơn 200k </p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="layout/images/bag.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Thanh toán an toàn</h3>
							<p> Thanh toán 100% an toàn </p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="layout/images/support.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Hỗ trợ 24/7</h3>
							<p> Gọi cho chúng tôi bất cứ lúc nào</p>
						</div>
					</div>

					<div class="col-6 col-md-6">
						<div class="feature">
							<div class="icon">
								<img src="layout/images/return.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Trả hàng dễ dàng</h3>
							<p> Trả hàng trong vòng 10 ngày </p>
						</div>
					</div>

				</div>
			</div>

			<div class="col-lg-5">
				<div class="img-wrap">
					<img src="layout/images/Bookshelf.jpg" alt="Image" class="img-fluid">
				</div>
			</div>

		</div>
	</div>
</div>
<!-- End Why Choose Us Section -->

<!-- Start Featured Books -->
<!-- <div class="we-help-section"> -->
<div class="container product-section">
	<div class="row">
		<div class="col-12">
			<span class="highlight-title">Sách Nổi Bật</span>
		</div>
		<?php
		if ($result->num_rows > 0) {
			// Output data of each row
			while ($row = $result->fetch_assoc()) {
				$formatted_price = number_format($row["giaThue"], 0, ',', '.') . ' VND';
				echo '<div class="col-md-3"> 
							<a class="product-item" href="cart.html"> 
								<img src="layout/images/' . $row["hinhAnh"] . '" class="img-fluid product-thumbnail"> 
								<div class="card-information">
									<h3 class="product-title">' . $row["tenDauSach"] . '</h3> 
									<strong class="product-price">' . $formatted_price . '</strong> 
									<span class="icon-cross"> 
										<img src="layout/images/cross.svg" class="img-fluid"> 
									</span> 
								</div>
							</a> 
						</div> ';
			}
		} else {
			echo 'Đang cập nhật sản phẩm';
		}
		?>
		<!-- <div class="col-md-3"> 
			<a class="product-item" href="cart.html"> 
				<img src="layout/images/book7.png" class="img-fluid product-thumbnail"> 
				<div class="card-information">
					<h3 class="product-title">Văn học</h3>
					<strong class="product-price">$12.00</strong>
					<span class="icon-cross">
						<img src="layout/images/cross.svg" class="img-fluid">
					</span>
				</div>
			</a> 
		</div> 
		<div class="col-md-3"> 
			<a class="product-item" href="cart.html"> 
				<img src="layout/images/book7.png" class="img-fluid product-thumbnail"> 
				<div class="card-information">
					<h3 class="product-title">Văn họcVăn họcVăn họcVăn họcVăn họcVăn họcVăn học</h3>
					<strong class="product-price">$12.00</strong>
					<span class="icon-cross">
						<img src="layout/images/cross.svg" class="img-fluid">
					</span>
				</div>
			</a> 
		</div>  -->

	</div>
</div>
<!-- End Featured Books -->

<!-- Start Popular Product -->
<!-- <div class="popular-product">
	<div class="container">
		<div class="row">

			<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
				<div class="product-item-sm d-flex">
					<div class="thumbnail">
						<img src="images/product-1.png" alt="Image" class="img-fluid">
					</div>
					<div class="pt-3">
						<h3>Nordic Chair</h3>
						<p>Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio </p>
						<p><a href="#">Read More</a></p>
					</div>
				</div>
			</div>

			<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
				<div class="product-item-sm d-flex">
					<div class="thumbnail">
						<img src="images/product-2.png" alt="Image" class="img-fluid">
					</div>
					<div class="pt-3">
						<h3>Kruzo Aero Chair</h3>
						<p>Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio </p>
						<p><a href="#">Read More</a></p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div> -->
<!-- End Popular Product -->

<!-- Start Review Customer's Slider -->
<div class="testimonial-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 mx-auto text-center">
				<h2 class="section-title">Các Đánh Giá Của Khách Hàng</h2>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="testimonial-slider-wrap text-center">

					<div id="testimonial-nav">
						<span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
						<span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
					</div>

					<div class="testimonial-slider">

						<div class="item">
							<div class="row justify-content-center">
								<div class="col-lg-8 mx-auto">

									<div class="testimonial-block text-center">
										<blockquote class="mb-5">
											<p>&ldquo;"Tôi đã sử dụng dịch vụ của cửa hàng cho thuê mượn sách này hơn
												một năm nay và hoàn toàn hài lòng. Cửa hàng có nhiều đầu sách phong phú,
												từ sách học thuật đến tiểu thuyết. Đội ngũ nhân viên nhiệt tình và hỗ
												trợ khách hàng rất tốt. Chắc chắn tôi sẽ tiếp tục sử dụng dịch vụ của
												cửa hàng.&rdquo;</p>
										</blockquote>

										<div class="author-info">
											<div class="author-pic">
												<img src="layout/images/person_1.jpg" alt="Maria Jones"
													class="img-fluid">
											</div>
											<h3 class="font-weight-bold">Nguyễn Tuấn Cường</h3>
											<span class="position d-block mb-3">Khách hàng</span>
										</div>
									</div>

								</div>
							</div>
						</div>
						<!-- END item -->

						<div class="item">
							<div class="row justify-content-center">
								<div class="col-lg-8 mx-auto">

									<div class="testimonial-block text-center">
										<blockquote class="mb-5">
											<p>&ldquo;Cửa hàng này thực sự là một kho báu cho những người yêu sách như
												tôi. Giá thuê mượn sách rất hợp lý và có nhiều chương trình khuyến mãi
												hấp dẫn. Tôi thường xuyên thuê sách về đọc và luôn cảm thấy hài lòng với
												chất lượng dịch vụ.&rdquo;</p>
										</blockquote>

										<div class="author-info">
											<div class="author-pic">
												<img src="layout/images/person_3.jpg" alt="Maria Jones"
													class="img-fluid">
											</div>
											<h3 class="font-weight-bold">Thành Cường</h3>
											<span class="position d-block mb-3">Khách hàng</span>
										</div>
									</div>

								</div>
							</div>
						</div>
						<!-- END item -->

						<div class="item">
							<div class="row justify-content-center">
								<div class="col-lg-8 mx-auto">

									<div class="testimonial-block text-center">
										<blockquote class="mb-5">
											<p>&ldquo;Dịch vụ của cửa hàng rất tuyệt vời! Tôi tìm thấy rất nhiều cuốn
												sách hiếm mà tôi không thể tìm thấy ở đâu khác. Hệ thống website cũng
												rất dễ sử dụng, giúp tôi dễ dàng tìm và đặt sách. Tôi rất vui vì đã tìm
												thấy cửa hàng này.&rdquo;</p>
										</blockquote>

										<div class="author-info">
											<div class="author-pic">
												<img src="layout/images/person_4.jpg" alt="Maria Jones"
													class="img-fluid">
											</div>
											<h3 class="font-weight-bold">Đinh Quốc Hào</h3>
											<span class="position d-block mb-3">Khách hàng</span>
										</div>
									</div>

								</div>
							</div>
						</div>
						<!-- END item -->

					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Testimonial Slider -->




<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>