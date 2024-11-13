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
    <video id="videoOverlay" autoplay loop muted style="height: 450px !important">
        <source src="images/mobile_payment.mp4" type="video/mp4">
    </video>
    <div
        style="background-color: white !important; width: 75%; min-height: 800px; margin-left: 210px; margin-bottom: 50px">
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
                        <th scope="col">Thời gian thanh toán còn lại</th>
                        <th scope="col" style="align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row"><a href="#" id="payCode">123</a></th>
                        <td>148.000 VNĐ</td>
                        <td>230.000 VNĐ</td>
                        <td>23/01/2024</td>
                        <td>42 giờ</td>
                        <td><button id="pay">Thanh toán</button>
                            <button id="detail">Xem chi tiết</button>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><a href="#" id="payCode">456</a></th>
                        <td>348.000 VNĐ</td>
                        <td>759.000 VNĐ</td>
                        <td>26/01/2024</td>
                        <td>20 giờ</td>
                        <td><button id="pay">Thanh toán</button>
                            <button id="detail">Xem chi tiết</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Testimonial Slider -->