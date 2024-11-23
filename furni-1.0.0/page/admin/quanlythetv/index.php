<?php
if (!isset($_GET['quanlythetv'])) {
    $quanlythetv = 1;
} else {
    $quanlythetv = $_GET['quanlythetv'];
}

$obj = new database();
$sql = "SELECT * FROM thethanhvien";
$thethanhvien = $obj->xuatdulieu($sql);

// Xử lý cập nhật danh mục
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addMember'])) {
        $maThe = $_POST['maThe'];
        $hoTen = $_POST['hoTen'];
        $email = $_POST['email'];
        $sql = "INSERT INTO thethanhvien (maThe, hoTen, email) VALUES ('$maThe','$hoTen', '$email')";
        if ($obj->themdulieu($sql)) {
            $message = "Thêm mới thẻ thành viên thành công";
        } else {
            $message = "Thêm mới thẻ thành viên thất bại";
        }
    }
}
?>
<script>
    // Show alert message if exists
    <?php if ($message): ?>
        alert("<?= $message ?>");
        window.location.href = "indexAdmin.php?quanlythetv"; // Redirect after alert
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
                <div class=" strpied-tabled-with-hover">
                    <div class="card-header bg-white">
                        <h4 class="card-title text-center">DANH SÁCH THẺ THÀNH VIÊN</h4>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i
                                class="fa fa-plus-circle"></i>Thêm
                            mới</button>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Mã Thẻ</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($thethanhvien as $item): ?>
                                        <tr>
                                            <td><?= $item["maThe"] ?></td>
                                            <td><?= $item["hoTen"] ?></td>
                                            <td><?= $item["email"] ?></td>
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
                <form method="POST" id="addMemberForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-center">THÊM THẺ THÀNH VIÊN MỚI</h3>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="maThe" class="form-label">Mã thẻ</label>
                                <input type="number" class="form-control" name="maThe" id="maThe" required>
                            </div>
                            <div class="mb-3">
                                <label for="hoTen" class="form-label">Họ và Tên</label>
                                <input type="text" class="form-control" name="hoTen" id="hoTen" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" name="email" id="email"></input>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" name="addMember">Thêm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>