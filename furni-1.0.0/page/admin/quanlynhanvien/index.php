<?php
if (!isset($_GET['quanlynhanvien'])) {
    $quanlynhanvien = 1;
} else {
    $quanlynhanvien = $_GET['quanlynhanvien'];
}

$obj = new database();
$sql = "
    SELECT nv.maNhanVien, nv.chucVu, nv.ngayVaoLam, nv.maNguoiDung, 
           nd.ten, nd.SDT, nd.diaChi, nd.email 
    FROM nhanvien nv 
    JOIN nguoidung nd ON nv.maNguoiDung = nd.maNguoiDung
";

$nhanvien = $obj->xuatdulieu($sql);

// Xử lý cập nhật danh mục
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addEmployee'])) {
        $chucVu = $_POST['chucVu'];
        $ngayVaoLam = $_POST['ngayVaoLam'];
        $maNguoiDung = $_POST['maNguoiDung'];
        $sql = "INSERT INTO nhanvien (chucVu, ngayVaoLam, maNguoiDung ) VALUES ('$chucVu', '$ngayVaoLam', '$maNguoiDung')";
        if ($obj->themdulieu($sql)) {
            echo '<script>alert("Thêm mới Nhân viên thành công");</script>';
        } else {
            echo '<script>alert("Thêm mới Nhân viên thất bại");</script>';
        }
    }

    if (isset($_POST['btXoa'])) {
        $maNhanVien = $_POST['btXoa'];

        // Lấy mã người dùng từ nhân viên
        $sqlNguoiDung = "SELECT maNguoiDung FROM nhanvien WHERE maNhanVien='$maNhanVien'";
        $result = $obj->xuatdulieu($sqlNguoiDung);

        if ($result) {
            $maNguoiDung = $result[0]['maNguoiDung'];

            // Xóa nhân viên trong bảng nhanvien
            $sqlXoaNhanVien = "DELETE FROM nhanvien WHERE maNhanVien='$maNhanVien'";
            if ($obj->xoadulieu($sqlXoaNhanVien)) {
                // (Tùy chọn) Xóa trong bảng nguoidung nếu không muốn giữ thông tin người dùng
                // $sqlXoaNguoiDung = "DELETE FROM nguoidung WHERE maNguoiDung='$maNguoiDung'";
                // $obj->xoadulieu($sqlXoaNguoiDung);

                echo '<script>alert("Xóa Nhân viên thành công");</script>';
            } else {
                echo '<script>alert("Xóa Nhân viên thất bại");</script>';
            }
        } else {
            echo '<script>alert("Không tìm thấy nhân viên cần xóa!");</script>';
        }
    }


    if (isset($_POST['btSua'])) {
        $maNhanVien = $_POST['maNhanVien'];
        $chucVu = $_POST['chucVu'];
        $ngayVaoLam = $_POST['ngayVaoLam'];
        $maNguoiDung = $_POST['maNguoiDung'];
        $hoTen = $_POST['ten'];
        $soDienThoai = $_POST['SDT'];
        $diaChi = $_POST['diaChi'];
        $email = $_POST['email'];

        // Cập nhật bảng nhanvien
        $sqlNhanVien = "
            UPDATE nhanvien 
            SET chucVu='$chucVu', ngayVaoLam='$ngayVaoLam', maNguoiDung='$maNguoiDung' 
            WHERE maNhanVien='$maNhanVien'
        ";

        // Cập nhật bảng nguoidung
        $sqlNguoiDung = "
            UPDATE nguoidung 
            SET ten='$hoTen', SDT='$soDienThoai', diaChi='$diaChi', email='$email' 
            WHERE maNguoiDung='$maNguoiDung'
        ";

        // Thực hiện cập nhật
        if ($obj->suadulieu($sqlNhanVien) && $obj->suadulieu($sqlNguoiDung)) {
            echo '<script>alert("Cập nhật Nhân viên thành công");</script>';
        } else {
            echo '<script>alert("Cập nhật Nhân viên thất bại");</script>';
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
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header">
                        <h4 class="card-title text-center">DANH SÁCH NHÂN VIÊN</h4>
                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal"
                            data-target="#myModal"><i class="fa fa-plus-circle"></i>Thêm
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
                                                    data-target="#editEmployeeModal"
                                                    onclick="document.getElementById('editMaNhanVien').value='<?= $item['maNhanVien'] ?>'; 
                                                    document.getElementById('editChucVu').value='<?= $item['chucVu'] ?>';
                                                    document.getElementById('editHoTen').value='<?= $item['ten'] ?>';
                                                    document.getElementById('editSoDienThoai').value='<?= $item['SDT'] ?>';
                                                    document.getElementById('editDiaChi').value='<?= $item['diaChi'] ?>';
                                                    document.getElementById('editEmail').value='<?= $item['email'] ?>';
                                                    document.getElementById('editNgayVaoLam').value='<?= $item['ngayVaoLam'] ?>';
                                                    document.getElementById('editMaNguoiDung').value='<?= $item['maNguoiDung'] ?>';">
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


        <!-- Modal Thêm Danh Mục -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="POST" id="addCategoryForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">THÊM NHÂN VIÊN MỚI</h3>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="chucVu" class="form-label">Chức Vụ</label>
                                <input type="text" class="form-control" name="chucVu" id="chucVu" required>
                            </div>
                            <div class="mb-3">
                                <label for="ngayVaoLam" class="form-label">Ngày vào làm</label>
                                <input type="date" class="form-control" name="ngayVaoLam" id="ngayVaoLam" required>
                            </div>
                            <div class="mb-3">
                                <label for="maNguoiDung" class="form-label">Mã Người dùng</label>
                                <select name="maNguoiDung" class="form-control" required>
                                    <option value="">- Chọn mã người dùng -</option>
                                    <?php echo $obj->selectnguoidung(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" name="addEmployee">Thêm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Sửa Danh Mục -->
        <div id="editEmployeeModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="POST" id="editEmployeeForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">SỬA NHÂN VIÊN</h3>

                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="maNhanVien" id="editMaNhanVien">
                            <div class="mb-3">
                                <label for="editHoTen" class="form-label">Họ Tên</label>
                                <input type="text" class="form-control" name="ten" id="editHoTen" required>
                            </div>
                            <div class="mb-3">
                                <label for="editSoDienThoai" class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control" name="SDT" id="editSoDienThoai" required>
                            </div>
                            <div class="mb-3">
                                <label for="editDiaChi" class="form-label">Địa Chỉ</label>
                                <input type="text" class="form-control" name="diaChi" id="editDiaChi" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="editEmail" required>
                            </div>

                            <div class="mb-3">
                                <label for="editChucVu" class="form-label">Chức Vụ</label>
                                <input type="text" class="form-control" name="chucVu" id="editChucVu" required>
                            </div>
                            <div class="mb-3">
                                <label for="editNgayVaoLam" class="form-label">Ngày Vào Làm</label>
                                <input type="date" class="form-control" name="ngayVaoLam" id="editNgayVaoLam" required>
                            </div>
                            <div class="mb-3">
                                <label for="editMaNguoiDung" class="form-label">Mã Người dùng</label>
                                <select name="maNguoiDung" id="editMaNguoiDung" class="form-control" required>
                                    <option value="">- Chọn mã người dùng -</option>
                                    <?php echo $obj->selectnguoidung(); ?>
                                </select>
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