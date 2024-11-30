<?php
$conn = new mysqli('localhost', 'nhomptud', '123456', 'ptud');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Truy vấn dữ liệu tổng hợp (Số sách, Số sách đã thuê, Doanh thu)
$sql = "
SELECT 
    (SELECT SUM(s.soLuongDangThue) FROM dausach s) AS soLuongSachDaThue,
    (SELECT SUM(t.tongTienThue) FROM donthuesach t) AS tongDoanhThu,
    (SELECT SUM(s.tongSoLuong) FROM dausach s) AS tongSoLuongSach
";

// Truy vấn số lượng sách theo từng danh mục
$sql_categories = "
SELECT dm.ten, SUM(s.tongSoLuong) AS soLuongSach
FROM danhmuc dm
JOIN dausach s ON s.maDM = dm.maDM
GROUP BY dm.ten
";

// Truy vấn số lượng sách đã thuê theo từng danh mục
$sql_rented_books_by_category = "
SELECT dm.ten, SUM(s.soLuongDangThue) AS soLuongSachDaThue
FROM danhmuc dm
JOIN dausach s ON s.maDM = dm.maDM
GROUP BY dm.ten
";

// Thực thi truy vấn 
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $rented_books = $row['soLuongSachDaThue'];
    $total_revenue = $row['tongDoanhThu'];
    $total_books = $row['tongSoLuongSach'];
} else {
    // Gán giá trị mặc định nếu không có dữ liệu
    $rented_books = 0;
    $total_revenue = 0;
    $total_books = 0;
}

// Truy vấn số lượng sách theo danh mục
$category_result = $conn->query($sql_categories);
$categories = [];
while ($row = $category_result->fetch_assoc()) {
    $categories[] = $row; 
}

// Truy vấn số lượng sách đã thuê theo danh mục
$rented_books_by_category_result = $conn->query($sql_rented_books_by_category);
$rented_books_by_category = [];
while ($row = $rented_books_by_category_result->fetch_assoc()) {
    $rented_books_by_category[] = $row; 
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo - A Plus BookStore</title>
    <link href="../layout/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 70%;  
            margin: 0 auto;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 2rem;
            color: #007bff;
            font-weight: bold;
        }

        .mb-4 {
            margin-bottom: 30px !important;
        }

        h4 {
            color: #343a40;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Báo Cáo</h1>

    <!-- Hiển thị dữ liệu tổng hợp -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Tổng số sách</h5>
                    <p class="card-text display-4"><?php echo $total_books; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Số sách đã thuê</h5>
                    <p class="card-text display-4"><?php echo $rented_books; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Doanh thu</h5>
                    <p class="card-text display-4"><?php echo number_format($total_revenue, 0, ',', '.'); ?> VND</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ Số lượng sách và Số lượng sách theo danh mục -->
    <div class="row">
        <!-- Biểu đồ Số lượng sách theo danh mục -->
        <div class="col-md-6">
            <div class="chart-container mb-4">
                <h4 class="text-center">Biểu đồ Số lượng sách theo danh mục</h4>
                <canvas id="categoryBooksChart"></canvas>
            </div>
        </div>
            <!-- Biểu đồ Số lượng sách -->
            <div class="col-md-6">
            <div class="chart-container mb-4">
                <h4 class="text-center">Tổng số sách</h4>
                <canvas id="totalBooksChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Biểu đồ Số sách đã thuê và Số sách đã thuê theo danh mục -->
    <div class="row">
        <!-- Biểu đồ Số sách đã thuê theo danh mục -->
        <div class="col-md-6">
            <div class="chart-container mb-4">
                <h4 class="text-center">Biểu đồ Số sách đã thuê theo danh mục</h4>
                <canvas id="rentedBooksByCategoryChart"></canvas>
            </div>
        </div>
          <!-- Biểu đồ Số sách đã thuê -->
          <div class="col-md-6">
            <div class="chart-container mb-4">
                <h4 class="text-center"> Số sách đã thuê</h4>
                <canvas id="rentedBooksChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Biểu đồ Doanh thu -->
    <div class="chart-container mb-4">
        <h4 class="text-center">Biểu đồ Doanh thu</h4>
        <canvas id="revenueChart"></canvas>
    </div>

</div>

<script>
    // Biểu đồ Tổng số sách
    const ctxTotalBooks = document.getElementById('totalBooksChart').getContext('2d');
    const totalBooksChart = new Chart(ctxTotalBooks, {
        type: 'bar',
        data: {
            labels: ['Tổng số sách'],
            datasets: [{
                label: 'Số sách',
                data: [<?php echo (int)$total_books; ?>],
                backgroundColor: 'rgba(75, 99, 132, 0.2)',
                borderColor: 'rgba(75, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Biểu đồ Số lượng sách theo danh mục
    const ctxCategory = document.getElementById('categoryBooksChart').getContext('2d');
    const categoryBooksChart = new Chart(ctxCategory, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($categories, 'ten')); ?>,
            datasets: [{
                label: 'Số lượng sách',
                data: <?php echo json_encode(array_column($categories, 'soLuongSach')); ?>,
                backgroundColor: 'rgba(75, 99, 132, 0.2)',
                borderColor: 'rgba(75, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                        ticks: {
                        rotation: 0 
                        }
                    },
                y: { beginAtZero: true }
            }
        }
    });

    // Biểu đồ Số sách đã thuê
    const ctx2 = document.getElementById('rentedBooksChart').getContext('2d');
    const rentedBooksChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Sách đã thuê'],
            datasets: [{
                label: 'Số sách đã thuê',
                data: [<?php echo (int)$rented_books; ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Biểu đồ Số sách đã thuê theo danh mục
    const ctxRentedCategory = document.getElementById('rentedBooksByCategoryChart').getContext('2d');
    const rentedBooksByCategoryChart = new Chart(ctxRentedCategory, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($rented_books_by_category, 'ten')); ?>,
            datasets: [{
                label: 'Số sách đã thuê',
                data: <?php echo json_encode(array_column($rented_books_by_category, 'soLuongSachDaThue')); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Biểu đồ Doanh thu
    const ctx3 = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['Doanh thu'],
            datasets: [{
                label: 'Doanh thu',
                data: [<?php echo (int)$total_revenue; ?>],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>
