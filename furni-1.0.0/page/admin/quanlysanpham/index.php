<?php
if (!isset($_GET['quanlysanpham'])) {
    $quanlysanpham = 1;
} else {
    $quanlysanpham = intval($_GET['quanlysanpham']);
}

$obj = new database();
$results_per_page = 5; // Số sản phẩm hiển thị trên mỗi trang

// Lấy tổng số sản phẩm
$sql = "SELECT COUNT(*) as total FROM sach";
$result = $obj->xuatdulieu($sql);
$total_products = $result[0]['total']; // Tổng số sản phẩm
$number_of_page = ceil($total_products / $results_per_page); // Tính số trang
// Cập nhật biến $page_first_result để đảm bảo nó không âm
$page_first_result = max(0, ($quanlysanpham - 1) * $results_per_page); // Đảm bảo giá trị không âm

// Lấy danh sách sản phẩm cho trang hiện tại
$sql = "SELECT * FROM sach LIMIT $page_first_result, $results_per_page";
$sach = $obj->xuatdulieu($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addCategory'])) {
        $tuaDe = $_POST['tuaDe'];
        $giaThue = $_POST['giaThue'];
        $tienCoc = $_POST['tienCoc'];
        $maISBN = $_POST['maISBN'];
        $ngayXB = $_POST['ngayXB'];
        $moTa = $_POST['moTa'];
        $tinhTrang = $_POST['tinhTrang'];
        $maDauSach = $_POST['maDauSach'];

        // Kiểm tra điều kiện giá thuê và tiền cọc
        if ($giaThue <= 0 || !is_numeric($giaThue) || $tienCoc <= 0 || !is_numeric($tienCoc)) {
            $message = "Giá thuê và tiền cọc phải là số lớn hơn 0.";
        } else {
            // Thêm sách vào cơ sở dữ liệu
            $sql = "INSERT INTO sach (tuaDe, giaThue, tienCoc, maISBN, ngayXB, moTa, tinhTrang, maDauSach) 
                    VALUES ('$tuaDe', '$giaThue', '$tienCoc', '$maISBN', '$ngayXB', '$moTa', '$tinhTrang', '$maDauSach')";
            if ($obj->themdulieu($sql)) {
                // Cập nhật tongSoLuong của đầu sách
                $updateSQL = "UPDATE dausach SET tongSoLuong = tongSoLuong + 1 WHERE maDauSach = '$maDauSach'";
                $obj->suadulieu($updateSQL);
                $message = "Thêm mới sách thành công";
            } else {
                $message = "Thêm mới sách thất bại";
            }
        }
    }



    if (isset($_POST['btXoa'])) {
        $maSach = $_POST['btXoa'];

        // Lấy mã đầu sách của sách cần xóa
        $currentData = $obj->xuatdulieu("SELECT maDauSach FROM sach WHERE maSach = '$maSach'");
        $maDauSach = $currentData[0]['maDauSach'];

        // Xóa sách
        $sql = "DELETE FROM sach WHERE maSach = '$maSach'";
        if ($obj->xoadulieu($sql)) {
            // Giảm tongSoLuong cho đầu sách
            $updateSQL = "UPDATE dausach SET tongSoLuong = tongSoLuong - 1 WHERE maDauSach = '$maDauSach'";
            $obj->suadulieu($updateSQL);

            $message = "Xóa sách thành công";
        } else {
            $message = "Xóa sách thất bại";
        }
    }


    if (isset($_POST['btSua'])) {
        $maSach = $_POST['maSach'];
        $tuaDe = $_POST['tuaDe'];
        $giaThue = $_POST['giaThue'];
        $tienCoc = $_POST['tienCoc'];
        $maISBN = $_POST['maISBN'];
        $ngayXB = $_POST['ngayXB'];
        $moTa = $_POST['moTa'];
        $tinhTrang = $_POST['tinhTrang'];
        $maDauSach = $_POST['maDauSach'];

        // Kiểm tra điều kiện giá thuê và tiền cọc
        if ($giaThue <= 0 || !is_numeric($giaThue) || $tienCoc <= 0 || !is_numeric($tienCoc)) {
            $message = "Giá thuê và tiền cọc phải là số lớn hơn 0.";
        } else {
            // Lấy mã đầu sách cũ
            $oldMaDauSachSQL = "SELECT maDauSach, tinhTrang FROM sach WHERE maSach = '$maSach'";
            $oldData = $obj->xuatdulieu($oldMaDauSachSQL);
            $oldMaDauSach = $oldData[0]['maDauSach'];
            $oldTinhTrang = $oldData[0]['tinhTrang'];

            if ($oldTinhTrang != "Con sach" && $tinhTrang != $oldTinhTrang) {
                $message = "Sách ở tình trạng này không thể sửa !";
            } else {
                $sql = "UPDATE sach SET tuaDe = '$tuaDe', giaThue='$giaThue', tienCoc='$tienCoc', maISBN='$maISBN', 
                        ngayXB='$ngayXB', moTa='$moTa', tinhTrang='$tinhTrang', maDauSach='$maDauSach' WHERE maSach='$maSach'";
                if ($obj->suadulieu($sql)) {
                    if ($oldMaDauSach != $maDauSach) {
                        $reduceSQL = "UPDATE dausach SET tongSoLuong = tongSoLuong - 1 WHERE maDauSach = '$oldMaDauSach'";
                        $obj->suadulieu($reduceSQL);
                        $increaseSQL = "UPDATE dausach SET tongSoLuong = tongSoLuong + 1 WHERE maDauSach = '$maDauSach'";
                        $obj->suadulieu($increaseSQL);
                    }
                    $message = "Cập nhật sách thành công";
                } else {
                    $message = "Cập nhật sách thất bại";
                }
            }
        }
    }


}


