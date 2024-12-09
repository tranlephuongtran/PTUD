<?php
// Kết nối tới cơ sở dữ liệu
$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");

// Lấy maDauSach từ URL
if (isset($_GET['productdetails'])) {
    $maDauSach = intval($_GET['productdetails']);
    // Truy vấn thông tin chi tiết của sản phẩm dựa trên maDauSach
    $query = "SELECT* 
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
    if (isset($_SESSION['btnLogin']) && $_SESSION['btnLogin'] == 1) {
        $maDauSach = intval($product['maDauSach']); // Lấy maDauSach
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

        // Truy vấn tổng số sách còn trong cơ sở dữ liệu
        $queryCheckStock = "SELECT SUM(tinhTrang = 'Con sach') as total FROM sach WHERE maDauSach = $maDauSach";
        $resultCheckStock = $conn->query($queryCheckStock);

        if ($resultCheckStock && $resultCheckStock->num_rows > 0) {
            $stockData = $resultCheckStock->fetch_assoc();
            $totalStock = intval($stockData['total']); // Tổng số sách còn trong cơ sở dữ liệu

            if ($quantity > $totalStock) {
                echo "<script>alert('Sách đã hết hàng!');</script>";
            } else {
                // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
                $item = [
                    'id' => $product['maDauSach'],
                    'name' => $product['tenDauSach'],
                    'price' => $product['giaThue'],
                    'deposit' => $product['tienCoc'],
                    'image' => $product['hinhAnh'],
                    'quantity' => $quantity
                ];

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                $found = false;
                // Duyệt qua giỏ hàng để tìm xem sách đã tồn tại hay chưa
                foreach ($_SESSION['cart'] as &$cart_item) {
                    if ($cart_item['id'] == $item['id']) {
                        if ($cart_item['quantity'] + $quantity > $totalStock) {
                            echo "<script>alert('Sách đã hết hàng!');</script>";
                            $found = true;
                            break;
                        }
                        $cart_item['quantity'] += $quantity;
                        $found = true;
                        break;
                    }
                }

                // Nếu sách chưa tìm thấy trong giỏ hàng và giỏ hàng còn đủ sách trong kho
                if (!$found) {
                    if ($quantity > $totalStock) {
                        echo "<script>alert('Sách đã hết hàng!');</script>";
                    } else {
                        $_SESSION['cart'][] = $item;
                        echo "<script>alert('Sách đã được thêm vào giỏ hàng thành công!');</script>";
                    }
                }
            }
        } else {
            echo "<script>alert('Không thể kiểm tra thông tin sách!');</script>";
        }
    } else {
        header("Location: index.php?login");
    }
}

?>
<!doctype html>
<html lang="en">
<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6">
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
                                <!-- Trường ẩn để gửi giá trị số lượng -->
                                <input type="hidden" id="hidden_quantity" name="quantity" value="1">
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
            <div class="col-md-7">
                <div class="col-md-12">
                    <div class="p-2 p-lg-4 border bg-white">
                        <h2><?php echo htmlspecialchars($product['tenDauSach']); ?></h2>
                        <p>Tác giả: <b><?php echo htmlspecialchars($product['tacGia']); ?></b></p>
                        <p>Nhà xuất bản: <b><?php echo htmlspecialchars($product['nxb']); ?></b></p>
                        <h4 class="text-success">Giá thuê:
                            <b><?php echo number_format($product['giaThue'], 0, '.', '.'); ?> VND</b>
                        </h4>
                        <h4 class="text-success">Tiền cọc:
                            <b><?php echo number_format($product['tienCoc'], 0, '.', '.'); ?> VND</b>
                        </h4>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <input type="number" id="quantity" name="display_quantity" class="form-control" value="1" min="1"
                                style="width: 100px;" oninput="updateHiddenQuantity()">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="p-2 p-lg-4 border bg-white">
                        <h2 class="h3 mb-3 text-black">Thông tin chi tiết</h2>
                        <table class="table site-block-order-table mb-3">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Mã ISBN</td>
                                    <td class="text-black">
                                        <strong><?php echo htmlspecialchars($product['maISBN']); ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Tác giả</td>
                                    <td class="text-black">
                                        <strong><?php echo htmlspecialchars($product['tacGia']); ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Danh mục</td>
                                    <td class="text-black">
                                        <strong><?php echo htmlspecialchars($product['ten']); ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Ngày xuất bản</td>
                                    <td class="text-black">
                                        <strong><?php echo htmlspecialchars($product['ngayXB']); ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nhà xuất bản</td>
                                    <td class="text-black">
                                        <strong><?php echo htmlspecialchars($product['nxb']); ?></strong>
                                    </td>
                                </tr>
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
<script>
    function updateHiddenQuantity() {
        // Lấy giá trị từ trường hiển thị
        var displayQuantity = document.getElementById("quantity").value;
        // Cập nhật giá trị cho trường ẩn
        document.getElementById("hidden_quantity").value = displayQuantity;
    }
</script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>