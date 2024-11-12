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

<div class="untree_co-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5 mb-5 mb-md-0">
                <h2 class="h3 mb-3 text-black">PHƯƠNG THỨC THANH TOÁN</h2>
                <div class="p-3 p-lg-5 border bg-white">
                    <table>
                        <form>
                            <table>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" value="banking">
                                    <label class="form-check-label" for="banking">
                                        Thanh toán ngân hàng
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" value="momo">
                                    <label class="form-check-label" for="momo">
                                        Ví Momo
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" value="zalopay">
                                    <label class="form-check-label" for="zalopay">
                                        ZaloPay
                                    </label>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Xác Nhận</button>
                            </table>
                        </form>
                    </table>



                </div>
            </div>
            <div class="col-md-7">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">THÔNG TIN THANH TOÁN</h2>
                        <div class=" p-5 border bg-white">

                            <div class="border  mb-3">
                                <div class="col-md-12">
                                    <table class="table site-block-order-table mb-5">
                                        <tbody>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Số tiền cần thanh
                                                        toán</strong>
                                                </td>
                                                <td class="text-black font-weight-bold">
                                                    378.800
                                                    VND</td>
                                            </tr>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Nội dung chuyển
                                                        khoản</strong>
                                                </td>
                                                <td class="text-black font-weight-bold">
                                                    MDTS011024
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>QR cửa hàng</strong>
                                                </td>
                                                <td class="text-black font-weight-bold"><img
                                                        src="layout/images/QR-thanhtoan.png" alt=""
                                                        style="width: 200px;height: 200px;"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Upload Bill</strong>
                                                </td>
                                                <td><input style="height: 35px;" type="file" class="form-control"
                                                        id="uploadBill" accept="image/*" required ">
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class=" form-group">
                                                    <button class="btn btn-primary mt-3"
                                                        onclick="window.location='#'">Xác
                                                        nhận</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- </form> -->
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>