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

    .pagination {
        display: flex;
        justify-content: center;
        /* Căn giữa các nút theo chiều ngang */
        margin-top: 10px;
    }

    .pagination a {
        text-decoration: none;
        width: 50px;
        /* Tăng chiều rộng */
        height: 50px;
        /* Tăng chiều cao */
        border: 2px solid #ccc;
        /* Thêm đường viền sáng */
        padding: 10px;
        /* Tăng không gian xung quanh chữ */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        /* Tăng kích thước chữ */
        border-radius: 5px;
        /* Thêm bo góc */
        margin: 5px;
        /* Khoảng cách giữa các nút */
        transition: all 0.3s ease;
        /* Thêm hiệu ứng chuyển động */
    }

    .pagination a:hover {
        background-color: #a76d49;
        /* Thêm hiệu ứng nền khi hover */
        color: white;
        /* Thay đổi màu chữ khi hover */
        transform: scale(1.1);
        /* Phóng to nút khi hover */
    }

    .pagination .active {
        background-color: #a76d49;
        /* Nền trang hiện tại */
        color: white;
        font-weight: bold;
        /* In đậm chữ */
        border-color: #a76d49;
        /* Thêm đường viền cùng màu với nền */
    }

    #search:hover {
        background-color: black !important;
    }
</style>
<?php
if (!isset($_GET['shop'])) {
    $shop = 1;
} else {
    $shop = intval($_GET['shop']);
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
<form method="POST">
    <div class="row" style="position: relative; left: 330px; top: 100px">
        <input type="text" name="searchInput" style="width: 800px;">
        <button style="width: 100px; border: 0; background-color: #a76d49; color: white" id="search"
            name="searchBtn">Tìm</button>
    </div>
</form>
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            <?php
            $conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
            $search = $_GET['search'];
            $results_per_page = 8;
            if ($conn) {
                $str = "SELECT *FROM dausach d Join sach s on d.maDauSach = s.maDauSach WHERE tenDauSach like '%$search%'GROUP BY d.maDauSach";
                $result = $conn->query($str);
                $number_of_result = mysqli_num_rows($result);
                $number_of_page = ceil($number_of_result / $results_per_page);
                $page_first_result = ($shop - 1) * $results_per_page;
                if ($page_first_result < 0) {
                    $page_first_result = 0; // Đảm bảo rằng page_first_result không âm
                }
                $str = "SELECT *FROM dausach d Join sach s on d.maDauSach = s.maDauSach WHERE tenDauSach like '%$search%' GROUP BY d.maDauSach LIMIT $page_first_result, $results_per_page";
                $result = $conn->query($str);
                if (mysqli_num_rows($result) > 0) {
                    echo "<h1 align='center' style ='margin-top: -70px;'>Kết quả tìm kiếm: $search</h1>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $gia = number_format($row['giaThue'], 0, '.', '.');

                        echo "<div class='col-12 col-md-4 col-lg-3 mb-5'>
						<a href = 'index.php?productdetails={$row['maDauSach']}'>
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
                    // Phân trang
                    echo "<div class='pagination' style='text-align: center; margin-top: 10px;'>";
                    for ($i = 1; $i <= $number_of_page; $i++) {
                        if ($i == $shop) {
                            echo '<a class="active" href="index.php?shop=' . $i . '">' . $i . '</a> ';
                        } else {
                            echo '<a href="index.php?shop=' . $i . '">' . $i . '</a> ';
                        }
                    }
                    echo "</div>";
                } else {
                    echo "<h1 align='center'>Không tìm thấy</h1>";
                    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.querySelector('input[name=\"searchInput\"]');
                if (searchInput) {
                    searchInput.focus();
                }
            });
          </script>";
                }
            }
            ?>


            <!-- End Column 4 -->

        </div>
    </div>
</div>


<!-- End Footer Section -->


<script src="layout/js/bootstrap.bundle.min.js"></script>
<script src="layout/js/tiny-slider.js"></script>
<script src="layout/js/custom.js"></script>
</body>

</html>
<?php
if (isset($_POST['searchBtn'])) {
    $search = $_POST["searchInput"];
    $_SESSION['search'] = $search;
    header("Location: index.php?search=$search");
}
?>