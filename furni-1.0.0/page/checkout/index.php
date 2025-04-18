<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<style>
	.table th,
	.table td {
		vertical-align: middle;
		text-align: center;
		/* Đảm bảo nội dung luôn căn giữa theo chiều ngang */
	}

	.table td {
		height: 50px;
		/* Đặt chiều cao cố định cho tất cả các hàng */
		overflow: hidden;
		/* Ngăn văn bản tràn ra ngoài */
	}


	.table td:nth-child(2) {
		width: 200px;
		/* Cố định chiều rộng cho cột tên sách */
	}

	.table td:nth-child(5) {
		text-align: right;
		/* Căn phải cho cột tiền cọc */
	}

	.table {
		table-layout: fixed;
		/* Đảm bảo kích thước cố định cho các cột */
		width: 100%;
		/* Bảng chiếm toàn bộ chiều rộng container */
	}

	#confirm:hover {
		background-color: black;
	}
</style>

<!doctype html>
<html lang="en">
<?php
if (!isset($_GET['checkout'])) {
	$checkout = 1;
} else {
	$checkout = $_GET['checkout'];
}
$maKM = '';
$maThe = '0';
$maKH = '';
$khuyenMai = $_SESSION['total_rent'];
$tongtienThueSauUuDai = $_SESSION['total_rent'];
$total_deposit = number_format($_SESSION['total_deposit'], 0, ',', ',') ?? 0;
$total_rent = number_format($_SESSION['total_rent'], 0, ',', ',') ?? 0;

