<?php
include 'page/admin/quanlythuetra/config.php';

// Kiểm tra mã đơn
if (!isset($_GET['maDon'])) {
    die("Không tìm thấy mã đơn hàng.");
}
$maDon = $conn->real_escape_string($_GET['maDon']);

// Xử lý cập nhật trạng thái và ảnh
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tinhTrangThueHidden']) && isset($_POST['maSach'])) {
        $newStatus = isset($_POST['tinhTrangThue']) ? $_POST['tinhTrangThue'] : $_POST['tinhTrangThueHidden'];
        $maSach = $conn->real_escape_string($_POST['maSach']);
        $currentDate = date('Y-m-d');

        $targetDir = "layout/images/uploads/";
        $fileName = isset($_FILES["hinhAnhTraSach"]["name"]) ? basename($_FILES["hinhAnhTraSach"]["name"]) : "";
        $uploadFile = $targetDir . $fileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));


        if ($newStatus === 'Đã trả') {
            if (!empty($fileName)) {
                $check = getimagesize($_FILES["hinhAnhTraSach"]["tmp_name"]);
                if ($check === false) {
                    echo "<script>alert('File không phải là ảnh hợp lệ.');</script>";
                    $uploadOk = 0;
                }
                if ($_FILES["hinhAnhTraSach"]["size"] > 5000000) {
                    echo "<script>alert('Kích thước ảnh quá lớn (tối đa 5MB).');</script>";
                    $uploadOk = 0;
                }
                if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
                    echo "<script>alert('Chỉ cho phép định dạng JPG, PNG, JPEG, GIF.');</script>";
                    $uploadOk = 0;
                }
                if ($uploadOk && move_uploaded_file($_FILES["hinhAnhTraSach"]["tmp_name"], $uploadFile)) {
                    $updateQuery = "
                        UPDATE chitiethoadon 
                        SET tinhTrangThue = 'Đã trả', ngayTra = '$currentDate', hinhAnhTraSach = '$fileName' 
                        WHERE maDon = '$maDon' AND maSach = '$maSach'
                    ";
                    // Cập nhật số lượng và tình trạng trong bảng sach
                    $updateSachQuery = "
                        UPDATE sach 
                        SET tinhTrang = 'Can kiem tra'       
                        WHERE maSach = '$maSach'
                    ";
                    $updateDauSachQuery = "
                        UPDATE dausach d
                        JOIN sach s ON d.maDauSach = s.maDauSach
                        SET d.soLuongDangThue = d.soLuongDangThue - 1
                        WHERE s.maSach = '$maSach'
                    ";
                    if ($conn->query($updateQuery) && $conn->query($updateSachQuery) && $conn->query($updateDauSachQuery)) {
                        echo "<script>alert('Tình trạng thuê và ảnh đã được cập nhật thành công.');</script>";
                    } else {
                        echo "<script>alert('Lỗi khi cập nhật thông tin: " . $conn->error . "');</script>";
                    }
                } else {
                    echo "<script>alert('Không thể tải ảnh lên. Vui lòng thử lại.');</script>";
                }
            } else {
                echo "<script>alert('Vui lòng tải lên ảnh trả sách.');</script>";
            }
        } else {
            echo "<script>alert('Không thể chuyển trạng thái ngược từ \"Đã trả\" thành \"Đang thuê\".');</script>";
        }


        echo "<script>window.location.href = window.location.href;</script>";
    }
}


$sql = "
    SELECT 
        ds.maDon, 
        ct.maSach, 
        d.tenDauSach,
        d.tacGia, 
        ct.giaThue, 
        ds.ngayThue, 
        ct.ngayTra, 
        ct.tinhTrangThue, 
        ct.hinhAnhTraSach, 
        ds.maKM, 
        ds.phiShip, 
        ds.tongTienThue
    FROM donthuesach ds
    JOIN chitiethoadon ct ON ds.maDon = ct.maDon
    JOIN sach s ON ct.maSach = s.maSach
    JOIN dausach d ON s.maDauSach = d.maDauSach
    WHERE ds.maDon = '$maDon'
";
$result = $conn->query($sql);
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>
<style>
    .card.strpied-tabled-with-hover {
        border-radius: 15px;
        margin: 0 auto;
        display: block;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 34px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 20px;
    }

    input:checked+.slider {
        background-color: #4caf50;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked+.slider:before {
        transform: translateX(14px);
    }

    .c-card {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #ddd;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 15px;

    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class=" strpied-tabled-with-hover">
                    <div class="card-header bg-white">
                        <a href="indexAdmin.php?quanlythuetra" class="btn btn-danger">Quay về</a>
                        <h4 class="card-title text-center">THÔNG TIN CHI TIẾT ĐƠN THUÊ</h4>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Mã Sách</th>
                                    <th style="width: 200px;">Tên Sách</th>
                                    <th>Tác Giả</th>
                                    <th>Giá Thuê</th>
                                    <th>Ngày Thuê</th>
                                    <th>Ngày Trả</th>
                                    <th>Tình Trạng Thuê</th>
                                    <th>Hình Ảnh Trả</th>
                                    <th>Ưu Đãi</th>
                                    <th>Phí Ship</th>
                                    <th>Tổng Tiền Thuê</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $isChecked = $row['tinhTrangThue'] === 'Đã trả' ? 'checked disabled' : '';
                                        $imageSrc = !empty($row['hinhAnhTraSach']) ? "layout/images/uploads/{$row['hinhAnhTraSach']}" : "No image";
                                        echo "<tr>";
                                        echo "<td>{$row['maSach']}</td>";
                                        echo "<td>{$row['tenDauSach']}</td>";
                                        echo "<td>{$row['tacGia']}</td>";
                                        echo "<td>{$row['giaThue']}</td>";
                                        echo "<td>{$row['ngayThue']}</td>";
                                        echo "<td>" . ($row['tinhTrangThue'] === 'Đã trả' ? $row['ngayTra'] : 'Chưa trả') . "</td>";
                                        echo "<td>
                                        <form method='POST' enctype='multipart/form-data'>
                                            <label class='switch'>
                                                <input type='checkbox' name='tinhTrangThue' value='Đã trả' $isChecked onchange='this.form.submit()'>
                                                <span class='slider round'></span>
                                            </label>
                                            <input type='hidden' name='tinhTrangThueHidden' value='Đang thuê'>
                                            <input type='hidden' name='maSach' value='{$row['maSach']}'>
                                            <input type='file' name='hinhAnhTraSach' accept='image/*'>
                                        </form>
                                    </td>";
                                        echo "<td><img src='$imageSrc' alt='' width='50'></td>";
                                        echo "<td>{$row['maKM']}</td>";
                                        echo "<td>{$row['phiShip']}</td>";
                                        echo "<td>{$row['tongTienThue']}</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>