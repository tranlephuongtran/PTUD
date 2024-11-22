<?php
if (!isset($_GET['quanlychinhsach'])) {
    $quanlychinhsach = 1;
} else {
    $quanlychinhsach = $_GET['quanlychinhsach'];
}

$obj = new database();
$sql = "SELECT * FROM chinhsach";
$chinhsach = $obj->xuatdulieu($sql);

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addPolicy'])) {
        $ten = $_POST['ten'];
        $noiDung = $_POST['noiDung'];
        $sql = "INSERT INTO chinhsach (ten, noiDung) VALUES ('$ten', '$noiDung')";
        if ($obj->themdulieu($sql)) {
            $message = "Thêm chính sách thành công";
        } else {
            $message = "Thêm chính sách thất bại";
        }
    }

    if (isset($_POST['btXoa'])) {
        $maChinhSach = $_POST['btXoa'];
        $sql = "DELETE FROM chinhsach WHERE maChinhSach='$maChinhSach'";
        $obj->xoadulieu($sql);
        $message = "Xóa chính sách thành công";
    }

    if (isset($_POST['btSua'])) {
        $maChinhSach = $_POST['maChinhSach'];
        $ten = $_POST['ten'];
        $noiDung = $_POST['noiDung'];
        $sql = "UPDATE chinhsach SET ten='$ten', noiDung='$noiDung' WHERE maChinhSach='$maChinhSach'";
        if ($obj->suadulieu($sql)) {
            $message = "Cập nhật chính sách thành công";
        } else {
            $message = "Cập nhật chính sách thất bại";
        }
    }
}
?>

<script>
    <?php if ($message): ?>
        alert("<?= $message ?>");
        window.location.href = "indexAdmin.php?quanlychinhsach";
    <?php endif; ?>
</script>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header">
                        <h4 class="card-title text-center">DANH SÁCH CHÍNH SÁCH</h4>
                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#addPolicyModal"><i class="fa fa-plus-circle"></i> Thêm mới</button>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Mã Chính Sách</th>
                                    <th>Tên Chính Sách</th>
                                    <th>Nội Dung</th>
                                    <th>Thao Tác</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($chinhsach as $item): ?>
                                        <tr>
                                            <td><?= $item["maChinhSach"] ?></td>
                                            <td><?= $item["ten"] ?></td>
                                            <td><?= $item["noiDung"] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editPolicyModal"
                                                    onclick="document.getElementById('editMaChinhSach').value='<?= $item['maChinhSach'] ?>';
                                                             document.getElementById('editTen').value='<?= $item['ten'] ?>';
                                                             document.getElementById('editNoiDung').value='<?= $item['noiDung'] ?>';">
                                                    Sửa
                                                </button>
                                                <button onclick="return confirm('Bạn có chắc chắn muốn xóa chính sách này không?')"
                                                        type="submit" name="btXoa" value="<?= $item["maChinhSach"] ?>" class="btn btn-danger">
                                                    Xóa
                                                </button>
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

        <!-- Modal Thêm Chính Sách -->
        <div id="addPolicyModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">THÊM CHÍNH SÁCH</h3>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="ten" class="form-label">Tên Chính Sách</label>
                                <input type="text" class="form-control" name="ten" id="ten" required>
                            </div>
                            <div class="mb-3">
                                <label for="noiDung" class="form-label">Nội Dung</label>
                                <textarea class="form-control" name="noiDung" id="noiDung"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" name="addPolicy">Thêm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Sửa Chính Sách -->
        <div id="editPolicyModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">SỬA CHÍNH SÁCH</h3>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="maChinhSach" id="editMaChinhSach">
                            <div class="mb-3">
                                <label for="editTen" class="form-label">Tên Chính Sách</label>
                                <input type="text" class="form-control" name="ten" id="editTen" required>
                            </div>
                            <div class="mb-3">
                                <label for="editNoiDung" class="form-label">Nội Dung</label>
                                <textarea class="form-control" name="noiDung" id="editNoiDung"></textarea>
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
