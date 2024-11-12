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


<!-- Start Login -->
<div class="login-form-container">
    <div class="form-login">
        <form method="post" action="/account/login" id="customer_login" accept-charset="UTF-8" data-login-with-shop-sign-in="true" novalidate="novalidate">
            <h1 class="title-login"> Đăng nhập </h1>
			<div class="field">        
				<input type="email" name="CustomerEmail" class="form-control" id="CustomerEmail" autocomplete="email" autocorrect="off" autocapitalize="off" placeholder="Email" required>
                <i class='bx bxs-user'></i>
            </div>	
			<div class="field">          
				<input type="password" value="" name="CustomerPassword" class="form-control" id="CustomerPassword" autocomplete="current-password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
			<div class="checkbox">
				<label><input type="checkbox" >Ghi nhớ tôi</label>
                <a href="#recover"> Quên mật khẩu? </a>
			</div>
            <button type="submit" class="btn"> Đăng nhập </button>
            <div class="register-link">
                <p>Chưa có tài khoản?<a href="register.php"> Đăng ký </a></p>
			</div>       
        </form>
    </div>
</div>
<!-- End Login -->


<?php
include('footer.php')
	?>


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>
</body>

</html>