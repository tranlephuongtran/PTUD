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
	include('header.php')
		?>


<!-- Start Register -->
<div class="register-form-container">
    <div class="form-register">
        <form action="" method="post">
            <h1>Đăng  Ký</h1>
            <div class="input-box">
                <div class="input-field">
                    <input type="text" name="" placeholder="Họ và tên" id="" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-field">
                    <input type="text" name="" placeholder="Tên đăng nhập" id="" required>
                    <i class='bx bxs-user'></i>
                </div>
            </div>
            <div class="input-box">
                <div class="input-field">
                    <input type="text" name="" placeholder="Email" id="" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-field">
                    <input type="text" name="" placeholder="Số điện thoại" id="" required>
                    <i class='bx bxs-phone'></i>
                </div>
            </div>
            <div class="input-box">
                <div class="input-field">
                    <input type="text" name="" placeholder="Password" id="" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-field">
                    <input type="text" name="" placeholder="Xác nhận Password" id="" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
            </div>
            <label><input type="checkbox"> Tôi xin cam đoan rằng các thông tin đã cung cấp ở trên là đúng và chính xác.</label>
            <button type="submit" class="btn">Đăng ký</button>

        </form>
    </div>


</div>


<!-- End Register -->

<?php
include('footer.php')
	?>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>
</body>

</html>