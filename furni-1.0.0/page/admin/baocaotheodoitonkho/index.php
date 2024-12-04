<?php
if (!isset($_GET['baocaotheodoitonkho'])) {
    $baocaotheodoitonkho = 1;
} else {
    $baocaotheodoitonkho = intval($_GET['baocaotheodoitonkho']);
}

$obj = new database();
$results_per_page = 10;
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Lấy danh sách sản phẩm dựa trên bộ lọc
if ($filter === 'low_stock') {
    // Sắp hết hàng (không áp dụng LIMIT)
    $sql = "
        SELECT 
            maDauSach, 
            tenDauSach, 
            tongSoLuong, 
            soLuongDangThue, 
            maDM, 
            (tongSoLuong - soLuongDangThue) AS soLuongConLai
        FROM 
            dausach
        WHERE 
            (tongSoLuong - soLuongDangThue) > 0 AND (tongSoLuong - soLuongDangThue) < 3
    ";
} elseif ($filter === 'out_of_stock') {
    // Hết hàng (không áp dụng LIMIT)
    $sql = "
        SELECT 
            maDauSach, 
            tenDauSach, 
            tongSoLuong, 
            soLuongDangThue, 
            maDM, 
            (tongSoLuong - soLuongDangThue) AS soLuongConLai
        FROM 
            dausach
        WHERE 
            (tongSoLuong - soLuongDangThue) = 0
    ";
} else {
    // Không có bộ lọc, áp dụng LIMIT cho phân trang
    $page_first_result = max(0, ($baocaotheodoitonkho - 1) * $results_per_page); // Đảm bảo giá trị không âm
    $sql = "
        SELECT 
            maDauSach, 
            tenDauSach, 
            tongSoLuong, 
            soLuongDangThue, 
            maDM, 
            (tongSoLuong - soLuongDangThue) AS soLuongConLai
        FROM 
            dausach
        LIMIT $page_first_result, $results_per_page
    ";
}

// Thực hiện truy vấn
$dausach = $obj->xuatdulieu($sql);

// Nếu không lọc, tính số trang
if (!$filter) {
    $total_products = $obj->xuatdulieu("SELECT COUNT(*) as total FROM dausach")[0]['total']; // Tổng số sản phẩm
    $number_of_page = ceil($total_products / $results_per_page); // Tính số trang
}
?>


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

    .filter-section {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 10px;
    }

    .filter-section form {
        display: flex;
        align-items: center;
    }

    .filter-section select {
        margin-right: 10px;
        height: 38px;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3 {
        margin: 0;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class=" strpied-tabled-with-hover bg-white">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h3 class="card-title">DANH SÁCH TỒN KHO</h3>
                        <!-- Bộ lọc -->
                        <div class="filter-section d-flex">
                            <form method="get" action="indexAdmin.php" class="d-flex align-items-center">
                                <input type="hidden" name="baocaotheodoitonkho" value="<?= $baocaotheodoitonkho ?>">
                                <select name="filter" class="form-control"
                                    style="height: 45px;width: 200px; margin-right: 10px;"
                                    onchange="this.form.submit()">
                                    <option value="">Tất cả</option>
                                    <option value="low_stock" <?= isset($_GET['filter']) && $_GET['filter'] === 'low_stock' ? 'selected' : '' ?>>Sắp hết hàng (Dưới 3)</option>
                                    <option value="out_of_stock" <?= isset($_GET['filter']) && $_GET['filter'] === 'out_of_stock' ? 'selected' : '' ?>>Hết hàng</option>
                                </select>
                            </form>
                            <!--<form method="post" action="export.php" style="margin-left: 10px;">
                            <input type="hidden" name="filter" value="<?//= isset($_GET['filter']) ? $_GET['filter'] : '' ?>">
                            <button type="submit" class="btn btn-primary">Xuất dữ liệu</button>
                        </form>-->
                            <!-- Form chọn định dạng xuất file -->
                            <form method="post" action="export.php" class="d-flex align-items-center"
                                style="margin-left: 10px;">
                                <!-- Chuyển bộ lọc hiện tại vào form -->
                                <input type="hidden" name="filter"
                                    value="<?= isset($_GET['filter']) ? $_GET['filter'] : '' ?>">
                                <!-- Dropdown chọn định dạng -->
                                <select name="format" class="form-control"
                                    style="height: 45px; width: 150px; margin-right: 10px;">
                                    <option value="excel">Excel</option>
                                    <option value="pdf">PDF</option>
                                    <option value="word">Word</option>
                                </select>
                                <!-- Nút bấm xuất file -->
                                <button type="submit" class="btn btn-primary">Xuất báo cáo</button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Mã Đầu Sách</th>
                                    <th style="width: 600px;">Tên Đầu Sách</th>
                                    <th>Tổng số lượng</th>
                                    <th>Số lượng đang thuê</th>
                                    <th>Số lượng còn lại</th>
                                    <th>Mã Danh Mục</th>
                                    <th>Tình Trạng</th>
                                </thead>
                                <tbody>
                                    <?php if (!empty($dausach) && is_array($dausach)): ?>
                                        <?php foreach ($dausach as $item): ?>
                                            <tr>
                                                <td><?= $item["maDauSach"] ?></td>
                                                <td><?= $item["tenDauSach"] ?></td>
                                                <td><?= $item["tongSoLuong"] ?></td>
                                                <td><?= $item["soLuongDangThue"] ?></td>
                                                <td><?= $item["soLuongConLai"] ?></td>
                                                <td><?= $item["maDM"] ?></td>
                                                <td>
                                                    <?php if ($item["soLuongConLai"] == 0): ?>
                                                        <span style="color: red;">Hết hàng</span>
                                                    <?php elseif ($item["soLuongConLai"] < 3): ?>
                                                        <span style="color: orange;">Sắp hết hàng</span>
                                                    <?php else: ?>
                                                        <span style="color: green;">Còn hàng</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Không có sách nào phù hợp với bộ lọc</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Phân trang -->
        <?php if (!$filter): ?>
            <div class="pagination" style="text-align: center; margin-top: 20px;">
                <?php for ($i = 1; $i <= $number_of_page; $i++): ?>
                    <?php if ($i == $baocaotheodoitonkho): ?>
                        <a class="active" href="indexAdmin.php?baocaotheodoitonkho=<?= $i ?>"><?= $i ?></a>
                    <?php else: ?>
                        <a href="indexAdmin.php?baocaotheodoitonkho=<?= $i ?>"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    </div>
</div>