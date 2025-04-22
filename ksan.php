<?php
// Kết nối database
$servername = "localhost";
$username = "root"; // tài khoản database của bạn
$password = "";     // mật khẩu (nếu có)
$dbname = "quanlykhachsan"; // đúng tên database

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý khi thêm mới
if (isset($_POST['them'])) {
    $maks = $_POST['maks'];
    $ten = $_POST['ten'];
    $diachi = $_POST['diachiks'];
    $namxd = $_POST['namxd'];

    $sql_insert = "INSERT INTO ksan (maks, ten, diachiks, namxd) VALUES ('$maks', '$ten', '$diachi', '$namxd')";
    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>alert('Thêm thành công');</script>";
    } else {
        echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
    }
}

// Xử lý khi xóa
if (isset($_GET['xoa'])) {
    $maks_xoa = $_GET['xoa'];
    $sql_delete = "DELETE FROM ksan WHERE maks='$maks_xoa'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>alert('Xóa thành công');</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa: " . $conn->error . "');</script>";
    }
}

// Lấy danh sách khách sạn
$sql_select = "SELECT * FROM ksan";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Khách Sạn</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f7f7f7;
        }
        form {
            width: 90%;
            margin: 20px auto;
            display: flex;
            gap: 10px;
        }
        input[type="text"], input[type="number"] {
            padding: 8px;
            width: 20%;
        }
        input[type="submit"] {
            padding: 8px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-xoa {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Danh sách Khách Sạn</h2>

<!-- Form thêm khách sạn -->
<form method="post" action="">
    <input type="text" name="maks" placeholder="Mã KS" required>
    <input type="text" name="ten" placeholder="Tên" required>
    <input type="text" name="diachiks" placeholder="Địa chỉ" required>
    <input type="number" name="namxd" placeholder="Năm XD" required>
    <input type="submit" name="them" value="Thêm">
</form>

<!-- Bảng danh sách khách sạn -->
<table>
    <tr>
        <th>Mã KS</th>
        <th>Tên</th>
        <th>Địa chỉ</th>
        <th>Năm xây dựng</th>
        <th>Hành động</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['maks']."</td>";
            echo "<td>".$row['ten']."</td>";
            echo "<td>".$row['diachiks']."</td>";
            echo "<td>".$row['namxd']."</td>";
            echo "<td><a href='?xoa=".$row['maks']."' onclick=\"return confirm('Bạn có chắc muốn xóa?');\"><button class='btn-xoa'>Xóa</button></a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Chưa có dữ liệu</td></tr>";
    }
    ?>

</table>

</body>
</html>

<?php
$conn->close();
?>
