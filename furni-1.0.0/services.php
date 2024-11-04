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
<style>
			#ChinhSach {
				display: flex;
				justify-content: space-between;
				padding: 20px;
				border: 5px;
			}

			#ChinhSachMenu{
				width: 20%;
				background-color: #f2f2f2;
				text-align: left;
				padding: 20px;
				border-radius: 8px;
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Đổ bóng để menu nổi bật */
			} 
			#ChinhSachMenu h3 {
				font-size: 28px;
				color: #333;
				margin-bottom: 15px;
				text-align: left;
			}
			#ChinhSachMenu ul {
				list-style-type: none; /* Bỏ dấu chấm đầu dòng */
				padding: 0;
			}

			#ChinhSachMenu ul li {
				margin-bottom: 10px;
			}

			#ChinhSachMenu ul li a {
				text-decoration: none; /* Bỏ gạch chân */
				color: #333;
				font-size: 18px;
				transition: color 0.3s; /* Hiệu ứng chuyển màu khi hover */
			}

			#ChinhSachMenu ul li a:hover {
				color: #a76c4a; /* Đổi màu chữ khi hover */
			}
			#ChinhSachND {
				width: 80%;
				background-color: #e6e6e6;
				text-align: left;
				padding: 30px;
				border-radius: 8px; /* Bo tròn góc */
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
				color: #333; /* Màu chữ dễ đọc */
				line-height: 1.6; /* Tăng khoảng cách giữa các dòng chữ */
				padding-bottom: 50px;
			}
			#ChinhSachND h1 {
				font-size: 32px; /* Kích thước chữ lớn cho tiêu đề */
				color: #4CAF50; /* Màu chữ nổi bật cho tiêu đề */
				margin-bottom: 20px; /* Khoảng cách dưới tiêu đề */
				text-align: left;
			}

			#ChinhSachND p {
				font-size: 18px; /* Kích thước chữ vừa phải cho nội dung */
				margin-bottom: 15px; /* Khoảng cách dưới mỗi đoạn văn */
			}

			#ChinhSachND ul {
				margin-top: 20px; /* Khoảng cách trên cho danh sách */
				padding-left: 20px; /* Thụt lề để làm rõ danh sách */
			}

			#ChinhSachND ul li {
				margin-bottom: 10px; /* Khoảng cách dưới mỗi mục trong danh sách */
			}

			#ChinhSachND ul li::before {
				content: "•"; /* Thêm ký hiệu đầu dòng cho danh sách */
				color: #4CAF50; /* Màu xanh cho ký hiệu đầu dòng */
				font-weight: bold;
				display: inline-block;
				width: 1em;
				margin-left: -1em;
			}
