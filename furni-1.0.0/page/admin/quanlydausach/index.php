<?php
if (!isset($_GET['quanlydausach'])) {
    $quanlydausach = 1;
} else {
    $quanlydausach = (int) $_GET['quanlydausach'];
}
$obj = new database();
// Cài đặt số lượng sách trên mỗi trang
$limit = 10;
$start = max(0, ($quanlydausach - 1) * $limit);
$sql = "SELECT dausach.*, danhmuc.ten AS tenDanhMuc FROM dausach 
        INNER JOIN danhmuc ON dausach.maDM = danhmuc.maDM
        LIMIT $start, $limit";
$dausach = $obj->xuatdulieu($sql);
// Truy vấn số lượng tổng đầu sách để tính toán phân trang
$sqlTotal = "SELECT COUNT(*) as total FROM dausach";
$totalBooks = $obj->xuatdulieu($sqlTotal);
$totalBooks = $totalBooks[0]['total'];
$totalPages = ceil($totalBooks / $limit);
// Xử lý các thao tác thêm, sửa, xóa
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addBook'])) {
        $tenDauSach = $_POST['tenDauSach'];
        $tacGia = $_POST['tacGia'];
        $nxb = $_POST['nxb'];
        $tongSoLuong = $_POST['tongSoLuong'] > 0 ? $_POST['tongSoLuong'] : 1; 
        $soLuongDangThue = $_POST['soLuongDangThue'] > 0 ? $_POST['soLuongDangThue'] : 0; 
        $maDM = $_POST['maDM'];
        // Xử lý hình ảnh
        if (isset($_FILES['hinhAnh']) && $_FILES['hinhAnh']['error'] == 0) {
            $targetDir = "layout/images/";
            $fileName = time() . '_' . basename($_FILES['hinhAnh']['name']);
            $targetFilePath = $targetDir . $fileName;
    
            if (move_uploaded_file($_FILES['hinhAnh']['tmp_name'], $targetFilePath)) {
                $hinhAnh = $fileName;
            } else {
                // echo '<script>alert("Lỗi khi tải ảnh lên.");</script>';
                $message = "Lỗi khi tải ảnh lên";
                $hinhAnh = null;
            }
        } else {
            $hinhAnh = null;
        }
        // Thêm đầu sách vào cơ sở dữ liệu
        $sql = "INSERT INTO dausach (tenDauSach, tacGia, nxb, tongSoLuong, soLuongDangThue, maDM, hinhAnh)
                VALUES ('$tenDauSach', '$tacGia', '$nxb', '$tongSoLuong', '$soLuongDangThue', '$maDM', '$hinhAnh')";
        if ($obj->themdulieu($sql)) {
            // echo '<script>alert("Thêm mới đầu sách thành công");</script>';
            $message = "Thêm mới đầu sách thành công";
        } else {
            // echo '<script>alert("Thêm mới đầu sách thất bại");</script>';
            $message = "Thêm mới đầu sách thật bại";
        }
    }
    // Xử lý xóa đầu sách
    if (isset($_POST['btXoa'])) {
        $maDauSach = $_POST['btXoa'];
        $sql = "DELETE FROM dausach WHERE maDauSach='$maDauSach'";
        $obj->xoadulieu($sql);
        $message = "Xóa thành công";
    }
    // Xử lý sửa đầu sách
    if (isset($_POST['btSua'])) {
        $maDauSach = $_POST['maDauSach'];
        $tenDauSach = $_POST['tenDauSach'];
        $tacGia = $_POST['tacGia'];
        $nxb = $_POST['nxb'];
        $tongSoLuong = $_POST['tongSoLuong'] > 0 ? $_POST['tongSoLuong'] : 1; // Đảm bảo tổng số lượng tối thiểu là 1
        $soLuongDangThue = $_POST['soLuongDangThue'] > 0 ? $_POST['soLuongDangThue'] : 0; // Đảm bảo số lượng đang thuê là 0
        $maDM = $_POST['maDM'];
        // Xử lý cập nhật hình ảnh
        if (isset($_FILES['hinhAnh']) && $_FILES['hinhAnh']['error'] == 0) {
            $targetDir = "layout/images/";
            $fileName = time() . '_' . basename($_FILES['hinhAnh']['name']);
            $targetFilePath = $targetDir . $fileName;
    
            if (move_uploaded_file($_FILES['hinhAnh']['tmp_name'], $targetFilePath)) {
                $hinhAnh = $fileName;
            } else {
                $message = "Lỗi khi tải ảnh lên";
                $hinhAnh = $_POST['oldHinhAnh'];
            }
        } else {
            $hinhAnh = $_POST['oldHinhAnh'];
        }
        // Cập nhật đầu sách
        $sql = "UPDATE dausach SET tenDauSach='$tenDauSach', tacGia='$tacGia', nxb='$nxb', 
                tongSoLuong='$tongSoLuong', soLuongDangThue='$soLuongDangThue', maDM='$maDM', hinhAnh='$hinhAnh'
                WHERE maDauSach='$maDauSach'";
        if ($obj->suadulieu($sql)) {
            // echo '<script>alert("Cập nhật đầu sách thành công");</script>';
            $message = "Cập nhật đầu sách thành công";
        } else {
            // echo '<script>alert("Cập nhật đầu sách thất bại");</script>';
            $message = "Cập nhật đầu sách thật bại";
        }
    }
}
?>
<script>
    //thông báo cập nhật
    <?php if ($message): ?>
        alert("<?= $message ?>");
        window.location.href = "indexAdmin.php?quanlydausach"; // Redirect after alert
    <?php endif; ?>
