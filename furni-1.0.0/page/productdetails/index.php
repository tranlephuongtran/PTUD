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
if (!isset($_GET['productdetails'])) {
    $productdetails = 1;
} else {
    $productdetails = $_GET['productdetails'];
}
?>

<style>
    .custom-button {
        background-color: #d44620;
        color: white;
        border: 3px solid #d44620;
        transition: background-color 0.3s ease;
        border-radius: 10px;
    }

    .custom-button:hover {
        background-color: #a76d49;
        color: white;
        border: 3px solid #a76d49;
    }

    .custom-button img {
        color: #983d1e;
        width: 24px;
        height: 24px;
    }

    .product-detail-container {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #f8f8f8;
    }

    .product-info-container {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #f8f8f8;
    }

    .product-description-container {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #f8f8f8;
    }
</style>
<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content ">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1> Chi Tiết Sản Phẩm</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-4 mb-2 mb-md-0">
                <div class="p-2 p-lg-4 product-detail-container">
                    <div class="row">
                        <img src="layout/images/CayCamNgotCuaToi.png" style="width: 400px;height: 538px;"
                            class="img-fluid product-thumbnail">
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class=" btn custom-button mt-4    " onclick="window.location='#'"><img
                                    src="layout/images/cart.svg"> Thêm
                                Vào Giỏ Hàng</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="col-md-12">
                    <div class="p-2 p-lg-4 product-info-container">
                        <h2>Cây Cam Ngọt Của Tôi</h2>
                        <div class="row">
                            <div class="col-6">
                                <p>Tác giả: <b>José Mauro de Vasconcelos</b></p>
                            </div>
                            <div class="col-6">
                                <p>Nhà xuất bản: <b>NXB Hội Nhà Văn</b></p>
                            </div>
                        </div>
                        <h4 class="text-success">Giá thuê: 17.000 VND</h4>
                        <h4 class="text-success">Tiền cọc: 187.000 VND</h4>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <input type="number" id="quantity" class="form-control" value="1" min="1"
                                style="width: 100px;">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="p-2 p-lg-4 product-description-container">
                        <h2 class="h3 mb-3 text-black">Thông tin chi tiết</h2>
                        <table class="table site-block-order-table mb-3">
                            <tbody>
                                <tr>
                                    <td class=" font-weight-bold">Mã ISBN
                                    </td>
                                    <td class="text-black"><strong>978-3-16-148410-0</strong></td>
                                </tr>
                                <tr>
                                    <td class=" font-weight-bold">Tác giả
                                    </td>
                                    <td class="text-black"><strong>José Mauro de Vasconcelos</strong></td>
                                </tr>
                                <tr>
                                    <td class=" font-weight-bold">Danh mục
                                    </td>
                                    <td class="text-black"><strong>Tiểu thuyết</strong></td>
                                </tr>
                                <tr>
                                    <td class=" font-weight-bold">Năm xuất bản
                                    </td>
                                    <td class="text-black"><strong>2020</strong></td>
                                </tr>
                                <tr>
                                    <td class=" font-weight-bold">Nhà xuất bản
                                    </td>
                                    <td class="text-black"><strong>NXB Hội Nhà Văn</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="p-3 p-lg-5 product-description-container">
                    <h3>Mô tả sản phẩm</h3>
                    <p style="text-align: justify;">
                        Mở đầu bằng những thanh âm trong sáng và kết thúc lắng lại trong những nốt trầm hoài
                        niệm,
                        Cây cam ngọt của tôi khiến ta nhận ra vẻ đẹp thực sự của cuộc sống đến từ những điều
                        giản dị
                        như bông hoa trắng của cái cây sau nhà, và rằng cuộc đời thật khốn khổ nếu thiếu đi lòng
                        yêu
                        thương và niềm trắc ẩn. Cuốn sách kinh điển này bởi thế không ngừng khiến trái tim người
                        đọc
                        khắp thế giới thổn thức, kể từ khi ra mắt lần đầu năm 1968 tại Brazil.
                        <br>
                        <b>TÁC GIẢ:</b>
                        <br>
                        JOSÉ MAURO DE VASCONCELOS (1920-1984) là nhà văn người Brazil. Sinh ra trong một gia
                        đình
                        nghèo ở ngoại ô Rio de Janeiro, lớn lên ông phải làm đủ nghề để kiếm sống. Nhưng với tài
                        kể
                        chuyện thiên bẩm, trí nhớ phi thường, trí tưởng tượng tuyệt vời cùng vốn sống phong phú,
                        José cảm thấy trong mình thôi thúc phải trở thành nhà văn nên đã bắt đầu sáng tác năm 22
                        tuổi. Tác phẩm nổi tiếng nhất của ông là tiểu thuyết mang màu sắc tự truyện Cây cam ngọt
                        của
                        tôi. Cuốn sách được đưa vào chương trình tiểu học của Brazil, được bán bản quyền cho hai
                        mươi quốc gia và chuyển thể thành phim điện ảnh. Ngoài ra, José còn rất thành công trong
                        vai
                        trò diễn viên điện ảnh và biên kịch.<br>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/tiny-slider.js"></script>
<script src="js/custom.js"></script>