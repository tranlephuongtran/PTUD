<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<div lang="en">
    <?php
    if (!isset($_GET['paymentlate'])) {
        $paymentlate = 1;
    } else {
        $paymentlate = $_GET['paymentlate'];
    }
    $conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
    if ($conn) {
        $email = $_SESSION['user'];
        $str = "SELECT * FROM khachhang kh INNER JOIN nguoidung nd ON nd.maNguoiDung = kh.maNguoiDung WHERE email = '$email'";
        $result = $conn->query($str);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $maKH = $row['maKH'];
            }
        }
        $str = "SELECT *FROM donthuesach WHERE maKH = $maKH and tinhTrangThanhToan = 'Chua thanh toan'";
    }
    ?>
    <style>
        #payCode {
            text-decoration: none;
        }

        #payCode:hover {
            color: #a76d49;
        }

        #pay,
        #detail {
            border: 0;
            background-color: #a76d49;
            color: white;
            border-radius: 5px;
        }
    </style>
    <video id="videoOverlay" autoplay loop muted style="height: 350px !important">
        <source src="layout/images/mobile_payment.mp4" type="video/mp4">
    </video>
    <div style="background-color: white !important; width: 100%; min-height: 800px;  margin-bottom: 50px">
        <h1 align="center" style="color:#a76d49; padding: 20px; font-weight: 600;">DANH SÁCH
            ĐƠN THUÊ CHỜ THANH TOÁN
        </h1>
        <div style="margin-right: 50px; margin-left: 50px;">
            <table class="table" style="text-align: center">
                <thead>
                    <tr>
                        <th scope="col">Mã đơn</th>
                        <th scope="col">Tổng tiền thuê</th>
                        <th scope="col">Tổng tiền cọc</th>
                        <th scope="col">Ngày đặt đơn</th>
                        <th scope="col">Hạn cuối thanh toán</th>
                        <th scope="col" style="align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query($str);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $moneyRent = number_format($row['tongTienThue'], 0, '.', '.');
                            $moneyDeposit = number_format($row['tongTienCoc'], 0, '.', '.');
                            $date = new DateTime("{$row["ngayThue"]}");
                            $date->modify('+2 days');
                            $date = $date->format('Y-m-d');
                            echo "<tr>
                        <th scope='row'><a href='#' id='payCode'>{$row["maDon"]}</a></th>
                        <td>{$moneyRent} VNĐ</td>
                        <td>{$moneyDeposit} VNĐ</td>
                        <td>{$row["ngayThue"]}</td>
                        <td>$date</td>
                         <td><a href = 'index.php?payment={$row["maDon"]}'><button id='pay'>Thanh toán</button></a></td>
                    </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Testimonial Slider -->