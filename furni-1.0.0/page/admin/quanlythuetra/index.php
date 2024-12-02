<?php
if (!isset($_GET['quanlythuetra'])) {
    $quanlythuetra = 1;
} else {
    $quanlythuetra = intval($_GET['quanlythuetra']);
}

// Đảm bảo rằng trang hiện tại không nhỏ hơn 1
if ($quanlythuetra < 1) {
    $quanlythuetra = 1;
}

include 'config.php';

// Lấy từ khóa tìm kiếm nếu có
$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';

// Số lượng đơn hàng hiển thị trên mỗi trang
$results_per_page = 5;
$page_first_result = ($quanlythuetra - 1) * $results_per_page;

// Đảm bảo rằng page_first_result không âm
if ($page_first_result < 0) {
    $page_first_result = 0;
}

// Truy vấn để lấy tổng số đơn thuê
$total_sql = "
    SELECT COUNT(DISTINCT ds.maDon) as total
    FROM donthuesach ds
    JOIN chitiethoadon ct ON ds.maDon = ct.maDon
    JOIN khachhang kh ON ds.maKH = kh.maKH
    JOIN nguoidung nd ON kh.maNguoiDung = nd.maNguoiDung
    WHERE ct.tinhTrangThue = 'Đang thuê'";

// Nếu có từ khóa tìm kiếm, thêm điều kiện vào truy vấn
if (!empty($searchTerm)) {
    $total_sql .= " AND (ds.maDon LIKE '%$searchTerm%' OR kh.maKH LIKE '%$searchTerm%' OR nd.ten LIKE '%$searchTerm%')";
}

$total_result = $conn->query($total_sql);
$total_orders = $total_result->fetch_assoc()['total']; // Tổng số đơn hàng
$number_of_page = ceil($total_orders / $results_per_page); // Tính số trang

// Truy vấn để lấy danh sách đơn thuê với phân trang
$sql = "
    SELECT DISTINCT ds.maDon, ds.maKH, nd.ten, ct.tinhTrangThue
    FROM donthuesach ds
    JOIN chitiethoadon ct ON ds.maDon = ct.maDon
    JOIN khachhang kh ON ds.maKH = kh.maKH
    JOIN nguoidung nd ON kh.maNguoiDung = nd.maNguoiDung
    WHERE ct.tinhTrangThue = 'Đang thuê'";

// Nếu có từ khóa tìm kiếm, thêm điều kiện vào truy vấn
if (!empty($searchTerm)) {
    $sql .= " AND (ds.maDon LIKE '%$searchTerm%' OR kh.maKH LIKE '%$searchTerm%' OR nd.ten LIKE '%$searchTerm%')";
}

$sql .= " LIMIT $page_first_result, $results_per_page"; // Thêm điều kiện LIMIT
$result = $conn->query($sql);
?>

<style>
    .card.strpied-tabled-with-hover {
        border-radius: 15px;
        overflow: hidden;
        margin: 0 auto;
        display: block;
        width: 100%;
        max-width: 1200px;
    }

    .card.strpied-tabled-with-hover .table thead th,
    .card.strpied-tabled-with-hover .table tbody td {
        border: none;
    }

    .card.strpied-tabled-with-hover .table thead {
        background-color: #f8f9fa;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
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
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="strpied-tabled-with-hover">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="card-title text-center">DANH SÁCH ĐƠN THUÊ</h4>
                        <form method="post" class="form-inline mt-4 mb-4">
                            <input type="text" name="searchTerm" class="form-control"
                                placeholder="Tìm kiếm theo mã đơn, mã khách, tên khách"
                                value="<?= htmlspecialchars($searchTerm) ?>" style="width: 300px; margin-right: 10px;">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </form>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Mã Đơn</th>
                                    <th>Mã Khách Hàng</th>
                                    <th>Tên Khách Hàng</th>
                                    <th>Tình Trạng Thuê</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td><a href='indexAdmin.php?chitietdonthue&maDon=" . $row['maDon'] . "'>" . $row['maDon'] . "</a></td>";
                                        echo "<td>" . $row['maKH'] . "</td>";
                                        echo "<td>" . $row['ten'] . "</td>";
                                        echo "<td class='text-success'>" . $row['tinhTrangThue'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td class='text-center' colspan='4'>Không có đơn hàng nào đang thuê</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $number_of_page; $i++): ?>
                            <?php if ($i == $quanlythuetra): ?>
                                <a class="active"
                                    href="indexAdmin.php?quanlythuetra=<?= $i ?>&searchTerm=<?= htmlspecialchars($searchTerm) ?>"><?= $i ?></a>
                            <?php else: ?>
                                <a
                                    href="indexAdmin.php?quanlythuetra=<?= $i ?>&searchTerm=<?= htmlspecialchars($searchTerm) ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>