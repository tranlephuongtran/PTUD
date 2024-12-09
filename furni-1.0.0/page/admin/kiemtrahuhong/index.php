<?php
if (!isset($_GET['kiemtrahuhong'])) {
    $kiemtrahuhong = 1;
} else {
    $kiemtrahuhong = $_GET['kiemtrahuhong'];
}

$servername = "localhost";
$username = "nhomptud";
$password = "123456";
$dbname = "ptud";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý cập nhật tình trạng
if (isset($_POST['update_status'])) {
    $maSach = $_POST['update_status']; // Lấy mã sách từ nút bấm
    $tinhTrang = $_POST['tinhTrang'][$maSach]; // Lấy tình trạng tương ứng với mã sách

    $sql_update = "UPDATE sach SET tinhTrang = ? WHERE maSach = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("si", $tinhTrang, $maSach);
    $stmt->execute();
    // Cập nhật sách khỏi danh sách kiểm tra hư hỏng nếu trạng thái đã thay đổi
    // if ($tinhTrang == 'Thanh ly' || $tinhTrang == 'Con sach') {

    //     $sql_update_status = "UPDATE chitiethoadon SET tinhTrangThue = 'Hoàn thành' WHERE maSach = ?";
    //     $stmt_update_status = $conn->prepare($sql_update_status);
    //     $stmt_update_status->bind_param("i", $maSach);
    //     $stmt_update_status->execute();
    //     $stmt_update_status->close();
    // }
    echo "<script>alert('Cập nhật thành công!');</script>";
    $stmt->close();
}

$sql = "
    SELECT 
        s.maSach, 
        s.tuaDe, 
        s.maISBN,
        ds.maDon, 
        ds.maKH, 
        ds.ngayThue, 
        ct.ngayTra, 
        ct.hinhAnhTraSach, 
        s.tinhTrang
    FROM sach s
    JOIN chitiethoadon ct ON s.maSach = ct.maSach
    JOIN donthuesach ds ON ct.maDon = ds.maDon
    WHERE s.tinhTrang = 'Can kiem tra'";
$result = $conn->query($sql);
?>

<style>
    button[type="submit"] {
        background-color: #4CAF50;
        /* Màu nút */
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 13px;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
        /* Màu khi hover */
    }

    select {
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 13px;
    }

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

    /* Ảnh thu nhỏ */
    .img-thumbnail {
        width: 50px;
        height: 50px;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.2s;
        /* Hiệu ứng zoom khi hover */
    }

    .img-thumbnail:hover {
        transform: scale(1.2);
        /* Zoom nhẹ khi di chuột qua */
        cursor: pointer;
    }

    /* Modal để phóng to ảnh */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        overflow: auto;
    }

    .modal-content {
        margin: 15% auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .close {
        color: green;
        float: right;
        font-size: 100px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class=" strpied-tabled-with-hover bg-white">
                    <div class="card-header bg-white">
                        <h4 class="card-title text-center">DANH SÁCH KIỂM TRA HƯ HỎNG</h4>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <form method="post">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Mã đơn</th>
                                    <th>Mã sách</th>
                                    <th>Tựa đề</th>
                                    <th>Mã ISBN</th>
                                    <th>Mã Khách Hàng</th>
                                    <th>Ngày thuê</th>
                                    <th>Ngày trả</th>
                                    <th>Hình ảnh trả sách</th>
                                    <th>Tình Trạng</th>
                                    <th>Thao tác</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $hinhAnhTraSach = htmlspecialchars($row['hinhAnhTraSach']);
                                            $imagePath = "layout/images/uploads/" . $hinhAnhTraSach;
                                            echo "<tr>";
                                            echo "<td>" . $row['maDon'] . "</td>";
                                            echo "<td>" . $row['maSach'] . "</td>";
                                            echo "<td>" . $row['tuaDe'] . "</td>";
                                            echo "<td>" . $row['maISBN'] . "</td>";
                                            echo "<td>" . $row['maKH'] . "</td>";
                                            echo "<td>" . $row['ngayThue'] . "</td>";
                                            echo "<td>" . $row['ngayTra'] . "</td>";
                                            echo "<td><img src='" . $imagePath . "' alt='Hình ảnh trả sách' class='img-thumbnail' onclick='openModal(this)'></td>";
                                            echo "<td>";
                                            echo "<select name='tinhTrang[" . $row['maSach'] . "]'>";
                                            echo "<option>Hãy Chọn</option>";
                                            echo "<option value='Con sach'" . ($row['tinhTrang'] == 'Con sach' ? ' selected' : '') . ">Bình thường</option>";
                                            echo "<option value='Thanh ly'" . ($row['tinhTrang'] == 'Thanh ly' ? ' selected' : '') . ">Thanh lý</option>";
                                            echo "</select>";
                                            echo "<input type='hidden' name='maSach' value='" . $row['maSach'] . "'>";
                                            echo "</td>";
                                            echo "<td><button type='submit' name='update_status' value='" . $row['maSach'] . "'>Cập nhật</button></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='8'>Không có sách cần kiểm tra</td></tr>";
                                    }

                                    mysqli_close($conn);
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

<!-- Modal để phóng to ảnh -->
<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="img01">
</div>

<script>
    // Hàm mở modal khi nhấn vào ảnh
    function openModal(img) {
        var modal = document.getElementById("myModal");
        var modalImg = document.getElementById("img01");
        modal.style.display = "block";
        modalImg.src = img.src;
    }

    // Hàm đóng modal
    function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }
</script>