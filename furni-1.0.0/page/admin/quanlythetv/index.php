<?php
if (!isset($_GET['quanlythetv'])) {
    $quanlythetv = 1;
} else {
    $quanlythetv = $_GET['quanlythetv'];
}

$obj = new database();

// Truy vấn danh sách người dùng để hiển thị trong form
$sqlNguoiDung = "SELECT maNguoiDung, ten FROM nguoidung";
$nguoiDungList = $obj->xuatdulieu($sqlNguoiDung);

// Truy vấn kết hợp từ 3 bảng để hiển thị danh sách thẻ thành viên
$sql = "
    SELECT 
        thethanhvien.maThe,
        thethanhvien.hoTen AS hoTenThanhVien,
        thethanhvien.email AS emailThanhVien
    FROM thethanhvien
    LEFT JOIN khachhang ON thethanhvien.maThe = khachhang.maThe
    LEFT JOIN nguoidung ON khachhang.maNguoiDung = nguoidung.maNguoiDung
";
$thethanhvien = $obj->xuatdulieu($sql);

/// Xử lý thêm thẻ thành viên và tự động ánh xạ mã người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addMember'])) {
        $maThe = $_POST['maThe'];
        $hoTen = $_POST['hoTen'];
        $email = $_POST['email'];

        // Kiểm tra mã thẻ đã tồn tại
        $checkSql = "SELECT maThe FROM thethanhvien WHERE maThe='$maThe'";
        $checkResult = $obj->xuatdulieu($checkSql);

        if ($checkResult) {
            $message = "Thêm thất bại! Mã thẻ đã tồn tại.";
        } else {
            // Thêm mới vào bảng thethanhvien
            $sql = "INSERT INTO thethanhvien (maThe, hoTen, email) VALUES ('$maThe', '$hoTen', '$email')";
            if ($obj->themdulieu($sql)) {
                $message = "Thêm mới thẻ thành viên thành công.";

                // Tìm mã người dùng dựa trên email
                $userSql = "SELECT maNguoiDung FROM nguoidung WHERE email='$email'";
                $userResult = $obj->xuatdulieu($userSql);

                if ($userResult) {
                    $maNguoiDung = $userResult[0]['maNguoiDung'];

                    // Kiểm tra nếu mã người dùng đã có trong bảng khachhang
                    $checkUserSql = "SELECT * FROM khachhang WHERE maNguoiDung='$maNguoiDung'";
                    $userExists = $obj->xuatdulieu($checkUserSql);

                    if ($userExists) {
                        // Cập nhật mã thẻ vào bảng khachhang
                        $updateSql = "UPDATE khachhang SET maThe='$maThe' WHERE maNguoiDung='$maNguoiDung'";
                        $obj->themdulieu($updateSql);

                    }
                } else {
                    $message .= " Không tìm thấy người dùng có email tương ứng.";
                }
            } else {
                $message = "Thêm mới thẻ thành viên thất bại, vui lòng thử lại.";
            }
        }
    }
}
?>

<script>
    <?php if (isset($message)): ?>
        alert("<?= $message ?>");
        window.location.href = "indexAdmin.php?quanlythetv";
    <?php endif; ?>
</script>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="strpied-tabled-with-hover bg-white">
                    <div class="card-header bg-white">
                        <h4 class="card-title text-center">DANH SÁCH THẺ THÀNH VIÊN</h4>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i
                                class="fa fa-plus-circle"></i> Thêm mới</button>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <th><b>Mã Thẻ</b></th>
                                <th><b>Họ Tên Thành Viên</b></th>
                                <th><b>Email Thành Viên</b></th>
                            </thead>
                            <tbody>
                                <?php foreach ($thethanhvien as $item): ?>
                                    <tr>
                                        <td><?= $item["maThe"] ?></td>
                                        <td><?= $item["hoTenThanhVien"] ?></td>
                                        <td><?= $item["emailThanhVien"] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Thêm Thẻ Thành Viên -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">THÊM THẺ THÀNH VIÊN MỚI</h3>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="maThe" class="form-label">Mã thẻ</label>
                                <input type="tel" class="form-control" id="maThe" name="maThe" pattern="[0-9]{10}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="hoTen" class="form-label">Họ và Tên</label>
                                <input type="text" class="form-control" id="hoTen" name="hoTen" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary" name="addMember">Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>