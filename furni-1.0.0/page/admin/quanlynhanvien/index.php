<?php
if (!isset($_GET['quanlynhanvien'])) {
    $quanlynhanvien = 1;
} else {
    $quanlynhanvien = $_GET['quanlynhanvien'];
}

$obj = new database();
$sql = "
    SELECT nv.maNhanVien, nv.chucVu, nv.ngayVaoLam, nv.maNguoiDung, 
           nd.ten, nd.SDT, nd.diaChi, nd.email, tk.password
    FROM nhanvien nv 
    JOIN nguoidung nd ON nv.maNguoiDung = nd.maNguoiDung
    JOIN taikhoan tk ON nd.maNguoiDung = tk.maNguoiDung
";

$nhanvien = $obj->xuatdulieu($sql);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addEmployee'])) {
        $chucVu = $_POST['chucVu'];
        $ngayVaoLam = $_POST['ngayVaoLam'];
        $ten = $_POST['ten'];
        $soDienThoai = $_POST['SDT'];
        $diaChi = $_POST['diaChi'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Thêm password vào

        // Thêm vào bảng nguoidung trước
        $sqlNguoiDung = "
            INSERT INTO nguoidung (ten, SDT, diaChi, email) 
            VALUES ('$ten', '$soDienThoai', '$diaChi', '$email')
        ";

        if ($obj->themdulieu($sqlNguoiDung)) {
            // Lấy mã người dùng vừa thêm
            $maNguoiDung = $obj->layMaNguoiDungMoiNhat(); // Giả sử hàm này lấy mã người dùng mới

            // Thêm vào bảng taikhoan (tạo tài khoản với maNguoiDung đã lấy được)
            $sqlTaiKhoan = "
                INSERT INTO taikhoan (email, password, maNguoiDung) 
                VALUES ('$email', '$password', '$maNguoiDung')
            ";

            if ($obj->themdulieu($sqlTaiKhoan)) {
                // Thêm vào bảng nhanvien
                $sqlNhanVien = "
                    INSERT INTO nhanvien (chucVu, ngayVaoLam, maNguoiDung) 
                    VALUES ('$chucVu', '$ngayVaoLam', '$maNguoiDung')
                ";

                if ($obj->themdulieu($sqlNhanVien)) {
                    $message = "Thêm mới nhân viên thành công";
                } else {
                    $message = "Thêm mới nhân viên thất bại";
                }
            } else {
                $message = "Thêm mới tài khoản thất bại";
            }
        } else {
            $message = "Thêm mới nhân viên thất bại";
        }
    }





    if (isset($_POST['btXoa'])) {
        $maNhanVien = $_POST['btXoa'];

        // Lấy mã người dùng từ nhân viên
        $sqlNguoiDung = "SELECT maNguoiDung FROM nhanvien WHERE maNhanVien='$maNhanVien'";
        $result = $obj->xuatdulieu($sqlNguoiDung);

        if ($result) {
            $maNguoiDung = $result[0]['maNguoiDung'];

            // Xóa tài khoản liên quan
            $sqlXoaTaiKhoan = "DELETE FROM taikhoan WHERE maNguoiDung='$maNguoiDung'";
            $obj->xoadulieu($sqlXoaTaiKhoan);

            // Xóa nhân viên
            $sqlXoaNhanVien = "DELETE FROM nhanvien WHERE maNhanVien='$maNhanVien'";
            if ($obj->xoadulieu($sqlXoaNhanVien)) {
                // Xóa người dùng
                $sqlXoaNguoiDung = "DELETE FROM nguoidung WHERE maNguoiDung='$maNguoiDung'";
                if ($obj->xoadulieu($sqlXoaNguoiDung)) {
                    $message = "Xóa nhân viên thành công";
                } else {
                    $message = "Xóa người dùng thất bại";
                }
            } else {
                $message = "Xóa nhân viên thất bại";
            }
        } else {
            $message = "Không tìm thấy nhân viên cần xóa";
        }
    }



    if (isset($_POST['btSua'])) {
        // Lấy các giá trị từ $_POST
        $maNhanVien = $_POST['maNhanVien'];
        $chucVu = $_POST['chucVu'];
        $ngayVaoLam = $_POST['ngayVaoLam'];
        $hoTen = $_POST['ten'];
        $soDienThoai = $_POST['SDT'];
        $diaChi = $_POST['diaChi'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Lấy mã người dùng từ nhân viên trước khi cập nhật
        $sqlNguoiDung = "SELECT maNguoiDung FROM nhanvien WHERE maNhanVien='$maNhanVien'";
        $result = $obj->xuatdulieu($sqlNguoiDung);

        if ($result && isset($result[0]['maNguoiDung'])) {
            $maNguoiDung = $result[0]['maNguoiDung'];

            // Cập nhật bảng nhanvien
            $sqlNhanVien = "
                UPDATE nhanvien 
                SET chucVu='$chucVu', ngayVaoLam='$ngayVaoLam' 
                WHERE maNhanVien='$maNhanVien'
            ";

            // Cập nhật bảng nguoidung
            $sqlNguoiDungUpdate = "
                UPDATE nguoidung 
                SET ten='$hoTen', SDT='$soDienThoai', diaChi='$diaChi', email='$email' 
                WHERE maNguoiDung='$maNguoiDung'
            ";

            // Cập nhật bảng taikhoan
            $sqlTaiKhoan = "
                UPDATE taikhoan 
                SET email='$email', password='$password'
                WHERE maNguoiDung='$maNguoiDung'
            ";

            // Thực hiện cập nhật
            $updateNhanVien = $obj->suadulieu($sqlNhanVien);
            $updateNguoiDung = $obj->suadulieu($sqlNguoiDungUpdate);
            $updateTaiKhoan = $obj->suadulieu($sqlTaiKhoan);

            if ($updateNhanVien && $updateNguoiDung && $updateTaiKhoan) {
                $message = "Cập nhật nhân viên thành công";
            } else {
                $message = "Cập nhật nhân viên thất bại";
            }
        } else {
            $message = "Không tìm thấy mã người dùng cho nhân viên này";
        }
    }
}




