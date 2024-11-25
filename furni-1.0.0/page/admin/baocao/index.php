<?php
// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('localhost', 'nhomptud', '123456', 'ptud');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// truy vấn dữ liệu
$sql = "
SELECT 
    (SELECT SUM(c.soLuongDangThue) FROM dausach c)  AS soLuongSachDaThue,
    (SELECT SUM(d.tongTienThue) FROM donthuesach d) AS tongDoanhThu,
    (SELECT SUM(s.tongSoLuong) FROM dausach s) AS tongSoLuongSach
";

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
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Báo Cáo</h1>

        <!-- Bộ lọc ngày -->
        <form class="mb-4" method="GET" action="report.php">
            <div class="row">
                <div class="col-md-5">
                    <label for="start_date" class="form-label">Ngày bắt đầu</label>
                    <input type="date" id="start_date" name="start_date" class="form-control"
                           value="<?php echo isset($start_date) ? $start_date : ''; ?>" required>
                </div>
                <div class="col-md-5">
                    <label for="end_date" class="form-label">Ngày kết thúc</label>
                    <input type="date" id="end_date" name="end_date" class="form-control"
                           value="<?php echo isset($end_date) ? $end_date : ''; ?>" required>
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                </div>
            </div>
        </form>

        <!-- Hiển thị dữ liệu -->
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

        <!-- Biểu đồ -->
        <canvas id="reportChart"></canvas>
    </div>

    <script>
    // Tạo dữ liệu biểu đồ
    const ctx = document.getElementById('reportChart').getContext('2d');
    const reportChart = new Chart(ctx, {
        type: 'bar', // Biểu đồ cột là mặc định
        data: {
            labels: ['Tổng số sách', 'Sách đã thuê', 'Doanh thu (VND)'],
            datasets: [
                {
                    label: 'Thống kê (Cột)', // Biểu đồ cột
                    data: [<?php echo (int)$total_books; ?>, <?php echo (int)$rented_books; ?>, <?php echo (int)$total_revenue; ?>],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',  
                        'rgba(54, 162, 235, 0.2)',  
                        'rgba(255, 99, 132, 0.2)'   
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)', 
                        'rgba(54, 162, 235, 1)', 
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1,
                    fill: true, 
                },
                {
                    label: 'Thống kê (Đường)', // Biểu đồ đường
                    data: [<?php echo (int)$total_books; ?>, <?php echo (int)$rented_books; ?>, <?php echo (int)$total_revenue; ?>],
                    type: 'line', 
                    fill: false, 
                    borderColor: [
                        'rgba(75, 192, 192, 1)', 
                        'rgba(54, 162, 235, 1)', 
                        'rgba(255, 99, 132, 1)'
                    ],
                    tension: 0.4, 
                    borderWidth: 2, 
                    pointRadius: 5, 
                    pointBackgroundColor: [
                        'rgba(75, 192, 192, 1)', 
                        'rgba(54, 162, 235, 1)', 
                        'rgba(255, 99, 132, 1)'
                    ],
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true 
                }
            },
            scales: {
                y: {
                    beginAtZero: true 
                }
            }
        }
    });
    </script>

</body>
</html>
