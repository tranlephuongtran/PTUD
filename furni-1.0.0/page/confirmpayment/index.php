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
if (!isset($_GET['confirmpayment'])) {
    $confirmpayment = 1;
} else {
    $confirmpayment = $_GET['confirmpayment'];
}
$maDon = $_SESSION['idPay'] ?? 0;
?>

<!-- Start Hero Section -->
<form method="POST">
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <div class="intro-excerpt">
                        <h1>Xác nhận Thanh toán</h1>
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
                <div class="col-md-12 mb-5 mb-md-0">
                    <!-- <h2 class="h3 mb-3 text-black">THÔNG TIN ĐƠN HÀNG</h2> -->
                    <div class="p-3 p-lg-5 border bg-white text-center">
                        <h2 class=" mb-3 text-black">BẠN CÓ MUỐN THANH TOÁN NGAY KHÔNG ?</h2>
                        <button class="btn btn-primary btn-block"
                            onclick="window.location='index.php?payment=<?php echo $maDon ?>'">Thanh
                            toán</button>
                        <button class="btn btn-primary btn-block" style="width: 150px;" name="payLate">Để
                            sau</button>


                    </div>
                </div>
            </div>
        </div>


        <!-- </form> -->
    </div>
    </div>
</form>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>
<?php
if (isset($_POST['payLate'])) {
    $conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
    if ($conn) {
        $now = date_create()->format('Y-m-d');
        $str = "UPDATE donthuesach SET ngayThue = '$now' WHERE maDon = $maDon";
        if ($conn->query($str)) {
            echo "<script>alert('Vui lòng thanh toán trong tối đa 2 ngày! Nếu không đơn sẽ bị hủy.'); window.location.href = 'index.php?paymentlate'</script>";
        }
    }
}
?>