?>

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

    .modal.show {
        display: block !important;
        /* Đảm bảo modal hiển thị */
    }

    .modal-dialog {
        position: fixed !important;
        top: 10% !important;
        left: 50% !important;
        transform: translate(-50%, -10%) !important;
        margin: 0 !important;
        z-index: 1055 !important;
        max-width: 800px;
        width: 90%;

    }

    .modal-body {
        overflow-y: auto;
        max-height: 70vh;
        padding: 2rem;
    }



    .modal-footer {
        justify-content: center;
    }

    .form-control {
        height: auto;
        padding: 0.75rem 1rem;
    }
</style>
<script>
    // Show alert message if exists
    <?php if ($message): ?>
        alert("<?= $message ?>");
        window.location.href = "indexAdmin.php?quanlynhanvien"; // Redirect after alert
    <?php endif; ?>
</script>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="strpied-tabled-with-hover">
                    <div class="card-header bg-white">
                        <h4 class="card-title text-center">DANH SÁCH NHÂN VIÊN</h4>
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#modalAddEmployee"><i class="fa fa-plus-circle"></i>Thêm
                            mới</button>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Mã Nhân Viên</th>
                                    <th>Họ Tên</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Địa Chỉ</th>
                                    <th>Email</th>
                                    <th>Chức Vụ</th>
                                    <th>Ngày Vào Làm</th>
                                    <th>Thao Tác</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($nhanvien as $item): ?>
                                        <tr>
                                            <td><?= $item["maNhanVien"] ?></td>
                                            <td><?= $item["ten"] ?></td>
                                            <td><?= $item["SDT"] ?></td>
                                            <td><?= $item["diaChi"] ?></td>
                                            <td><?= $item["email"] ?></td>
                                            <td><?= $item["chucVu"] ?></td>
                                            <td><?= $item["ngayVaoLam"] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#modalEditEmployee"
                                                    onclick="
                                                        document.getElementById('maNhanVienEdit').value='<?= $item['maNhanVien'] ?>'; 
                                                        document.getElementById('EditChucVu').value='<?= $item['chucVu'] ?>';
                                                        document.getElementById('tenEdit').value='<?= $item['ten'] ?>';
                                                        document.getElementById('SDTEdit').value='<?= $item['SDT'] ?>';
                                                        document.getElementById('diaChiEdit').value='<?= $item['diaChi'] ?>';
                                                        document.getElementById('emailEdit').value='<?= $item['email'] ?>';
                                                        document.getElementById('passwordEdit').value='<?= $item['password'] ?>';
                                                        document.getElementById('ngayVaoLamEdit').value='<?= $item['ngayVaoLam'] ?>';">
                                                    Sửa
                                                </button>

                                                <button
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này không?')"
                                                    type="submit" name="btXoa" value="<?= $item["maNhanVien"] ?>"
                                                    class="btn btn-danger">Xóa</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Thêm Nhân Viên -->
        <div class="modal fade" id="modalAddEmployee" tabindex="-1" aria-labelledby="modalAddEmployeeLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modalAddEmployeeLabel">THÊM NHÂN VIÊN MỚI</h3>

                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="ten" class="form-label">Họ và Tên</label>
                                <input type="text" class="form-control" id="ten" name="ten" required>
                            </div>
                            <div class="mb-3">
                                <label for="SDT" class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control" id="SDT" name="SDT" required>
                            </div>
                            <div class="mb-3">
                                <label for="diaChi" class="form-label">Địa Chỉ</label>
                                <input type="text" class="form-control" id="diaChi" name="diaChi" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật Khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="chucVu" class="form-label">Chức Vụ</label>
                                <input type="text" class="form-control" id="chucVu" name="chucVu" required>
                            </div>
                            <div class="mb-3">
                                <label for="ngayVaoLam" class="form-label">Ngày Vào Làm</label>
                                <input type="date" class="form-control" id="ngayVaoLam" name="ngayVaoLam" required>
                            </div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" name="addEmployee" style="float: right;">Thêm
                                Nhân Viên</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal Sửa Nhân Viên -->
        <div class="modal fade" id="modalEditEmployee" tabindex="-1" aria-labelledby="modalEditEmployeeLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="modalEditEmployeeLabel">CẬP NHẬT THÔNG TIN NHÂN VIÊN</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <input type="hidden" id="maNhanVienEdit" name="maNhanVien">
                            <div class="mb-3">
                                <label for="tenEdit" class="form-label">Họ và Tên</label>
                                <input type="text" class="form-control" id="tenEdit" name="ten" required>
                            </div>
                            <div class="mb-3">
                                <label for="SDTEdit" class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control" id="SDTEdit" name="SDT" required>
                            </div>
                            <div class="mb-3">
                                <label for="diaChiEdit" class="form-label">Địa Chỉ</label>
                                <input type="text" class="form-control" id="diaChiEdit" name="diaChi" required>
                            </div>
                            <div class="mb-3">
                                <label for="emailEdit" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailEdit" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="passwordEdit" class="form-label">Mật Khẩu</label>
                                <input type="password" class="form-control" id="passwordEdit" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="EditChucVu" class="form-label">Chức Vụ</label>
                                <input type="text" class="form-control" id="EditChucVu" name="chucVu" required>
                            </div>
                            <div class="mb-3">
                                <label for="ngayVaoLamEdit" class="form-label">Ngày Vào Làm</label>
                                <input type="date" class="form-control" id="ngayVaoLamEdit" name="ngayVaoLam" required>
                            </div>
                            <button type="button" class="btn btn-danger " data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" style="float: right;" name="btSua">Cập
                                Nhật</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>