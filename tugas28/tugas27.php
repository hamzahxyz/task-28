<?php
session_start();

// Redirect ke halaman login jika user belum login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$host = 'localhost';
$dbname = 'tugas17'; 
$user = 'root';
$password = '';  

$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$orderBy = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
$direction = isset($_GET['direction']) && $_GET['direction'] === 'DESC' ? 'DESC' : 'ASC';

$query = "SELECT * FROM hamzah ORDER BY $orderBy $direction LIMIT $start, $limit";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalQuery = $conn->query("SELECT COUNT(*) FROM hamzah");
$totalRows = $totalQuery->fetchColumn();
$totalPages = ceil($totalRows / $limit);
?>
<!-- Rest of the code remains the same -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
h1 {
    text-align:center;
    color:grey;
    font-family:arial;
}

.logout {
    width:45px;
    margin:auto;
    padding:10px;
    border:4px;
    border-radius:24px;
    background-color:pink;
    color:white;
}
table {
    width: 750px;
    border-collapse: collapse;
    margin: auto;
    margin-top:20px;
    padding:auto;
    font-size: 16px;
    text-align: left;
    background-color: rgba(255, 255, 255, 0.8); 
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px); 
    font-family: arial, serif;
    font-style:uppercase;
}

/* Header dan Data dalam Tabel */
th, td {
    padding: 15px 20px;
}

/* Header Tabel */
thead {
    background-color: rgba(255, 105, 180, 0.9); 
    color: white;
}

thead th a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    font-style:uppercase;
}

/* Warna Baris Bergantian */
tbody tr:nth-of-type(even) {
    background-color: rgba(240, 240, 240, 0.8); /* Abu-abu muda */
}

tbody tr:hover {
    background-color: rgba(224, 224, 224, 0.9); /* Abu-abu sedikit lebih gelap */
}

/* Pagination */
.pagination {
    margin: 20px 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination a, .pagination span {
    margin: 0 5px;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 999px; 
    border: 2px solid #FF69B4; /* Border pink */
    color: #FF69B4; /* Pink */
    background-color: #ffffff;
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Hover pada Pagination */
.pagination a:hover {
    background-color: #FF69B4; /* Pink saat hover */
    color: white;
}

/* Halaman Aktif pada Pagination */
.pagination .active {
    background-color: #FF69B4; /* Pink untuk halaman aktif */
    color: white;
    pointer-events: none; 
}

/* Tombol Tidak Aktif (Prev atau Next yang tidak bisa di-klik) */
.pagination span {
    color: grey; 
    cursor: not-allowed; 
}
</style>
<body>
    <h1>selamat datang, hamzah</h1>
<div class="logout">
        <a href="logout.php" style="color: #FF69B4; text-decoration: none; font-weight: bold;">Logout</a>
    </div>
<table>
    <thead>
        <tr>
            <th><a href="?orderby=date&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Tanggal</a></th>
            <th><a href="?orderby=nik&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">NIK</a></th>
            <th><a href="?orderby=nama&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Nama</a></th>
            <th><a href="?orderby=harga&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Harga</a></th>
            <th><a href="?orderby=kuantitas&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Kuantitas</a></th>
            <th><a href="?orderby=total&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Total</a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['nik']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['harga']; ?></td>
                <td><?php echo $row['kuantitas']; ?></td>
                <td><?php echo $row['total']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Pagination -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&orderby=<?php echo $orderBy; ?>&direction=<?php echo $direction; ?>">Prev</a>
    <?php else: ?>
        <span>Prev</span>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $page): ?>
            <span class="active"><?php echo $i; ?></span>
        <?php else: ?>
            <a href="?page=<?php echo $i; ?>&orderby=<?php echo $orderBy; ?>&direction=<?php echo $direction; ?>"><?php echo $i; ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1; ?>&orderby=<?php echo $orderBy; ?>&direction=<?php echo $direction; ?>">Next</a>
    <?php else: ?>
        <span>Next</span>
    <?php endif; ?>
</div>

</body>
</html>