</script>
<style>
    .modal-body {
        max-height: 50vh; 
        overflow-y: auto; 
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header">
                        <h4 class="card-title text-center">DANH SÁCH ĐẦU SÁCH</h4>
                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#addBookModal">
                            <i class="fa fa-plus-circle"></i> Thêm mới
                        </button>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Mã Đầu Sách</th>
                                    <th>Tên Đầu Sách</th>
                                    <th>Tác Giả</th>
                                    <th>NXB</th>
                                    <th>Tổng Số Lượng</th>
                                    <th>Số Lượng Đang Thuê</th>
                                    <th>Danh Mục</th>
                                    <th>Hình Ảnh</th>
                                    <th>Thao Tác</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($dausach as $item): ?>
                                        <tr>
                                            <td><?= $item["maDauSach"] ?></td>
                                            <td><?= $item["tenDauSach"] ?></td>
                                            <td><?= $item["tacGia"] ?></td>
                                            <td><?= $item["nxb"] ?></td>
                                            <td><?= $item["tongSoLuong"] ?></td>
                                            <td><?= $item["soLuongDangThue"] ?></td>
                                            <td><?= $item["tenDanhMuc"] ?></td>
                                            <td><img src="layout/images/<?= $item['hinhAnh'] ?>" alt="Ảnh" width="50"></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editBookModal"
                                                    onclick="editBook(<?= htmlspecialchars(json_encode($item)) ?>)">
                                                    Sửa
                                                </button>
                                                <button type="submit" name="btXoa" value="<?= $item["maDauSach"] ?>" 
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa đầu sách này không?')">Xóa</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <!-- Phân trang -->
                    <div class="pagination text-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?quanlydausach=<?= $i ?>" class="btn btn-info"><?= $i ?></a>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        <!-- Modal Thêm Đầu Sách -->
        <div id="addBookModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">THÊM ĐẦU SÁCH MỚI</h3>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tenDauSach" class="form-label">Tên Đầu Sách</label>
                                <input type="text" class="form-control" name="tenDauSach" required>
                            </div>
                            <div class="mb-3">
                                <label for="tacGia" class="form-label">Tác Giả</label>
                                <input type="text" class="form-control" name="tacGia" required>
                            </div>
                            <div class="mb-3">
                                <label for="nxb" class="form-label">NXB</label>
                                <input type="text" class="form-control" name="nxb" required>
                            </div>
                            <div class="mb-3">
                                <label for="tongSoLuong" class="form-label">Tổng Số Lượng</label>
                                <input type="number" class="form-control" name="tongSoLuong" required>
                            </div>
                            <div class="mb-3">
                                <label for="soLuongDangThue" class="form-label">Số Lượng Đang Thuê</label>
                                <input type="number" class="form-control" name="soLuongDangThue" required>
                            </div>
                            <div class="mb-3">
                                <label for="maDM" class="form-label">Danh Mục</label>
                                <select class="form-control" name="maDM">
                                    <?php foreach ($obj->xuatdulieu("SELECT * FROM danhmuc") as $dm): ?>
                                        <option value="<?= $dm['maDM'] ?>"><?= $dm['ten'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="hinhAnh" class="form-label">Hình Ảnh</label>
                                <input type="file" class="form-control" name="hinhAnh" accept="image/*" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" name="addBook" class="btn btn-primary">Thêm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal Sửa Đầu Sách -->
        <div id="editBookModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">SỬA ĐẦU SÁCH</h3>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="maDauSach" id="editMaDauSach">
                            <div class="mb-3">
                                <label for="editTenDauSach" class="form-label">Tên Đầu Sách</label>
                                <input type="text" class="form-control" name="tenDauSach" id="editTenDauSach" required>
                            </div>
                            <div class="mb-3">
                                <label for="editTacGia" class="form-label">Tác Giả</label>
                                <input type="text" class="form-control" name="tacGia" id="editTacGia" required>
                            </div>
                            <div class="mb-3">
                                <label for="editNXB" class="form-label">NXB</label>
                                <input type="text" class="form-control" name="nxb" id="editNXB" required>
                            </div>
                            <div class="mb-3">
                                <label for="editTongSoLuong" class="form-label">Tổng Số Lượng</label>
                                <input type="number" class="form-control" name="tongSoLuong" id="editTongSoLuong" required>
                            </div>
                            <div class="mb-3">
                                <label for="editSoLuongDangThue" class="form-label">Số Lượng Đang Thuê</label>
                                <input type="number" class="form-control" name="soLuongDangThue" id="editSoLuongDangThue" required>
                            </div>
                            <div class="mb-3">
                                <label for="editMaDM" class="form-label">Danh Mục</label>
                                <select class="form-control" name="maDM" id="editMaDM">
                                    <?php foreach ($obj->xuatdulieu("SELECT * FROM danhmuc") as $dm): ?>
                                        <option value="<?= $dm['maDM'] ?>"><?= $dm['ten'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editHinhAnh" class="form-label">Hình Ảnh</label>
                                <input type="file" class="form-control" name="hinhAnh" id="editHinhAnh" accept="image/*">
                                <input type="hidden" name="oldHinhAnh" id="oldHinhAnh">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" name="btSua" class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function editBook(item) {
    document.getElementById('editMaDauSach').value = item.maDauSach;
    document.getElementById('editTenDauSach').value = item.tenDauSach;
    document.getElementById('editTacGia').value = item.tacGia;
    document.getElementById('editNXB').value = item.nxb;
    document.getElementById('editTongSoLuong').value = item.tongSoLuong;
    document.getElementById('editSoLuongDangThue').value = item.soLuongDangThue;
    document.getElementById('editMaDM').value = item.maDM;
    document.getElementById('editHinhAnh').value = ""; 
    document.getElementById('oldHinhAnh').value = item.hinhAnh; 
}
</script>
