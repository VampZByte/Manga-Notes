<?php
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'];
    $content = $_POST['content'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE notes SET title=?, content=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $content, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO notes (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
    }

    $stmt->execute();
    header("Location: index.php");
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM notes WHERE id=$id");
    header("Location: index.php");
}


$result = $conn->query("SELECT * FROM notes ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Notepad</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2 class="text-center">Manga Notes</h2>

    <form method="POST" class="mb-3">
        <input type="hidden" name="id" id="note-id">
        <input type="text" name="title" id="note-title" class="form-control mb-2" placeholder="Note Title" required style="height: 50px; font-size: 1.5rem; padding: 15px;">
        <textarea name="content" id="note-content" class="form-control mb-2" placeholder="Note Content" required style="height: 750px; font-size: 1.5rem; padding: 15px;"></textarea>
        <button type="submit" class="btn btn-success">Save Note</button>
        <button type="reset" class="btn btn-secondary" onclick="clearForm()">Clear</button>
    </form>

    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td>
                    <div class="note-content" id="note-<?= $row['id'] ?>">
                        <?= nl2br(htmlspecialchars($row['content'])) ?>
                    </div>
                    <button class="btn btn-link btn-sm toggle-btn" onclick="toggleNote(<?= $row['id'] ?>)">See More</button>
                </td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="editNote(<?= $row['id'] ?>, '<?= addslashes($row['title']) ?>', '<?= addslashes($row['content']) ?>')">Edit</button>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this note?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script>
    function toggleNote(id) {
        let note = document.getElementById(`note-${id}`);
        let button = note.nextElementSibling;

        if (note.classList.contains("expanded")) {
            note.classList.remove("expanded");
            button.textContent = "See More";
        } else {
            note.classList.add("expanded");
            button.textContent = "Minimize";
        }
    }
</script>

<style>
    .note-content {
        max-height: 50px; 
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .expanded {
        max-height: none;
        white-space: normal;
    }
</style>


    <script>
        function editNote(id, title, content) {
            document.getElementById("note-id").value = id;
            document.getElementById("note-title").value = title;
            document.getElementById("note-content").value = content;
        }

        function clearForm() {
            document.getElementById("note-id").value = "";
            document.getElementById("note-title").value = "";
            document.getElementById("note-content").value = "";
        }
    </script>
</body>
</html>
