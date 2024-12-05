<?php
if (!isset($_GET['quanlydanhmuc'])) {
    $quanlydanhmuc = 1;
} else {
    $quanlydanhmuc = $_GET['quanlydanhmuc'];
}

$obj = new database();
$sql = "SELECT * FROM danhmuc";
$danhmuc = $obj->xuatdulieu($sql);


$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addCategory'])) {
        $ten = $_POST['ten'];
        $moTa = $_POST['moTa'];
        $sql = "INSERT INTO danhmuc (ten, moTa) VALUES ('$ten', '$moTa')";
        if ($obj->themdulieu($sql)) {
            $message = "Thêm mới danh mục thành công";
        } else {
            $message = "Thêm mới danh mục thất bại";
        }
    }

    if (isset($_POST['btXoa'])) {
        $maDM = $_POST['btXoa'];
        $sql = "DELETE FROM danhmuc WHERE maDM='$maDM'";
        $result = $obj->xoadulieu($sql);

        if ($result === true) {
            $message = "Xóa danh mục thành công";
        } else {
            // Kiểm tra nếu lỗi liên quan đến khóa ngoại
            if (str_contains($result, 'a foreign key constraint fails')) {
                $message = "Không thể xóa danh mục ! Đầu sách thuộc danh mục vẫn tồn tại.";
            } else {
                $message = "Lỗi khi xóa danh mục: " . $result;
            }
        }
    }




    if (isset($_POST['btSua'])) {
        $maDM = $_POST['maDM'];
        $ten = $_POST['ten'];
        $moTa = $_POST['moTa'];
        $sql = "UPDATE danhmuc SET ten='$ten', moTa='$moTa' WHERE maDM='$maDM'";
        if ($obj->suadulieu($sql)) {
            $message = "Cập nhật danh mục thành công";
        } else {
            $message = "Cập nhật danh mục thất bại";
        }
    }
}

?>
<script>
    // Show alert message if exists
    <?php if ($message): ?>
        alert("<?= $message ?>");
        window.location.href = "indexAdmin.php?quanlydanhmuc"; // Redirect after alert
    <?php endif; ?>
</script>
<style>
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
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 ">
                <div class=" strpied-tabled-with-hover bg-white ">
                    <div class="card-header bg-white">
                        <h4 class="card-title text-center">DANH SÁCH DANH MỤC SÁCH</h4>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i
                                class="fa fa-plus-circle"></i>Thêm
                            mới</button>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Mã Danh Mục</th>
                                    <th>Tên Danh Mục</th>
                                    <th>Mô Tả</th>
                                    <th>Thao Tác</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($danhmuc as $item): ?>
                                        <tr>
                                            <td><?= $item["maDM"] ?></td>
                                            <td><?= $item["ten"] ?></td>
                                            <td><?= $item["moTa"] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editCategoryModal"
                                                    onclick="document.getElementById('editMaDM').value='<?= $item['maDM'] ?>'; 
                                                              document.getElementById('editTen').value='<?= $item['ten'] ?>'; 
                                                              document.getElementById('editMoTa').value='<?= $item['moTa'] ?>';">
                                                    Sửa
                                                </button>
                                                <button
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')"
                                                    type="submit" name="btXoa" value="<?= $item["maDM"] ?>"
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
                            <h3 class="modal-title text-center">THÊM DANH MỤC MỚI</h3>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="ten" class="form-label">Tên Danh Mục</label>
                                <input type="text" class="form-control" name="ten" id="ten" required>
                            </div>
                            <div class="mb-3">
                                <label for="moTa" class="form-label">Mô Tả</label>
                                <textarea class="form-control" name="moTa" id="moTa"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" name="addCategory">Thêm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Sửa Danh Mục -->
        <div id="editCategoryModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="POST" id="editCategoryForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">SỬA DANH MỤC</h3>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="maDM" id="editMaDM">
                            <div class="mb-3">
                                <label for="editTen" class="form-label">Tên Danh Mục</label>
                                <input type="text" class="form-control" name="ten" id="editTen" required>
                            </div>
                            <div class="mb-3">
                                <label for="editMoTa" class="form-label">Mô Tả</label>
                                <textarea class="form-control" name="moTa" id="editMoTa"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                            <button type="submit" name="btSua" class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>