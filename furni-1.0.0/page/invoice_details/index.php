<!doctype html>
<html lang="en">

<style>
    /* Kiểu cho vùng chứa chính */
    #XemLichSuThue {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    #XemLichSuThueND {
        width: 100%;
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 4px 16px rgba(0, 0, 0, 0.1);
        color: #333;
        margin-bottom: 50px;
        gap: 20px;
        /* Thêm khoảng cách giữa các phần */
    }

    #XemLichSuThueND h2 {
        font-size: 28px;
        color: #FF8C00;
        text-align: center;
        margin-bottom: 20px;
    }

    #XemLichSuThueND p {
        font-size: 25px;
        color: #666;
        margin-bottom: 15px;
    }

    .content-container {
        display: flex;
        /* Kích hoạt Flexbox */
        gap: 20px;
        /* Tạo khoảng cách 20px giữa .left-section và .right-section */
        align-items: flex-start;
        /* Canh hai phần từ trên xuống */
    }

    .Hinh {
        width: 80%;
        /* Đặt chiều rộng ảnh đầy đủ */
        height: auto;
        /* Giữ tỷ lệ hình ảnh */
        border-radius: 8px;
        /* Bo tròn các góc ảnh */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        /* Tạo bóng cho ảnh */
        margin-bottom: 20px;
        /* Thêm khoảng cách dưới ảnh */
    }

    .left-section {
        width: 30%;
        float: left;
        background-color: #ffffff;
        /* Màu nền trắng cho phần hình ảnh */
        border-radius: 12px;
        /* Bo tròn các góc */
        padding: 20px;
        /* Thêm khoảng đệm bên trong */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        /* Tạo bóng cho phần */
    }

    .right-section {
        width: 70%;
        float: left;
        background-color: #ffffff;
        /* Màu nền trắng cho phần thông tin */
        border-radius: 12px;
        /* Bo tròn các góc */
        padding: 20px;
        /* Thêm khoảng đệm bên trong */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        /* Tạo bóng cho phần */
    }

    .left-section h4 {
        line-height: 1.6;
        /* Tăng khoảng cách dòng */
        border-bottom: 2px solid #ddd;
        /* Đường kẻ dưới mỗi đoạn */
        padding-bottom: 10px;
        /* Thêm khoảng cách dưới mỗi đoạn */
        margin-bottom: 15px;
        /* Thêm khoảng cách giữa các đoạn */
        text-align: center;
    }

    .left-section h4:last-child {
        border-bottom: none;
        /* Loại bỏ đường kẻ cuối cùng */
    }

    .right-section p {
        line-height: 1.6;
        /* Tăng khoảng cách dòng */
        border-bottom: 1px solid #ddd;
        /* Đường kẻ dưới mỗi đoạn */
        padding-bottom: 10px;
        /* Thêm khoảng cách dưới mỗi đoạn */
        margin-bottom: 15px;
        /* Thêm khoảng cách giữa các đoạn */
    }

    .right-section p:last-child {
        border-bottom: none;
        /* Loại bỏ đường kẻ cuối cùng */
    }
    .no-image {
        font-size: 16px;
        color: red;
        font-weight: bold;
        text-align: center;
        margin: 20px 0;
    }
</style>

<body>
    <?php
    if (!isset($_GET['history'])) {
        $history = 1;
    } else {
        $history = $_GET['history'];
    }
    ?>
    <div class="why-choose-section" id="XemLichSuThue">
        <div class="container" id="XemLichSuThueND">
            <h2><b>Chi tiết hóa đơn thuê sách</b></h2>
            <?php
            // Kết nối cơ sở dữ liệu
            $conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Lấy maDon từ URL
            $maDon = isset($_GET['maDon']) ? $_GET['maDon'] : null;

            if ($maDon) {
                // Truy vấn thông tin từ 3 bảng
                $sql = "
                    SELECT 
                        dt.maDon,
                        cthd.maSach,
                        s.tuaDe,
                        dt.ngayThue,
                        cthd.ngayTra,
                        dt.tongTienThue,
                        dt.tinhTrangThanhToan,
                        dt.phuongThucThanhToan,
                        dt.hinhAnhThanhToan,
                        dt.phiShip,
                        cthd.giaThue,
                        cthd.tinhTrangThue,
                        cthd.hinhAnhTraSach,
                        cthd.tienCoc
                    FROM 
                        donthuesach dt
                    JOIN 
                        chitiethoadon cthd ON dt.maDon = cthd.maDon
                    JOIN 
                        sach s ON cthd.maSach = s.maSach
                    WHERE 
                        dt.maDon = '$maDon';
                ";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Hiển thị thông tin
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='content-container'>";
                        echo "<div class='left-section'>";
                        echo "<h2>Hình ảnh trả sách</h2>";
                        //echo "<h4>Hình ảnh thanh toán:</h4>";
                        //echo "<img class='Hinh' src='layout/images/bills/" . $row['hinhAnhThanhToan'] . "' alt='Hình ảnh thanh toán'>";
                        //echo "<h4>Hình ảnh trả sách:</h4>";
                        if (!empty($row['hinhAnhTraSach'])) {
                            echo "<img class='Hinh' src='layout/images/uploads/" . $row['hinhAnhTraSach'] . "' alt='Hình ảnh sách'>";
                        } else {
                            echo "<p class='no-image'>Bạn chưa thanh toán đơn</p>";
                        }
                        echo "</div>";
                        echo "<div class='right-section'>";
                        echo "<h2>Thông tin chi tiết</h2>";
                        echo "<p>Mã đơn: " . $row['maDon'] . "</p>";
                        echo "<p>Mã sách: " . $row['maSach'] . "</p>";
                        echo "<p>Tên sách: " . $row['tuaDe'] . "</p>";
                        echo "<p>Ngày thuê: " . $row['ngayThue'] . "</p>";
                        echo "<p>Ngày trả: " . $row['ngayTra'] . "</p>";
                        echo "<p>Giá thuê: " . number_format($row['giaThue'], 0, ',', '.') . " VND</p>";
                        echo "<p>Tiền cọc: " . number_format($row['tienCoc'], 0, ',', '.') . " VND</p>";
                        //echo "<p>Phí ship: " . number_format($row['phiShip'], 0, ',', '.') . " VND</p>";
                        //echo "<p>Tổng tiền thuê: " . number_format($row['tongTienThue'], 0, ',', '.') . " VND</p>";
                        //echo "<p>Phương pháp thanh toán: " . $row['phuongThucThanhToan'] . "</p>";
                        //echo "<p>Tình trạng thanh toán: " . $row['tinhTrangThanhToan'] . "</p>";
                        echo "<p>Tình trạng thuê: " . $row['tinhTrangThue'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Không tìm thấy thông tin cho mã đơn này.</p>";
                }
            } else {
                echo "<p>Không có mã đơn được truyền vào.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>

</html>