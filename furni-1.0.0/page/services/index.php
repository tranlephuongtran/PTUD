<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<?php
if (!isset($_GET['services'])) {
	$services = 1;
} else {
	$services = $_GET['services'];
}
// Kết nối cơ sở dữ liệu
$servername = "127.0.0.1";
$username = "root"; // thay bằng tên đăng nhập thực tế
$password = ""; // thay bằng mật khẩu thực tế
$dbname = "ptud";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
	die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn dữ liệu từ bảng chinhsach
$sql = "SELECT * FROM chinhsach";
$result = $conn->query($sql);

// Lấy mã của chính sách đầu tiên để hiển thị mặc định
$firstPolicyId = null;
if ($result->num_rows > 0) {
	$firstRow = $result->fetch_assoc();
	$firstPolicyId = $firstRow["maChinhSach"];
	$result->data_seek(0); // Đặt lại con trỏ để duyệt lại từ đầu
}
?>

<!doctype html>
<html lang="en">

<style>
	#ChinhSach {
		display: flex;
		justify-content: space-between;
		padding: 20px;
		border: 5px;
	}

	#ChinhSachMenu {
		width: 20%;
		background-color: #db9061;
		color: #333;
		text-align: left;
		padding: 20px;
		border-radius: 8px;
		box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
		/* Đổ bóng để menu nổi bật */
	}

	#ChinhSachMenu h3 {
		font-size: 28px;
		color: #FFFFFF;
		font-weight: bold;
		margin-bottom: 20px;
		text-align: left;
	}

	#ChinhSachMenu ul {
		list-style-type: none;
		/* Bỏ dấu chấm đầu dòng */
		padding: 0;
	}

	#ChinhSachMenu ul li {
		margin-bottom: 10px;
	}

	#ChinhSachMenu ul li a {
		text-decoration: none;
		/* Bỏ gạch chân */
		color: #FFFFFF;
		font-size: 18px;
		font-weight: bold;
		display: flex;
		align-items: center;
		transition: color 0.3s;
		/* Hiệu ứng chuyển màu khi hover */
	}

	#ChinhSachMenu ul li a:hover {
		color: #a76c4a;
		/* Đổi màu chữ khi hover */
		transform: translateX(5px);
		/* Hiệu ứng di chuyển nhẹ */
	}

	#ChinhSachND {
		width: 80%;
		background-color: #e6e6e6;
		text-align: left;
		padding: 30px;
		border-radius: 8px;
		/* Bo tròn góc */
		box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
		/* Đổ bóng nhẹ */
		color: #333;
		/* Màu chữ dễ đọc */
		line-height: 1.6;
		/* Tăng khoảng cách giữa các dòng chữ */
		padding-bottom: 50px;
		background-size: cover;
		background-blend-mode: lighten;

	}

	#ChinhSachND h1 {
		font-size: 32px;
		/* Kích thước chữ lớn cho tiêu đề */
		color: #4CAF50;
		/* Màu chữ nổi bật cho tiêu đề */
		margin-bottom: 20px;
		/* Khoảng cách dưới tiêu đề */
		text-align: left;
	}

	#ChinhSachND p {
		font-size: 18px;
		/* Kích thước chữ vừa phải cho nội dung */
		margin-bottom: 15px;
		/* Khoảng cách dưới mỗi đoạn văn */
		opacity: 0;
		animation: fadeIn 1s ease-in-out forwards;
	}

	#ChinhSachND ul {
		margin-top: 20px;
		/* Khoảng cách trên cho danh sách */
		padding-left: 20px;
		/* Thụt lề để làm rõ danh sách */
	}

	#ChinhSachND ul li {
		margin-bottom: 10px;
		/* Khoảng cách dưới mỗi mục trong danh sách */
	}

	#ChinhSachND ul li::before {
		content: "•";
		/* Thêm ký hiệu đầu dòng cho danh sách */
		color: #4CAF50;
		/* Màu xanh cho ký hiệu đầu dòng */
		font-weight: bold;
		display: inline-block;
		width: 1em;
		margin-left: -1em;
	}

	#title_ChinhSach {
		border-bottom: 1px solid gray;
		color: #ff8a00;
		text-decoration: underline;
		margin-bottom: 20px;
	}

	#title_Muc {
		border-bottom: 1px solid gray;
	}

	@keyframes fadeIn {
		0% {
			opacity: 0;
			transform: translateY(10px);
		}

		100% {
			opacity: 1;
			transform: translateY(0);
		}
	}
