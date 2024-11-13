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
                    <th>Số lượng sách thuê</th>
                    <th>Tổng tiền đơn</th>
                    <th>Ngày thuê</th>
                    <th>Ngày trả</th>
                    <th>Tình trạng thanh toán</th>
                </tr>
                <tr onclick="openModal('KH001', '001', 3, '15/01/2024', '15/01/2024', 100000,'đã thanh toán')">
                    <td>001</td>
                    <td>3 sách</td>
                    <td>100,000 VND</td>
                    <td>01/01/2024</td>
                    <td>15/01/2024</td>
                    <td>đã thanh toán</td>
                </tr>
                <tr onclick="openModal('KH001', '002', 2, '10/02/2024', '24/02/2024', 50000,'đã thanh toán')">
                    <td>002</td>
                    <td>2 sách</td>
                    <td>50,000 VND</td>
                    <td>10/02/2024</td>
                    <td>24/02/2024</td>
                    <td>đã thanh toán</td>
                </tr>
                <!-- Thêm nhiều mục lịch sử thuê sách ở đây -->
            </table>
        </div>
    </div>

    <!-- Modal for Book Details -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 class="ChiTietDonSach">Thông tin chi tiết đơn thuê sách</h2>
            <div class="content-container">
                <!-- Left Section - Image -->
                <div class="left-section">
                    <img id="hinhAnhThanhToan" src="images/img-grid-3.jpg" alt="Hình ảnh sách">
                </div>
                <!-- Right Section - Details -->
                <div class="right-section">
                    <form>
                        <div>
                            <label for="maKH">Mã khách hàng:</label>
                            <input type="text" id="maKH" readonly><br>
                        </div>
                        <div>
                            <label for="maDon">Mã đơn:</label>
                            <input type="text" id="maDon" readonly><br>
                        </div>
                        <div>
                            <label for="soLuong">Số lượng sách thuê:</label>
                            <input type="number" id="soLuong" readonly><br>
                        </div>
                        <div>
                            <label for="ngayThue">Ngày thuê:</label>
                            <input type="text" id="ngayThue" readonly><br>
                        </div>
                        <div>
                            <label for="ngayTra">Ngày trả:</label>
                            <input type="text" id="ngayTra" readonly><br>
                        </div>
                        <div>
                            <label for="tongGia">Tổng giá thuê:</label>
                            <input type="text" id="tongGia" readonly><br>
                        </div>
                        <div>
                            <label for="phuongThucTT">Phương thức thanh toán:</label>
                            <input type="text" id="phuongThucTT" readonly><br>
                        </div>
                        <div>
                            <label for="khuyenMai">Khuyến mãi:</label>
                            <input type="text" id="khuyenMai" readonly><br>
                        </div>
                        <div>
                            <label for="phiShip">Phí ship:</label>
                            <input type="text" id="phiShip" readonly><br>
                        </div>
                        <div>
                            <label for="uuDaiTV">Ưu đãi thành viên:</label>
                            <input type="text" id="uuDaiTV" readonly><br>
                        </div>
                        <div>
                            <label for="tongTienThueSauUuDai">Tổng tiền thuê sau ưu đãi:</label>
                            <input type="text" id="tongTienThueSauUuDai" readonly><br>
                        </div>
                        <div>
                            <label for="tinhTrangTT">Tình trạng thanh toán:</label>
                            <input type="text" id="tinhTrangTT" readonly><br>
                        </div>
                        <button type="button" class="btn-gia-han">Gia Hạn</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(maKH, maDon, soLuong, ngayThue, ngayTra, tongGia, tinhTrangTT) {
            document.getElementById("maKH").value = maKH;
            document.getElementById("maDon").value = maDon;
            document.getElementById("soLuong").value = soLuong;
            document.getElementById("ngayThue").value = ngayThue;
            document.getElementById("ngayTra").value = ngayTra;
            document.getElementById("tongGia").value = tongGia;
            document.getElementById("tinhTrangTT").value = tinhTrangTT;
            document.getElementById("myModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == document.getElementById("myModal")) {
                closeModal();
            }
        }
    </script>
</body>


</html>