?>
<script>
    // Show alert message if exists
    <?php if ($message): ?>
        alert("<?= $message ?>");
        window.location.href = "indexAdmin.php?quanlysanpham"; // Redirect after alert
    <?php endif; ?>
</script>
<style>
    .card.strpied-tabled-with-hover {
        border-radius: 15px;
        overflow: hidden;
    }



    .card.strpied-tabled-with-hover .table thead {
        background-color: #f8f9fa;
    }

    .pagination {
        display: flex;
        justify-content: center;
    }

    .pagination a {
        margin: 0 5px;
        padding: 5px 10px;
        background-color: #f1f1f1;
        color: #333;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #9370DB;
        /* Màu tím */
        color: white;
    }

    .pagination a:hover:not(.active) {
        background-color: #D8BFD8;
        /* Màu tím nhạt hơn */
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

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class=" strpied-tabled-with-hover bg-white">
                    <div class="card-header bg-white">
                        <h3 class="card-title text-center ">DANH SÁCH SÁCH</h3>
                        <button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal"><i
                                class="fa fa-plus-circle"></i>Thêm
                            mới</button>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th><b>Mã Sách</b></th>
                                    <th style="width: 150px;"><b>Tựa Đề</b></th>
                                    <th><b>Giá Thuê</b></th>
                                    <th><b>Tiền Cọc</b></th>
                                    <th><b>Mã ISBN</b></th>
                                    <th><b>Ngày XB</b></th>
                                    <th style="width: 250px; text-align: justify;"><b>Mô Tả</b></th>
                                    <th><b>Tình Trạng</b></th>
                                    <th><b>Mã Đầu Sách</b></th>
                                    <th><b>Thao Tác</b></th>
                                </thead>
                                <tbody>
                                    <?php foreach ($sach as $item): ?>
                                        <tr>
                                            <td><?= $item["maSach"] ?></td>
                                            <td><?= $item["tuaDe"] ?></td>
                                            <td><?= $item["giaThue"] ?></td>
                                            <td><?= $item["tienCoc"] ?></td>
                                            <td><?= $item["maISBN"] ?></td>
                                            <td><?= $item["ngayXB"] ?></td>
                                            <td><?= $item["moTa"] ?></td>
                                            <td><?= $item["tinhTrang"] ?></td>
                                            <td><?= $item["maDauSach"] ?></td>
                                            <td>
                                                <div class="thao-tac">
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#editCategoryModal"
                                                        onclick="loadEditForm('<?= $item['maSach'] ?>', '<?= $item['tuaDe'] ?>', '<?= $item['giaThue'] ?>', 
                                                        '<?= $item['tienCoc'] ?>', '<?= $item['maISBN'] ?>', '<?= $item['ngayXB'] ?>', 
                                                        '<?= $item['moTa'] ?>', '<?= $item['tinhTrang'] ?>', '<?= $item['maDauSach'] ?>')">
                                                        Sửa
                                                    </button>
                                                    <script>
                                                        // JavaScript để kiểm tra tình trạng sách và cập nhật trạng thái các trường
                                                        function loadEditForm(maSach, tuaDe, giaThue, tienCoc, maISBN, ngayXB, moTa, tinhTrang, maDauSach) {
                                                            document.getElementById('editMaSach').value = maSach;
                                                            document.getElementById('editTuaDe').value = tuaDe;
                                                            document.getElementById('editGiaThue').value = giaThue;
                                                            document.getElementById('editTienCoc').value = tienCoc;
                                                            document.getElementById('editMaISBN').value = maISBN;
                                                            document.getElementById('editNgayXB').value = ngayXB;
                                                            document.getElementById('editMoTa').value = moTa;
                                                            document.getElementById('editTinhTrang').value = tinhTrang;
                                                            document.getElementById('editMaDauSach').value = maDauSach;

                                                            // Kiểm tra tình trạng sách
                                                            const isEditable = tinhTrang === "Con sach";

                                                            // Nếu tình trạng không phải là "Còn sách", khóa các trường
                                                            document.getElementById('editTuaDe').disabled = !isEditable;
                                                            document.getElementById('editGiaThue').disabled = !isEditable;
                                                            document.getElementById('editTienCoc').disabled = !isEditable;
                                                            document.getElementById('editMaISBN').disabled = !isEditable;
                                                            document.getElementById('editNgayXB').disabled = !isEditable;
                                                            document.getElementById('editMoTa').disabled = !isEditable;
                                                            document.getElementById('editMaDauSach').disabled = !isEditable;

                                                            // Hiển thị thông báo
                                                            document.getElementById('btnConfirmEdit').disabled = !isEditable;
                                                            if (!isEditable) {
                                                                alert('Sách ở tình trạng này không thể sửa !');
                                                            }
                                                        }

                                                    </script>
                                                    <button
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')"
                                                        type="submit" name="btXoa" value="<?= $item["maSach"] ?>"
                                                        class="btn btn-danger">Xóa</button>
                                                </div>
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


        <!-- Phân trang -->
        <div class="pagination" style="text-align: center; margin-top: 20px;">
            <?php for ($i = 1; $i <= $number_of_page; $i++): ?>
                <?php if ($i == $quanlysanpham): ?>
                    <a class="active" href="indexAdmin.php?quanlysanpham=<?= $i ?>"><?= $i ?></a>
                <?php else: ?>
                    <a href="indexAdmin.php?quanlysanpham=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

        <!-- Modal Thêm Sản Phẩm -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="POST" id="addCategoryForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">THÊM SẢN PHẨM MỚI</h3>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tuaDe" class="form-label">Tựa đề</label>
                                    <input type="text" class="form-control" name="tuaDe" id="tuaDe" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="giaThue" class="form-label">Giá thuê</label>
                                    <input type="number" class="form-control" name="giaThue" id="giaThue" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tienCoc" class="form-label">Tiền cọc</label>
                                    <input type="number" class="form-control" name="tienCoc" id="tienCoc" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="maISBN" class="form-label">Mã ISBN</label>
                                    <input type="text" class="form-control" name="maISBN" id="maISBN" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ngayXB" class="form-label">Ngày XB</label>
                                    <input type="date" class="form-control" name="ngayXB" id="ngayXB" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tinhTrang" class="form-label">Tình Trạng</label>
                                    <input type="text" class="form-control" name="tinhTrang" id="tinhTrang"
                                        value="Con sach" readonly>
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="moTa" class="form-label">Mô Tả</label>
                                <textarea class="form-control" name="moTa" id="moTa" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="maDauSach" class="form-label">Mã Đầu Sách</label>
                                <select name="maDauSach" class="form-control" style="height: 50px;" required>
                                    <option value="">- Chọn Đầu Sách -</option>
                                    <?php echo $obj->selectdausach(); ?>
                                </select>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" name="addCategory">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Modal Sửa Sản Phẩm -->
        <div id="editCategoryModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="POST" id="editCategoryForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">CẬP NHẬT THÔNG TIN SẢN PHẨM</h3>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="maSach" id="editMaSach">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editTuaDe" class="form-label">Tựa Đề</label>
                                    <input type="text" class="form-control" name="tuaDe" id="editTuaDe" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editGiaThue" class="form-label">Giá Thuê</label>
                                    <input type="text" class="form-control" name="giaThue" id="editGiaThue" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" col-md-6 mb-3">
                                    <label for="editTienCoc" class="form-label">Tiền Cọc</label>
                                    <input type="text" class="form-control" name="tienCoc" id="editTienCoc" required>
                                </div>
                                <div class=" col-md-6 mb-3">
                                    <label for="editMaISBN" class="form-label">Mã ISBN</label>
                                    <input type="text" class="form-control" name="maISBN" id="editMaISBN" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editNgayXB" class="form-label">Ngày XB</label>
                                    <input type="date" class="form-control" name="ngayXB" id="editNgayXB" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editTinhTrang" class="form-label">Tình Trạng</label>
                                    <input type="text" class="form-control" name="tinhTrang" id="editTinhTrang" required
                                        readonly>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="editMoTa" class="form-label">Mô Tả</label>
                                <textarea class="form-control" name="moTa" id="editMoTa" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editMaDauSach" class="form-label">Mã Đầu Sách</label>
                                <select name="maDauSach" id="editMaDauSach" class="form-control" style="height: 50px;"
                                    required>
                                    <option value="">- Chọn mã đầu sách -</option>
                                    <?php echo $obj->selectdausach(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                            <button type="submit" name="btSua" class="btn btn-primary" id="btnConfirmEdit">Xác
                                nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            // Validate form trước khi submit
            function validateForm(formId) {
                const form = document.getElementById(formId);
                const giaThue = parseFloat(form.querySelector('[name="giaThue"]').value);
                const tienCoc = parseFloat(form.querySelector('[name="tienCoc"]').value);

                if (isNaN(giaThue) || giaThue <= 0 || isNaN(tienCoc) || tienCoc <= 0) {
                    alert("Giá thuê và tiền cọc phải là số lớn hơn 0.");
                    return false; // Ngăn submit
                }
                return true; // Tiếp tục submit
            }

            // Gắn sự kiện validate vào form
            document.getElementById('addCategoryForm').onsubmit = function () {
                return validateForm('addCategoryForm');
            };

            document.getElementById('editCategoryForm').onsubmit = function () {
                return validateForm('editCategoryForm');
            };
        </script>

    </div>
</div>