</style>
<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>Chính sách</h1>
					<p class="mb-4">
						Cảm ơn bạn đã chọn Aplus cho trải nghiệm thuê sách của mình. Tại đây cung cấp thông tin chi tiết
						về quyền lợi, trách nhiệm của bạn và các quy định nhằm đảm bảo giao dịch minh bạch, an toàn.
					</p> <br>
					<!--<p><a href="" class="btn btn-secondary me-2">Shop Now</a><a href="#"
							class="btn btn-white-outline">Explore</a></p>-->
				</div>
			</div>
			<div class="col-lg-7">
				<div class="hero-img-wrap">
					<img src="layout/images/ChinhSachHeader.png" class="img-fluid">
					<!-- couch.png-->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Hero Section -->


<!-- End Hero Section -->
<div class="why-choose-section" id="ChinhSach">
	<div class="container" id="ChinhSachMenu">
		<h3>Chính sách A Plus</h3>
		<ul>
			<?php
			// Duyệt qua kết quả truy vấn và hiển thị danh sách chính sách với liên kết tới từng nội dung
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo '<li><a href="javascript:void(0);" onclick="showPolicy(\'policy' . $row["maChinhSach"] . '\')">' . $row["ten"] . '</a></li>';
				}
			}
			?>
		</ul>
	</div>

	<div class="container" id="ChinhSachND">
		<?php
		// Đặt lại con trỏ để đọc lại từ đầu
		$result->data_seek(0);

		// Hiển thị nội dung chi tiết của từng chính sách và ẩn tất cả, chỉ hiện khi được chọn
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				// Lấy nội dung và xử lý dấu "●"
				$noiDung = nl2br($row["noiDung"]); // Chuyển đổi ký tự xuống dòng thành thẻ <br>
		
				// Bọc nội dung đã xử lý trong thẻ <ul> nếu có mục
				if (strpos($noiDung, '<li>') !== false) {
					$noiDung = '<ul>' . $noiDung . '</ul>';
				}

				// Kiểm tra xem có phải là chính sách đầu tiên không và thêm style hiển thị mặc định
				$displayStyle = ($row["maChinhSach"] == $firstPolicyId) ? 'block' : 'none';
				echo '<div class="policy-content" id="policy' . $row["maChinhSach"] . '" style="display: ' . $displayStyle . ';">';
				echo '<header id="title_ChinhSach"><h2>' . $row["ten"] . '</h2></header>';
				echo '<p>' . $noiDung . '</p> <br>'; // Hiển thị nội dung đã được định dạng
				echo '</div>';
			}
		} else {
			echo "<p>Không có chính sách nào để hiển thị.</p>";
		}
		// Đóng kết nối cơ sở dữ liệu
		$conn->close();
		?>
	</div>
</div>




<!-- Start Footer Section -->

<!-- End Footer Section -->

<script>
	function showPolicy(policyId) {
		// Ẩn tất cả các nội dung chính sách
		const policies = document.querySelectorAll('.policy-content');
		policies.forEach(policy => {
			policy.style.display = 'none';
		});

		// Hiển thị nội dung của chính sách được chọn
		document.getElementById(policyId).style.display = 'block';

		// Tự động hiển thị chính sách đầu tiên khi tải trang
		document.addEventListener("DOMContentLoaded", function () {
			const firstPolicyId = "<?php echo $firstPolicyId; ?>";
			if (firstPolicyId) {
				showPolicy('policy' + firstPolicyId);
			}
		});

	}
</script>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>
</body>

</html>