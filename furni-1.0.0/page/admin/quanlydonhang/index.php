<?php
if (!isset($_GET['quanlydonhang'])) {
    $quanlydonhang = 1;
} else {
    $quanlydonhang = intval($_GET['quanlydonhang']);
}

$obj = new database();
$results_per_page = 5;
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Lấy tổng số đơn hàng theo bộ lọc
$total_sql = "
    SELECT COUNT(DISTINCT dt.maDon) as total 
    FROM donthuesach dt 
    JOIN chitiethoadon cthd ON dt.maDon = cthd.maDon 
    JOIN sach s ON cthd.maSach = s.maSach 
    JOIN dausach ds ON s.maDauSach = ds.maDauSach
";

if ($filter === 'pending') {
    $total_sql .= " WHERE dt.tinhTrangThanhToan = 'Cho xac nhan'";
} elseif ($filter === 'nopay') {
    $total_sql .= " WHERE dt.tinhTrangThanhToan = 'Chua thanh toan'";
} elseif ($filter === 'pay') {
    $total_sql .= " WHERE dt.tinhTrangThanhToan = 'Da thanh toan'";
}

$total_result = $obj->xuatdulieu($total_sql);
$total_orders = $total_result[0]['total'];
$number_of_page = ceil($total_orders / $results_per_page);
$page_first_result = max(0, ($quanlydonhang - 1) * $results_per_page);

// Lấy danh sách đơn hàng theo bộ lọc và phân trang
$sql = "
    SELECT dt.maDon, dt.phiShip, dt.maKM, dt.tongTienThue, dt.tongTienCoc, dt.hinhAnhThanhToan, dt.tinhTrangThanhToan
    FROM donthuesach dt 
    JOIN chitiethoadon cthd ON dt.maDon = cthd.maDon 
    JOIN sach s ON cthd.maSach = s.maSach 
    JOIN dausach ds ON s.maDauSach = ds.maDauSach
";

if ($filter === 'pending') {
    $sql .= " WHERE dt.tinhTrangThanhToan = 'Cho xac nhan'";
} elseif ($filter === 'nopay') {
    $sql .= " WHERE dt.tinhTrangThanhToan = 'Chua thanh toan'";
} elseif ($filter === 'pay') {
    $sql .= " WHERE dt.tinhTrangThanhToan = 'Da thanh toan'";
}

$sql .= " GROUP BY dt.maDon 
          ORDER BY dt.maDon DESC 
          LIMIT $page_first_result, $results_per_page;";
$donhang = $obj->xuatdulieu($sql);

// Xử lý cập nhật trạng thái đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $maDon = $_POST['maDon'];
    $tinhTrangThanhToan = $_POST['tinhTrangThanhToan'];

    $currentStatusSql = "SELECT tinhTrangThanhToan FROM donthuesach WHERE maDon = '$maDon'";
    $currentStatusResult = $obj->xuatdulieu($currentStatusSql);
    $currentStatus = $currentStatusResult[0]['tinhTrangThanhToan'] ?? '';

    if (
        ($currentStatus === 'Cho xac nhan' && $tinhTrangThanhToan === 'Da thanh toan')
    ) {
        $updateSql = "UPDATE donthuesach SET tinhTrangThanhToan = '$tinhTrangThanhToan' WHERE maDon = '$maDon'";
        $obj->suadulieu($updateSql);
        echo "<script>alert('Cập nhật trạng thái thành công.');</script>";
    } else {
        echo "<script>alert('Cập nhật trạng thái thất bại!');</script>";
    }

    echo "<script>setTimeout(function() {
        window.location.href = 'indexAdmin.php?quanlydonhang=$quanlydonhang&filter=$filter';
    });</script>";
    exit();
}
?>