</style>
<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>Chính sách</h1>
					<p class="mb-4">
					Cảm ơn bạn đã chọn Aplus cho trải nghiệm thuê sách của mình. Tại đây cung cấp thông tin chi tiết về quyền lợi, trách nhiệm của bạn và các quy định nhằm đảm bảo giao dịch minh bạch, an toàn.
					</p> <br>
					<!--<p><a href="" class="btn btn-secondary me-2">Shop Now</a><a href="#"
							class="btn btn-white-outline">Explore</a></p>-->
				</div>
			</div>
			<div class="col-lg-7">
				<div class="hero-img-wrap">
					<img src="images/ChinhSachHeader.png" class="img-fluid">
		<!-- couch.png-->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Hero Section -->


		<!-- End Hero Section -->
		<div class="why-choose-section" id="ChinhSach">
			<div class="container" id="ChinhSachMenu">
				<h3>Menu</h3>
				<ul>
					<li><a href="#">Chính sách bảo mật</a></li>
					<li><a href="#">Chính sách thuê sách</a></li>
				</ul>
			</div>
			<div class="container" id="ChinhSachND">
				<h3>Chính sách bảo mật</h3>
				<p>
					Việc bảo lưu thông tin cá nhân của quý khách nhằm giúp chúng tôi có điều kiện nâng cao chất lượng dịch vụ để phục vụ quý khách hàng ngày một tốt hơn. APlus cam kết sử dụng thông tin khách hàng một cách hợp lý và bảo mật nhất. <br>
					<b>● Về Việc Bảo Lưu Thông Tin Khách Hàng</b> <br>
					Để sử dụng và trải nghiệm các dịch vụ của Nhà sách Phương Nam, bạn cần đăng ký tài khoản và cung cấp một số thông tin như: email, họ tên, số điện thoại, địa chỉ và một số thông tin khác. 
					Bạn có thể tùy chọn không cung cấp cho chúng tôi một số thông tin nhất định nhưng sẽ có một chút bất tiện vì khi đó, bạn sẽ không thể được hưởng một số tiện ích mà những tính năng của chúng tôi cung cấp. <br>
					Mọi thông tin bạn nhập trên website sẽ được lưu trữ để sử dụng cho mục đích phản hồi yêu cầu của khách hàng, đưa ra những gợi ý phù hợp cho từng khách hàng khi mua sắm tại website, nâng cao chất lượng hàng hóa dịch vụ và liên lạc với khách hàng khi cần thiết. <br>
					<b>● Mục Đích Sử Dụng Thông Tin</b> <br>
					Mục đích của việc bảo lưu thông tin là nhằm xây dựng nhasachphuongnam.com trở thành một website bán hàng trực tuyến mang lại nhiều tiện ích nhất cho khách hàng. Vì thế, việc sử dụng thông tin sẽ phục vụ những hoạt động sau: <br>
					- Gửi newsletter giới thiệu sản phẩm mới và những chương trình khuyến mãi của Nhà sách Phương Nam. <br>
					- Cung cấp một số tiện ích, dịch vụ hỗ trợ khách hàng. <br>
					- Nâng cao chất lượng dịch vụ khách hàng của Nhà sách Phương Nam. <br>
					- Làm cơ sở giải quyết các vấn đề khiếu nại, tranh chấp phát sinh liên quan đến việc sử dụng sản phẩm, dịch vụ tại website Nhà sách Phương Nam. <br>
					- Ngăn chặn những hoạt động vi phạm pháp luật Việt Nam <br>
					<b>● Chia Sẻ Thông Tin</b> <br>
					Chúng tôi sẽ không chia sẻ thông tin của bạn trừ những trường hợp cụ thể sau đây: <br>
					- Để bảo vệ Nhà sách Phương Nam và các bên thứ ba khác: Chúng tôi chỉ đưa ra thông tin tài khoản và những thông tin cá nhân khác khi tin chắc rằng việc đưa những thông tin đó là phù hợp với luật pháp, bảo vệ quyền lợi, tài sản của người sử dụng dịch vụ, của Nhà sách Phương Nam và các bên thứ ba khác. <br>
					- Theo yêu cầu pháp lý từ một cơ quan chính phủ hoặc khi chúng tôi tin rằng việc làm đó là cần thiết và phù hợp nhằm tuân theo các yêu cầu pháp lý. <br>
					- Trong những trường hợp còn lại, chúng tôi sẽ có thông báo cụ thể cho bạn khi phải tiết lộ thông tin cho một bên thứ ba và thông tin này chỉ được cung cấp khi được sự phản hồi đồng ý từ phía bạn. <br>
					<b>● Chính Sách Cam Kết Bảo Mật Thông Tin Khách Hàng</b> <br>
					- Chúng tôi cam kết không tiết lộ thông tin khách hàng, không bán hoặc chia sẻ thông tin khách hàng của Nhà sách Phương Nam cho bên thứ ba nào khác vì mục đích thương mại. <br>
					- Chúng tôi cam kết mọi thông tin thanh toán giao dịch trực tuyến của khách hàng đều được bảo mật và an toàn. Các thông tin tài khoản ngân hàng, thông tin thẻ tín dụng hay thông tin tài chính đều không bị lưu lại dưới bất kỳ hình thức nào. <br>
					- Quý khách không nên trao đổi những thông tin cá nhân và thông tin thanh toán của mình cho bên thứ ba nào khác để tránh rò rỉ thông tin. Khi sử dụng chung máy tính với nhiều người, vui lòng thoát khỏi tài khoản sau khi sử dụng dịch vụ của website chúng tôi để tự bảo vệ thông tin về mật khẩu truy cập của mình. <br>
					Nhà sách Phương Nam hiểu rằng quyền lợi của bạn trong việc bảo vệ thông tin cá nhân cũng chính là trách nhiệm của chúng tôi nên trong bất kỳ trường hợp có thắc mắc, góp ý nào liên quan đến chính sách bảo mật của Nhà sách Phương Nam, vui lòng liên hệ với chúng tôi qua số điện thoại <b style="color: red;">1900 6656</b> để được phúc đáp, giải quyết thắc mắc trong thời gian sớm nhất. <br> <br> <br>  <br>
				</p>
			</div>
		</div>
	



<!-- Start Footer Section -->
<?php
include('footer.php')
	?>
<!-- End Footer Section -->


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>
</body>

</html>