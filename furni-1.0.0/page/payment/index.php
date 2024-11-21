<!doctype html>
<html lang="en">
<?php
if (!isset($_GET['payment'])) {
    $payment = 1;
} else {
    $payment = $_GET['payment'];
}
$conn = mysqli_connect("localhost", "nhomptud", "123456", "ptud");
if ($conn) {
    $str = "SELECT * FROM donthuesach";
    $result = $conn->query($str);
}
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $moneyPay = number_format($row['tongTienCoc'], 0, '.', '.');
    }
}
?>
<!-- Start Hero Section -->
<form method="POST" enctype='multipart/form-data'>
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Thanh Toán</h1>
                    </div>
                </div>
                <div class="col-lg-7"></div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <div class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="h3 mb-3 text-black">PHƯƠNG THỨC THANH TOÁN</h2>
                    <div class="p-5 border bg-white">
                        <div class="border mb-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                value="Banking" id="banking" onchange="updatePaymentInfo('banking')"
                                                checked>
                                            <label class="form-check-label" for="banking">
                                                <img style="width: 90px;height: 40px;"
                                                    src="layout/images/logonganhang.png" alt="">Thanh toán ngân hàng
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                value="momo" id="momo" onchange="updatePaymentInfo('momo')">
                                            <label class="form-check-label" for="momo">
                                                <img style="width: 40px;height: 40px;margin-left: 20px;margin-right: 30px;"
                                                    src="layout/images/logomomo.png" alt="">Ví Momo
                                            </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="form-check-input" type="radio" name="paymentMethod"
                                                value="zalopay" id="zalopay" onchange="updatePaymentInfo('zalopay')">
                                            <label class="form-check-label" for="zalopay">
                                                <img style="width: 50px;height: 50px;margin-left: 12px;margin-right: 30px;"
                                                    src="layout/images/logozalopay.png" alt="">Ví ZaloPay
                                            </label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h2 class="h3 mb-3 text-black text-center">THÔNG TIN THANH TOÁN</h2>
                            <div class="p-5 bg-white">
                                <div class="row">
                                    <!-- Payment Information Table -->
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="amount" class="form-label">Số tiền cọc cần thanh
                                                    toán</label>
                                                <input type="text" class="form-control" id="amount" readonly
                                                    value="<?php echo $moneyPay ?> VND">
                                            </div>
                                            <div class="mb-3">
                                                <label for="account" class="form-label">Nội dung chuyển khoản</label>
                                                <input type="text" class="form-control" id="account" readonly
                                                    value="THANHTOAN-<?php echo $payment ?>">
                                            </div>

                                            <div class="mb-3">
                                                <label for="bill" class="form-label">Tải hóa đơn lên</label>
                                                <input type="file" class="form-control" id="bill" style="height: 38px;"
                                                    name='billImage' accept='image/*'>
                                            </div>

                                            <button type="submit" class="btn btn-primary" style="border-radius: 10px;"
                                                name="btn-submit">Xác nhận</button>
                                        </div>
                                    </div>

                                    <!-- QR Code Image -->
                                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                                        <img id="qr-code" src="layout/images/QR-nganhang.png" alt="QR Code for Payment"
                                            width="100%" height="100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>

<script>
    // Update the QR code image based on the selected payment method
    function updatePaymentInfo(paymentMethod) {
        const qrCodeImage = document.getElementById('qr-code');

        // Show QR Code and update it based on the payment method
        qrCodeImage.style.display = 'block';

        switch (paymentMethod) {
            case 'banking':
                qrCodeImage.src = 'layout/images/QR-nganhang.png';
                break;
            case 'momo':
                qrCodeImage.src = 'layout/images/QR-momo.png';
                break;
            case 'zalopay':
                qrCodeImage.src = 'layout/images/QR-zalopay.png';
                break;
            default:
                qrCodeImage.src = '';
                qrCodeImage.style.display = 'none'; // Hide QR if no method selected
        }
    }

    // Call the update function with 'banking' as default
    window.onload = function () {
        updatePaymentInfo('banking');
    }
</script>

<?php
if (isset($_POST['btn-submit'])) {
    $payMethod = $_POST['paymentMethod'];
    $targetDir = "layout/images/bills/";
    $fileName = isset($_FILES["billImage"]["name"]) ? basename($_FILES["billImage"]["name"]) : "";
    $uploadFile = $targetDir . $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
    if (!empty($fileName)) {
        $check = getimagesize($_FILES["billImage"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File không phải là ảnh hợp lệ.');</script>";
            $uploadOk = 0;
        }
        if ($_FILES["billImage"]["size"] > 5000000) {
            echo "<script>alert('Kích thước ảnh quá lớn (tối đa 5MB).');</script>";
            $uploadOk = 0;
        }
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            echo "<script>alert('Chỉ cho phép định dạng JPG, PNG, JPEG, GIF.');</script>";
            $uploadOk = 0;
        }
        if ($uploadOk && move_uploaded_file($_FILES["billImage"]["tmp_name"], $uploadFile)) {
            $updateQuery = "
                UPDATE donthuesach 
                SET hinhAnhThanhToan = '$fileName', tinhTrangThanhToan = 'Cho xac nhan', phuongThucThanhToan='$payMethod'
                WHERE maDon = $payment;
            ";
            if ($conn->query($updateQuery)) {
                echo "<script>alert('Thanh toán thành công! Chờ xác nhận.');window.location.href = 'index.php?history';</script>";
            } else {
                echo "<script>alert('Lỗi khi cập nhật thông tin: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Không thể tải ảnh lên. Vui lòng thử lại.');</script>";
        }
    } else {
        echo "<script>alert('Vui lòng tải lên ảnh hóa đơn');</script>";
    }
}
?>

</html>