$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
$thanhvien = 0;
if ($conn) {
	$str = "SELECT kh.maKH, nd.email, kh.mathe FROM khachhang kh JOIN nguoidung nd ON kh.maNguoiDung = nd.maNguoiDung";
	$result = $conn->query($str);
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			if ($_SESSION['user'] == $row['email'])
				$maKH = $row['maKH'];
			if ($_SESSION['user'] == $row['email'] && $row['mathe'] != null) {
				$thanhvien = 1;
				$maThe = $row['mathe'];
				break;
			}
		}
	}
}
if ($thanhvien == 1) {
	$thanhvien = str_replace(',', '', $_SESSION['total_rent']) * 10 / 100;
}
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
							<th>Tiền Cọc</th>

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
											<form method="POST" action="">
												<select name="km" id="km-select" onchange="this.form.submit()"
													style="border-radius: 10px;width: 150px;height: 30px;">
													<option value="0">Vui lòng chọn</option>
													<?php
													$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
													if ($conn) {
														$str = "SELECT * FROM khuyenmai";
														$result = $conn->query($str);
														if (mysqli_num_rows($result) > 0) {
															while ($row = mysqli_fetch_assoc($result)) {
																$selected = (isset($_POST['km']) && $_POST['km'] == $row['phanTramKM']) ? 'selected' : "";
																echo "<option value='{$row['phanTramKM']}' $selected>{$row['tenKM']}</option>";
																if ($selected == 'selected')
																	$maKM = $row['maKM'];
															}
														}
													}
													?>
												</select>
											</form>
										</td>
									</tbody>


								</table>
							</div>
							<div class="border  mb-3">
								<div class="col-md-12">
									<table class="table site-block-order-table mb-5" align="center">
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
													<?php echo number_format($thanhvien, 0, ',', ',') ?? 0; ?>
													VND
												</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Khuyến Mãi</strong></td>
												<td class="text-black" style="text-align: right;">-
													<?php
													$raw_total_rent = str_replace(',', '', $_SESSION['total_rent']); // Loại bỏ dấu phẩy
													$khuyenMai = $_POST['km'] / 100 * $raw_total_rent;
													echo number_format($khuyenMai, 0, ',', ','); ?> VND
												</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Tổng Tiền Thuê Sau Ưu
														Đãi</strong>
												</td>
												<td class="text-black" style="text-align: right;"><?php
												$raw_total_rent = str_replace(',', '', $_SESSION['total_rent']);
												$raw_total_km = str_replace(',', '', $khuyenMai); // Loại bỏ dấu phẩy
												$tongtienThueSauUuDai = $raw_total_rent - $raw_total_km - $thanhvien;
												echo number_format($tongtienThueSauUuDai, 0, ',', ','); ?> VND</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Phí Ship</strong>
												</td>
												<td class="text-black" style="text-align: right;">30,000 VND</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Tổng Cộng Tiền
														Thuê</strong>
												</td>
												<td class="text-black" style="text-align: right;"><strong>
														<?php $raw_total_rent = str_replace(',', '', $tongtienThueSauUuDai);
														$total = $raw_total_rent + 30000;
														echo number_format($total, 0, ',', ',');
														?>
														VND</strong>
												</td>
											</tr>
											<tr>
												<td class="text-black font-weight-bold"><strong>Tổng Tiền Cọc Thanh
														Toán</strong>
												</td>
												<td class="text-black" style="text-align: right;">
													<strong><?php echo $total_deposit ?>
														VND</strong>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>


							<div class="form-group">
								<form method="post"><button type='submit' class="btn btn-black btn-lg py-3 btn-block"
										id="btn-confirm" name="confirm" style="background-color: #a76d49">Xác
										nhận</button></form>
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
<?php
if (isset($_POST['km']) && $_POST['km'] > 0) {
	$_SESSION['maKM'] = $maKM;
}
if (isset($_POST['confirm'])) {
	$kiemtra = 0;
	foreach ($_SESSION['cart'] as $key => $cart_item) {
		$str = "SELECT tongSoLuong, soLuongDangThue FROM dausach WHERE maDauSach = {$cart_item['id']}";
		$result = $conn->query($str);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$soLuongConLai = $row['tongSoLuong'] - $row['soLuongDangThue'];
				if ($cart_item['quantity'] > $soLuongConLai) {
					echo "<script>alert('Không đủ số lượng! Sách {$cart_item['name']} chỉ còn {$soLuongConLai} quyển')</script>";
					$kiemtra = 1;
				}
			}
		}
	}
	if ($kiemtra == 0) {
		$total_deposit = str_replace(',', '', $total_deposit); //tongtiencoc
		//tong tien thue = total
		$ship = 30000;
		$now = date_create()->format('Y-m-d');
		if (isset($_SESSION['maKM'])) {
			$km = $_SESSION['maKM'];
		} else {
			$km = 0;
		}
		$date = new DateTime('now');
		$date->modify('+15 days');
		$date = $date->format('Y-m-d');
		if ($km == 0 && $maThe != '0') {
			$str = "INSERT INTO donthuesach(ngayThue, tongTienThue, tongTienCoc, tinhTrangThanhToan, phiShip, maKH, maThe) VALUES('$now', $total, $total_deposit, 'Chua thanh toan', $ship, $maKH, '$maThe')";
		} else if ($km != 0 && $maThe != '0')
			$str = "INSERT INTO donthuesach(ngayThue, tongTienThue, tongTienCoc, tinhTrangThanhToan, phiShip, maKM, maKH, maThe ) VALUES('$now', $total, $total_deposit, 'Chua thanh toan', $ship, $km, $maKH, '$maThe')";
		else if ($km != 0 && $maThe == '0')
			$str = "INSERT INTO donthuesach(ngayThue, tongTienThue, tongTienCoc, tinhTrangThanhToan, phiShip, maKM, maKH) VALUES('$now', $total, $total_deposit, 'Chua thanh toan', $ship, $km, $maKH)";
		else if ($km == 0 && $maThe == '0') {
			$str = "INSERT INTO donthuesach(ngayThue, tongTienThue, tongTienCoc, tinhTrangThanhToan, phiShip, maKH) VALUES('$now', $total, $total_deposit, 'Chua thanh toan', $ship, $maKH)";
		}
		$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
		if ($conn) {
			if ($conn->query($str)) {
				$maDon = $conn->insert_id;
				$_SESSION['idPay'] = $maDon;
				foreach ($_SESSION['cart'] as $item) {
					$maDauSach = $item['id'];
					$price = $item['price'];
					$deposit = $item['deposit'];
					$quantity = $item['quantity'];
					$tinhTrang = 'Đang thuê';
					$str = "SELECT*FROM sach where tinhTrang='Con sach' and maDauSach=$maDauSach LIMIT $quantity";
					$result = $conn->query($str);
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							$str = "INSERT INTO chitiethoadon(giaThue, ngayTra, tinhTrangThue, tienCoc, maSach, maDon) VALUES($price, '$date', '$tinhTrang', $deposit, {$row['maSach']}, $maDon)";
							if ($conn->query($str)) {
								$str = "UPDATE sach SET tinhTrang='Dang thue' WHERE maSach={$row['maSach']}";
								if ($conn->query($str)) {
								}
							}
						}
					}
					$str = "UPDATE dausach SET soLuongDangThue = soLuongDangThue + $quantity WHERE maDauSach=$maDauSach";
					if ($conn->query($str)) {
					}
				}
				unset($_SESSION['cart']);
				echo "<script>alert('Xác nhận thành công'); window.location.href = 'index.php?confirmpayment'</script>";
			}
		} else
			echo "<script>alert('Xác nhận thất bại')</script>";
	}
}
?>