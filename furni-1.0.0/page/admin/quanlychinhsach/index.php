<?php
if (!isset($_GET['quanlychinhsach'])) {
    $quanlychinhsach = 1;
} else {
    $quanlychinhsach = (int) $_GET['quanlychinhsach'];
}
$obj = new database();
$limit = 5;
$start = max(0, ($quanlychinhsach - 1) * $limit);
$sql = "SELECT * FROM chinhsach LIMIT $start, $limit";
$chinhsach = $obj->xuatdulieu($sql);
$sqlTotal = "SELECT COUNT(*) as total FROM chinhsach";
$totalPolicies = $obj->xuatdulieu($sqlTotal);
$totalPolicies = $totalPolicies[0]['total'];
$totalPages = ceil($totalPolicies / $limit);

// Xử lý thêm, sửa, xóa chính sách
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Thêm chính sách
    if (isset($_POST['addPolicy'])) {
        $ten = $_POST['ten'];
        $noiDung = $_POST['noiDung'];
        $sql = "INSERT INTO chinhsach (ten, noiDung) VALUES ('$ten', '$noiDung')";
        if ($obj->themdulieu($sql)) {
            $message = "Thêm mới chính sách thành công";
        } else {
            $message = "Thêm mới chính sách thất bại";
        }
    }
    // Xóa chính sách
    if (isset($_POST['btXoa'])) {
        $maChinhSach = $_POST['btXoa'];
        $sql = "DELETE FROM chinhsach WHERE maChinhSach='$maChinhSach'";
        $obj->xoadulieu($sql);
        $message = "Xóa thành công";
    }
    // Sửa chính sách
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
<style>
    .modal-dialog {
        max-width: 800px;
        width: 100%;
    }

    .modal-content {
        max-height: 80vh;
        height: 60vh;
        overflow-y: auto;
    }

    .modal-dialog-centered {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    textarea {
        height: 150px;
        resize: vertical;
    }

    .textarea-large {
        height: 110px;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class=" strpied-tabled-with-hover bg-white">
                    <div class="card-header bg-white">
                        <h4 class="card-title text-center">DANH SÁCH CHÍNH SÁCH</h4>
                        <button type="button" class="btn btn-success btn-lg" data-toggle="modal"
                            data-target="#addPolicyModal">
                            <i class="fa fa-plus-circle"></i> Thêm mới
                        </button>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Mã Chính Sách</th>
                                    <th>Tên</th>
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
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editPolicyModal"
                                                    onclick="editPolicy(<?= htmlspecialchars(json_encode($item)) ?>)">
                                                    Sửa
                                                </button>
                                                <button type="submit" name="btXoa" value="<?= $item["maChinhSach"] ?>"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa chính sách này không?')">Xóa</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="pagination text-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?quanlychinhsach=<?= $i ?>" class="btn btn-info"><?= $i ?></a>
                        <?php endfor; ?>
                    </div>
                </div>
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
                    <h3 class="modal-title text-center">THÊM CHÍNH SÁCH MỚI</h3>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ten" class="form-label">Tên Chính Sách</label>
                        <input type="text" class="form-control" name="ten" required>
                    </div>
                    <div class="mb-3">
                        <label for="noiDung" class="form-label">Nội Dung</label>
                        <textarea class="form-control textarea-large" name="noiDung" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="addPolicy" class="btn btn-primary">Thêm</button>
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
                </div>
                <div class="modal-body">
                    <input type="hidden" name="maChinhSach" id="editMaChinhSach">
                    <div class="mb-3">
                        <label for="editTen" class="form-label">Tên Chính Sách</label>
                        <input type="text" class="form-control" name="ten" id="editTen" required>
                    </div>
                    <div class="mb-3">
                        <label for="editNoiDung" class="form-label">Nội Dung</label>
                        <textarea class="form-control textarea-large" name="noiDung" id="editNoiDung"
                            required></textarea>
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
<script>
    function editPolicy(item) {
        document.getElementById('editMaChinhSach').value = item.maChinhSach;
        document.getElementById('editTen').value = item.ten;
        document.getElementById('editNoiDung').value = item.noiDung;
    }
</script>