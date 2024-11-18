<?php
if (!isset($_GET['quanlythuetra'])) {
    $quanlythuetra = 1;
} else {
    $quanlythuetra = $_GET['quanlythuetra'];
}

include 'config.php';


$sql = "
    SELECT 
        ds.maDon, 
        ds.maKH, 
        nd.ten,  
        ct.tinhTrangThue
    FROM donthuesach ds
    JOIN chitiethoadon ct ON ds.maDon = ct.maDon
    JOIN khachhang kh ON ds.maKH = kh.maKH
    JOIN nguoidung nd ON kh.maNguoiDung = nd.maNguoiDung
    WHERE ct.tinhTrangThue = 'Đang thuê'"; // Lọc các đơn hàng đang thuê
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
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header">
                        <h4 class="card-title text-center">DANH SÁCH ĐƠN THUÊ</h4>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Mã Đơn</th>
                                    <th>Mã Khách Hàng</th>
                                    <th>Tên Khách Hàng</th>
                                    <th>Tình Trạng Thuê</th>
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
                                        echo "<tr><td colspan='5'>Không có đơn hàng nào đang thuê</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>