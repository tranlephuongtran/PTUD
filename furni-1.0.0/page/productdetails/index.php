<?php
// Kết nối tới cơ sở dữ liệu
$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");

// Lấy maDauSach từ URL
if (isset($_GET['productdetails'])) {
    $maDauSach = intval($_GET['productdetails']);
    // Truy vấn thông tin chi tiết của sản phẩm dựa trên maDauSach
    $query = "SELECT d.tenDauSach, s.maISBN, dm.ten AS danhmuc, s.ngayXB, s.giaThue, s.tienCoc, d.hinhAnh, s.moTa
          FROM dausach d
          JOIN sach s ON d.maDauSach = s.maDauSach
          JOIN danhmuc dm ON d.maDM = dm.maDM
          WHERE d.maDauSach = $maDauSach LIMIT 1";
    $result = $conn->query($query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Sản phẩm không tồn tại.";
        exit();
    }
} else {
    echo "Không tìm thấy mã sản phẩm.";
    exit();
}

// Xử lý khi nhấn "Thêm vào giỏ hàng"
if (isset($_POST['add_to_cart'])) {
    //session_start();

    // Tạo sản phẩm cần thêm vào giỏ hàng
    $item = [
        'id' => $product['maISBN'],
        'name' => $product['tenDauSach'],
        'price' => $product['giaThue'],
        'deposit' => $product['tienCoc'],
        'image' => $product['hinhAnh'],
        'quantity' => 1
    ];

    // Khởi tạo giỏ hàng trong session nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $item['id']) {
            $cart_item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    // Nếu sản phẩm chưa có trong giỏ hàng, thêm vào giỏ
    if (!$found) {
        $_SESSION['cart'][] = $item;
    }

    // Trả về JSON để xác nhận thành công
    echo "<script>alert('Sách đã được thêm vào giỏ hàng thành công!');</script>";
    exit();
}
?>
<!doctype html>
<html lang="en">
<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content ">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1><?php echo htmlspecialchars($product['tenDauSach']); ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mb-5 mb-md-0">
                <div class="p-2 p-lg-4 border bg-white">
                    <div class="row">
                        <img src="layout/images/<?php echo htmlspecialchars($product['hinhAnh']); ?>"
                            style="width: 485px;height: 561px;" class="img-fluid product-thumbnail">
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <form method="post">
                                <button type="submit" name="add_to_cart" class="btn btn-primary mt-4 mb-4"
                                    style="border-radius: 10px;">
                                    <img src="layout/images/cart.svg"> Thêm Vào Giỏ Hàng
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary mt-4 mb-4" onclick="window.location='shop/index.php'"
                                style="border-radius: 10px;">Quay về</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="col-md-12">
                    <div class="p-2 p-lg-4 border bg-white">
                        <h2><?php echo htmlspecialchars($product['tenDauSach']); ?></h2>
                        <p>Tác giả: <b><?php //echo htmlspecialchars($product['tacGia']); ?></b></p>
                        <p>Nhà xuất bản: <b><? php// echo htmlspecialchars($product['nhaXuatBan']); ?></b></p>
                        <h4 class="text-success">Giá thuê:
                            <b><?php echo number_format($product['giaThue'], 0, '.', '.'); ?> VND</b></h4>
                        <h4 class="text-success">Tiền cọc:
                            <b><?php echo number_format($product['tienCoc'], 0, '.', '.'); ?> VND</b></h4>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <input type="number" id="quantity" class="form-control" value="1" min="1"
                                style="width: 100px;">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="p-2 p-lg-4 product-description-container">
                        <h2 class="h3 mb-3 text-black">Thông tin chi tiết</h2>
                        <table class="table site-block-order-table mb-3">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Mã ISBN</td>
                                    <td class="text-black">
                                        <strong><?php echo htmlspecialchars($product['maISBN']); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tác giả</td>
                                    <td class="text-black">
                                        <strong><? php// echo htmlspecialchars($product['tacGia']); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Danh mục</td>
                                    <td class="text-black">
                                        <strong><?php echo htmlspecialchars($product['danhmuc']); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Ngày xuất bản</td>
                                    <td class="text-black">
                                        <strong><?php echo htmlspecialchars($product['ngayXB']); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nhà xuất bản</td>
                                    <td class="text-black">
                                        <strong><? php// echo htmlspecialchars($product['nhaXuatBan']); ?></strong></td>
                                </tr>
                                <!--<script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        // Lắng nghe sự kiện khi form thêm vào giỏ hàng được submit
                                        document.querySelector('form').addEventListener('submit', function(event) {
                                            event.preventDefault(); // Ngăn form gửi yêu cầu nạp lại trang

                                            // Tạo yêu cầu AJAX
                                            var xhr = new XMLHttpRequest();
                                            xhr.open("POST", window.location.href, true);
                                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                                            // Xử lý phản hồi khi yêu cầu hoàn tất
                                            xhr.onreadystatechange = function() {
                                                if (xhr.readyState === 4 && xhr.status === 200) {
                                                    // Chuyển đổi phản hồi JSON từ server
                                                    var response = JSON.parse(xhr.responseText);
                                                    
                                                    // Hiển thị thông báo thành công
                                                    if (response.status === "success") {
                                                        var myModal = new bootstrap.Modal(document.getElementById('successModal'), {
                                                            keyboard: false
                                                        });
                                                        myModal.show();
                                                    }
                                                }
                                            };

                                            // Gửi yêu cầu với dữ liệu cần thiết
                                            xhr.send("add_to_cart=1");
                                        });
                                    });
                                    </script>-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="p-3 p-lg-5 border bg-white">
                    <h3>Mô tả sản phẩm</h3>
                    <p style="text-align: justify;"><?php echo htmlspecialchars($product['moTa']); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>