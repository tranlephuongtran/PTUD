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
        margin-top: 10px;
    }

    .pagination a {
        text-decoration: none;
        width: 50px;
        height: 50px;
        border: 2px solid #ccc;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        border-radius: 5px;
        margin: 5px;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background-color: #a76d49;
        color: white;
        transform: scale(1.1);
    }

    .pagination .active {
        background-color: #a76d49;
        color: white;
        font-weight: bold;
        border-color: #a76d49;
    }

    #search:hover {
        background-color: #d1a689 !important;
    }
</style>
<?php
if (!isset($_GET['cate'])) {
    $cate = 1;
} else {
    $cate = intval($_GET['cate']);
}
?>

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Sản phẩm</h1>
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
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = intval($_GET['page']);
            }
            $conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
            $results_per_page = 8;
            if ($conn) {
                $str = "SELECT * 
                FROM dausach d 
                JOIN sach s ON d.maDauSach = s.maDauSach 
                JOIN danhmuc dm ON d.maDM = dm.maDM 
                WHERE dm.maDM = $cate
                GROUP BY d.maDauSach";
                $result = $conn->query($str);
                $number_of_result = mysqli_num_rows($result);
                $number_of_page = ceil($number_of_result / $results_per_page);
                $page_first_result = ($page - 1) * $results_per_page;
                $str = "SELECT * 
                FROM dausach d 
                JOIN sach s ON d.maDauSach = s.maDauSach 
                JOIN danhmuc dm ON d.maDM = dm.maDM 
                WHERE dm.maDM = $cate
                GROUP BY d.maDauSach LIMIT $page_first_result, $results_per_page";
                $result = $conn->query($str);
                if (mysqli_num_rows($result) > 0) {
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
                        if ($i == $page) {
                            echo "<a class='active' href='index.php?cate={$cate}&page={$i}'>" . $i . '</a> ';
                        } else {
                            echo "<a href='index.php?cate={$cate}&page={$i}'>" . $i . '</a> ';
                        }
                    }
                    echo '</div>';
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
<?php
if (isset($_POST['searchBtn'])) {
    $search = $_POST["searchInput"];
    $_SESSION['search'] = $search;
    header("Location: index.php?search=$search");
}
?>