<!doctype html>
<html lang="en">

<style>
    /* Main Container Style */
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
    }

    #XemLichSuThueND h2 {
        font-size: 28px;
        color: #FF8C00;
        text-align: center;
        margin-bottom: 20px;
    }

    #XemLichSuThueND p {
        font-size: 16px;
        color: #666;
        margin-bottom: 15px;
    }

    /* Table Style */
    #XemLichSuThueND table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    #XemLichSuThueND th,
    td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    #XemLichSuThueND th {
        background-color: orange;
        color: white;
    }

    #XemLichSuThueND tr:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        padding-top: 60px;
        overflow-y: auto;
    }

    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 700px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        float: right;
    }

    .close:hover,
    .close:focus {
        color: #333;
        cursor: pointer;
    }

    /* Modal Form Layout */
    .modal-content h2 {
        color: orange;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .modal-content form {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .modal-content form label {
        font-weight: bold;
        width: 150px;
    }

    .modal-content form input {
        width: calc(100% - 160px);
        padding: 8px;
        margin: 5px 0 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
    }

    .modal-content .btn-gia-han {
        background-color: orange;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .modal-content .btn-gia-han:hover {
        background-color: orange;
    }

    /* Flex Layout for Modal */
    .modal-content .content-container {
        display: flex;
        gap: 20px;
    }

    .modal-content .content-container .left-section {
        flex: 1;
        text-align: center;
    }

    .modal-content .content-container .left-section img {
        width: 100%;
        max-width: 200px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    .modal-content .content-container .right-section {
        flex: 2;
    }

    .ChiTietDonSach {
        text-align: center;
        color: orange;
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
            <h2><b>Lịch sử thuê sách của bạn</b></h2>
            <p>Dưới đây là danh sách các sách mà bạn đã thuê trong thời gian qua. Bạn có thể theo dõi trạng thái và
                thông tin chi tiết của từng giao dịch.</p>

            <table>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày thuê</th>
                    <th>Tổng tiền thuê</th>
                    <th>Phí ship</th>
                    <th>Phương thức thanh toán</th>
                    <th>Tình trạng thanh toán</th>
                    <th>Hình ảnh thanh toán</th>
                </tr>
                <?php
                // Kết nối cơ sở dữ liệu
                $conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                // Truy vấn danh sách đơn thuê sách
                $sql = "SELECT * FROM donthuesach where donthuesach.maKH"; // Lấy toàn bộ dữ liệu từ bảng donthuesach
                $result = $conn->query($sql);

                // Đảm bảo có dữ liệu trong bảng donthuesach
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr onclick=\"redirectToDetails('" . $row['maDon'] . "')\">";
                        echo "<td>" . $row['maDon'] . "</td>";
                        echo "<td>" . $row['ngayThue'] . "</td>";
                        echo "<td>" . number_format($row['tongTienThue'], 0, ',', '.') . " VND</td>";
                        echo "<td>" . number_format($row['phiShip'], 0, ',', '.') . " VND</td>";
                        echo "<td>" . $row['phuongThucThanhToan'] . "</td>";
                        echo "<td>" . $row['tinhTrangThanhToan'] . "</td>";
                        echo "<td><img src='layout/images/" . $row['hinhAnhThanhToan'] . "' alt='Image' style='width: 50px; height: 50px;'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Không có lịch sử thuê sách.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
    <script>
        function redirectToDetails(maDon) {
            // Chuyển hướng đến trang chi tiết hóa đơn
            window.location.href = `index.php?invoice_details&maDon=${maDon}`
        }
    </script>
</body>

</html>