<!-- /*
* Bootstrap 5
* Template Name: Furni
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!doctype html>
<html lang="en">
<?php
if (!isset($_GET['payment'])) {
    $payment = 1;
} else {
    $payment = $_GET['payment'];
}
?>
<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Thanh Toán</h1>
                </div>
            </div>
            <div class="col-lg-7">

            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">PHƯƠNG THỨC THANH TOÁN</h2>
                        <div class=" p-5 border bg-white">
                            <div class="border  mb-3">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="radio" name="paymentMethod"
                                                    value="banking" onchange="updatePaymentInfo('banking')">
                                                <label class="form-check-label" for="banking">
                                                    <img style="width: 90px;height: 40px;"
                                                        src="layout/images/nganhang.png" alt="">Thanh toán ngân hàng
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="radio" name="paymentMethod"
                                                    value="momo" onchange="updatePaymentInfo('momo')">
                                                <label class="form-check-label" for="banking">
                                                    <img style="width: 40px;height: 40px;margin-left: 20px;margin-right: 30px;"
                                                        src="layout/images/logo-momo.png" alt="">Ví Momo
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="form-check-input" type="radio" name="paymentMethod"
                                                    value="zalopay" onchange="updatePaymentInfo('zalopay')">
                                                <label class="form-check-label" for="banking">
                                                    <img style="width: 50px;height: 50px;margin-left: 20px;margin-right: 30px;"
                                                        src="layout/images/logo-zalopay.png" alt="">Ví ZaloPay
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black text-center">THÔNG TIN THANH TOÁN</h2>
                        <div class="p-5  bg-white">
                            <div class="row">
                                <!-- Payment Information Table -->
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <form>
                                            <div class="mb-3">
                                                <label for="amount" class="form-label">Số tiền</label>
                                                <input type="text" class="form-control" id="amount" value="378.000 VND">
                                            </div>
                                            <div class="mb-3">
                                                <label for="account" class="form-label">Nội dung chuyển khoản</label>
                                                <input type="text" class="form-control" id="account"
                                                    value="MDH01112024">
                                            </div>

                                            <div class="mb-3">
                                                <label for="bill" class="form-label">Tải hóa đơn lên</label>
                                                <input type="file" class="form-control" id="bill" style="height: 38px;">
                                            </div>

                                            <button type="submit" class="btn btn-primary"
                                                style="border-radius: 10px;">Xác nhận</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- QR Code Image -->
                                <div class="col-md-6 d-flex align-items-center justify-content-center">
                                    <img id="qr-code" src="layout/images/QR-thanhtoannganhang.png"
                                        alt="QR Code for Payment" width="100%" height="100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function updatePaymentInfo(paymentMethod) {
        const qrCodeImage = document.getElementById('qr-code');

        switch (paymentMethod) {
            case 'banking':
                qrCodeImage.src = 'layout/images/QR-thanhtoannganhang.png';
                break;
            case 'momo':
                qrCodeImage.src = 'layout/images/QR-thanhtoanmomo.png';
                break;
            case 'zalopay':
                qrCodeImage.src = 'layout/images/QR-thanhtoanzalopay.png';
                break;
            default:
                qrCodeImage.src = 'layout/images/QR-thanhtoannganhang.png';
        }
    }
</script>