<style>
    .status-paid {
        color: green;
        /* Màu xanh lá cho "Đã thanh toán" */
        font-weight: bold;
    }

    .status-pending {
        color: red;
        /* Màu đỏ cho "Chờ xác nhận" */
        font-weight: bold;
    }

    .status-unpaid {
        color: orange;
        /* Màu vàng cho "Chưa thanh toán" */
        font-weight: bold;
    }

    /* Các kiểu khác cho modal và bảng nếu cần */
    .modal.show {
        display: block !important;
    }

    .modal-dialog {
        position: fixed !important;
        top: 10% !important;
        left: 50% !important;
        transform: translate(-50%, -10%) !important;
        margin: 0 !important;
        z-index: 1055 !important;
        max-width: 500px;
        width: 90%;
    }

    .modal-body {
        overflow-y: auto;
        max-height: 70vh;
        padding: 2rem;
    }

    .clickable {
        cursor: pointer;
        color: blue;
        text-decoration: underline;
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

    /* Modal image */
    .modal-image {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content-image {
        margin: auto;
        display: block;
        max-width: 80%;
        max-height: 80%;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    .close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
</style>


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="strpied-tabled-with-hover bg-white">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="card-title text-center">DANH SÁCH ĐƠN</h4>
                        <form method="get" action="indexAdmin.php">
                            <input type="hidden" name="quanlydonhang" value="<?= $quanlydonhang ?>">
                            <select name="filter" class="form-control" onchange="this.form.submit()">
                                <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>Tất cả</option>
                                <option value="pending" <?= $filter === 'pending' ? 'selected' : '' ?>>Chờ xác nhận
                                </option>
                                <option value="nopay" <?= $filter === 'nopay' ? 'selected' : '' ?>>Chưa thanh toán</option>
                                <option value="pay" <?= $filter === 'pay' ? 'selected' : '' ?>>Đã thanh toán</option>
                            </select>
                        </form>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><b>Mã Đơn</b></th>
                                        <th><b>Phí Ship</b></th>
                                        <th><b>Mã Ưu Đãi</b></th>
                                        <th><b>Tổng Tiền Thuê</b></th>
                                        <th><b>Tổng Tiền Cọc</b></th>
                                        <th><b>Hình Ảnh</b></th>
                                        <th><b>Trạng Thái</b></th>
                                        <th><b>Chi Tiết</b></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($donhang)): ?>
                                        <?php foreach ($donhang as $order): ?>
                                            <tr>
                                                <td class="clickable"
                                                    onclick="openModal(<?= $order['maDon'] ?>, '<?= $order['tinhTrangThanhToan'] ?>')">
                                                    <?= $order['maDon'] ?>
                                                </td>
                                                <td><?= number_format($order['phiShip'], 0, ',', '.') ?> VND</td>
                                                <td><?= $order['maKM'] ?></td>
                                                <td><?= number_format($order['tongTienThue'], 0, ',', '.') ?> VND</td>
                                                <td><?= number_format($order['tongTienCoc'], 0, ',', '.') ?> VND</td>
                                                <td>
                                                    <?php if (!empty($order['hinhAnhThanhToan'])): ?>
                                                        <img src="layout/images/bills/<?= $order['hinhAnhThanhToan'] ?>"
                                                            alt="Hình thanh toán"
                                                            style="width: 100px; height: auto; cursor: pointer;"
                                                            onclick="openImageModal('layout/images/bills/<?= $order['hinhAnhThanhToan'] ?>')">
                                                    <?php else: ?>
                                                        <span>Chưa có</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span
                                                        class="<?= $order['tinhTrangThanhToan'] === 'Da thanh toan' ? 'status-paid' : ($order['tinhTrangThanhToan'] === 'Cho xac nhan' ? 'status-pending' : 'status-unpaid') ?>">
                                                        <?= $order['tinhTrangThanhToan'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="indexAdmin.php?chitietdonthue&maDon=<?= $order['maDon'] ?>">Xem chi
                                                        tiết</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Không có đơn hàng nào</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>


                    <div class="pagination">
                        <?php for ($i = 1; $i <= $number_of_page; $i++): ?>
                            <a href="indexAdmin.php?quanlydonhang=<?= $i ?>&filter=<?= $filter ?>"
                                class="<?= $i == $quanlydonhang ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                    </div>

                    <!-- Modal and other scripts -->
                    <div id="imageModal" class="modal-image">
                        <span class="close" onclick="closeImageModal()">&times;</span>
                        <img class="modal-content-image" id="modalImage">
                    </div>

                    <script>
                        function openImageModal(src) {
                            var modal = document.getElementById('imageModal');
                            var modalImg = document.getElementById('modalImage');

                            modal.style.display = 'block';
                            modalImg.src = src;
                        }

                        function closeImageModal() {
                            var modal = document.getElementById('imageModal');
                            modal.style.display = 'none';
                        }

                        function openModal(maDon, currentStatus) {
                            document.getElementById('modalMaDon').value = maDon;
                            document.getElementById('tinhTrangThanhToan').value = currentStatus;
                            $('#orderModal').modal('show');
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="orderModalLabel">CẬP NHẬT TÌNH TRẠNG THANH TOÁN</h4>
            </div>
            <div class="modal-body">
                <form id="updateForm" method="post">
                    <input type="hidden" name="maDon" id="modalMaDon">
                    <div class="form-group">
                        <label for="tinhTrangThanhToan">Tình Trạng Thanh Toán</label>
                        <select name="tinhTrangThanhToan" id="tinhTrangThanhToan" class="form-control">
                            <option value="Cho xac nhan">Chờ xác nhận</option>
                            <option value="Da thanh toan">Đã thanh toán</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    <button type="submit" name="update" class="btn btn-success" style="float: right;">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>
</div>