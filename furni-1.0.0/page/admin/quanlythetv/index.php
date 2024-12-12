<?php
$message = ''; // Initialize the message variable

if (!isset($_GET['quanlythetv'])) {
    $quanlythetv = 1;
} else {
    $quanlythetv = $_GET['quanlythetv'];
}

$obj = new database();

// Query to get user list
$sqlNguoiDung = "SELECT maNguoiDung, ten FROM nguoidung";
$nguoiDungList = $obj->xuatdulieu($sqlNguoiDung);

// Query to get member card list
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

// Initialize variables
$hoTen = '';
$email = '';
$maThe = '';

// Check POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addMember'])) {
        $maThe = $_POST['maThe'];
        $hoTen = $_POST['hoTen'];
        $email = $_POST['email'];

        // Check if card ID exists
        $checkSql = "SELECT maThe FROM thethanhvien WHERE maThe='$maThe'";
        $checkResult = $obj->xuatdulieu($checkSql);

        if ($checkResult) {
            $message = "Thêm thất bại! Mã thẻ đã tồn tại.";
        } else {
            // Insert new member card
            $sql = "INSERT INTO thethanhvien (maThe, hoTen, email) VALUES ('$maThe', '$hoTen', '$email')";
            if ($obj->themdulieu($sql)) {

                $userSql = "SELECT maNguoiDung FROM nguoidung WHERE email='$email'";
                $userResult = $obj->xuatdulieu($userSql);
                if ($userResult) {
                    $maNguoiDung = $userResult[0]['maNguoiDung'];

                    // Kiểm tra nếu người dùng đã tồn tại trong bảng khachhang
                    $checkKhachHangSql = "SELECT * FROM khachhang WHERE maNguoiDung='$maNguoiDung'";
                    $khachHangExists = $obj->xuatdulieu($checkKhachHangSql);

                    if ($khachHangExists) {

                        $updateKhachHangSql = "UPDATE khachhang SET maThe='$maThe' WHERE maNguoiDung='$maNguoiDung'";
                        $obj->themdulieu($updateKhachHangSql);
                    } else {
                        $insertKhachHangSql = "INSERT INTO khachhang (maNguoiDung, maThe) VALUES ('$maNguoiDung', '$maThe')";
                        $obj->themdulieu($insertKhachHangSql);
                    }
                } else {
                    $message .= " Không tìm thấy người dùng có email tương ứng.";
                }

                $message = "Thêm mới thẻ thành viên thành công.";
                // Reset giá trị
                $hoTen = '';
                $email = '';
                $maThe = '';
            } else {
                $message = "Thêm mới thẻ thành viên thất bại, vui lòng thử lại.";
            }
        }
    }

    if (isset($_POST['checkPhone'])) {
        $maThe = $_POST['maThe'];

        // Check if phone number exists in nguoidung table
        $checkPhoneSql = "SELECT maNguoiDung, ten, email FROM nguoidung WHERE SDT = '$maThe'";
        $result = $obj->xuatdulieu($checkPhoneSql);

        if ($result) {
            $hoTen = $result[0]['ten'];
            $email = $result[0]['email'];

            $checkMemberSql = "SELECT maThe FROM thethanhvien WHERE maThe = '$maThe'";
            $checkMemberResult = $obj->xuatdulieu($checkMemberSql);

            if ($checkMemberResult) {
                $message = "Số điện thoại này đã đăng ký thẻ thành viên.";
                $hoTen = $email = '';
            } else {
                $message = "Số điện thoại này chưa đăng ký thẻ thành viên. Vui lòng xác nhận để đăng ký thẻ thành viên.";
            }
        } else {
            $message = "Số điện thoại này hiện chưa đăng ký tài khoản, vui lòng đăng ký tài khoản trước.";
            $hoTen = $email = '';
        }
    }
}

?>

<script>
    // Show alert message if exists
    <?php if ($message): ?>
        alert("<?= $message ?>");
        <?php if (strpos($message, 'thành công') === false): ?>
            window.onload = function () {
                $('#myModal').modal('show');
            };
        <?php else: ?>
            window.location.href = "indexAdmin.php?quanlythetv";
        <?php endif; ?>
    <?php endif; ?>
</script>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="strpied-tabled-with-hover bg-white">
                    <div class="card-header bg-white">
                        <h4 class="card-title text-center">DANH SÁCH THẺ THÀNH VIÊN</h4>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-plus-circle"></i> Thêm mới
                        </button>
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
                                <label for="maThe" class="form-label">Mã thẻ (Số điện thoại)</label>
                                <input type="tel" class="form-control" id="maThe" name="maThe" pattern="[0-9]{10}"
                                    required value="<?= isset($maThe) ? $maThe : '' ?>">
                            </div>
                            <button type="submit" class="btn btn-info" name="checkPhone">Kiểm tra</button>
                            <div class="mb-3">
                                <label for="hoTen" class="form-label">Họ và Tên</label>
                                <input type="text" class="form-control" id="hoTen" name="hoTen" value="<?= $hoTen ?>"
                                    required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>"
                                    required readonly>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                            <?php if ($hoTen && $email): ?>
                                <button type="submit" class="btn btn-primary" name="addMember">Xác nhận</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>