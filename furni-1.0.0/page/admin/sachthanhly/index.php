<?php
if (!isset($_GET['sachthanhly'])) {
    $sachthanhly = 1;
} else {
    $sachthanhly = $_GET['sachthanhly'];
}
?>
<?php
require_once 'myclass/products.php';

// Tạo đối tượng Product 
$product = new Product();

// Xử lý xóa sách thanh lý 
if (isset($_POST['btXoa'])) {
    $maSachXoa = $_POST['btXoa'];
    if (empty($maSachXoa)) {
        echo "<script>
            alert('Vui lòng chọn ít nhất một sách để thanh lý!'); window.location.href='';
            </script>";
    } else {
        foreach ($maSachXoa as $maSach) {
            $product->deleteBook($maSach);
        }
        echo "<script>
            alert('Sách đã được Thanh Lý thành công!'); window.location.href='';
            </script>";
    }
}

// Lấy danh sách sách thanh lý từ cơ sở dữ liệu 
$sachthanhly = $product->getThanhLyBooks();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sách thanh lý</title>
    <style>
        .card.strpied-tabled-with-hover {
            border-radius: 15px;
            overflow: hidden;
        }

        .card.strpied-tabled-with-hover .table thead th,
        .card.strpied-tabled-with-hover .table tbody td {
            border: none;
        }

        .card.strpied-tabled-with-hover .table thead {
            background-color: #f8f9fa;
        }

        .ml-custom {
            margin-left: 2rem;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class=" strpied-tabled-with-hover bg-white">
                        <div class="card-header bg-white">
                            <h4 class="card-title text-center">DANH SÁCH SÁCH THANH LÝ</h4>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <form method="post">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Chọn</th>
                                            <th>Mã Sách</th>
                                            <th>Tên Sách</th>
                                            <th>Tác Giả</th>
                                            <th>Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($sachthanhly) > 0): ?>
                                            <?php foreach ($sachthanhly as $item): ?>
                                                <tr>
                                                    <td><input type="checkbox" name="btXoa[]" value="<?= $item["maSach"] ?>">
                                                    </td>
                                                    <td><?= $item["maSach"] ?></td>
                                                    <td><?= $item["tenDauSach"] ?></td>
                                                    <td><?= $item["tacGia"] ?></td>
                                                    <td>
                                                        <button type="submit" name="btXoaSingle" value="<?= $item["maSach"] ?>"
                                                            class="btn btn-danger">Thanh Lý</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Chưa có sách cần Thanh Lý</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <?php if (count($sachthanhly) > 0): ?>
                                    <button type="submit" class="btn btn-danger ml-custom">Thanh Lý Sách Đã Chọn</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('form').addEventListener('submit', function (event) {
            if (!confirm('Bạn có chắc chắn muốn thanh lý các sách đã chọn không?')) {
                event.preventDefault();
            }
        });
    </script>
</body>

</html>