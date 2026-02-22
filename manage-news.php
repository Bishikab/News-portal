<?php
session_start();
include("../config/connection.php");




if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $img = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM news WHERE id=$id"));
    if ($img && file_exists("../uploads/".$img['image'])) {
        unlink("../uploads/".$img['image']);
    }

    mysqli_query($conn, "DELETE FROM news WHERE id=$id");
    $_SESSION['success'] = "News deleted successfully!";
    header("Location: manage-news.php");
    exit();
}

$news = mysqli_query($conn, "SELECT * FROM news ORDER BY id DESC");
$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage News</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
        }
        h1 {
            text-align: center;
        }
        .top-bar {
            width: 95%;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
        }
        input[type="text"] {
            padding: 8px;
            width: 250px;
        }
        table {
            width: 95%;
            margin: 10px auto;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #783595;
            color: white;
            cursor: pointer;
        }
        img {
            width: 70px;
            height: 50px;
            object-fit: cover;
        }
        .btn {
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }
        .edit { background: #28a745; }
        .delete { background: #dc3545; }
        .success {
            width: 95%;
            margin: 10px auto;
            padding: 10px;
            background: #d4edda;
            color: #155724;
            text-align: center;
            border-radius: 4px;
        }

        .modal {
            display: none;
            position: fixed;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
            width: 300px;
        }
        .modal button {
            margin: 10px;
            padding: 6px 12px;
        }
    </style>
</head>
<body>

<h1>Manage News</h1>

<?php if($success): ?>
<div class="success" id="successMsg"><?php echo $success; ?></div>
<?php endif; ?>

<div class="top-bar">
    <input type="text" id="searchInput" placeholder="Search news...">
    <a href="dashboard.php" class="btn" style="background:#783595;">Back</a>
</div>

<table id="newsTable">
    <thead>
        <tr>
            <th onclick="sortTable(0)">ID</th>
            <th onclick="sortTable(1)">Title</th>
            <th>Category</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($news)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><img src="../uploads/<?php echo $row['image']; ?>"></td>
            <td>
                <a href="edit-news.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                <button class="btn delete" onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="modal" id="deleteModal">
    <div class="modal-content">
        <p>Are you sure you want to delete?</p>
        <button onclick="deleteNews()" style="background:#dc3545;color:white;">Yes</button>
        <button onclick="closeModal()">Cancel</button>
    </div>
</div>

<script>

setTimeout(() => {
    let msg = document.getElementById("successMsg");
    if (msg) msg.style.display = "none";
}, 3000);


document.getElementById("searchInput").addEventListener("keyup", function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#newsTable tbody tr");

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});


function sortTable(n) {
    let table = document.getElementById("newsTable");
    let rows = Array.from(table.rows).slice(1);
    let asc = table.getAttribute("data-sort") !== "asc";
    table.setAttribute("data-sort", asc ? "asc" : "desc");

    rows.sort((a, b) => {
        let x = a.cells[n].innerText;
        let y = b.cells[n].innerText;
        return asc ? x.localeCompare(y, undefined, {numeric:true}) 
                   : y.localeCompare(x, undefined, {numeric:true});
    });

    rows.forEach(row => table.tBodies[0].appendChild(row));
}


let deleteId = null;

function confirmDelete(id) {
    deleteId = id;
    document.getElementById("deleteModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("deleteModal").style.display = "none";
}

function deleteNews() {
    window.location.href = "manage-news.php?delete=" + deleteId;
}
</script>

</body>
</html>