<?php

// Connecting to the database
$servername = "localHost";
$username = "root";
$password = "Shinfx@291001";
$database = "notes";

$connect = mysqli_connect($servername, $username, $password, $database);
if (!$connect) {
    die("Failed to connect! due to " . mysqli_connect_error() . "<br>");
}

// Inserting data into database

$inserted = false;
$updated = false;
$deleted = false;

if (isset($_POST['submit'])) {
    // Handle UPDATE
    if (isset($_POST['snoEdit'])) {
        $sno = mysqli_real_escape_string($connect, $_POST['snoEdit']);
        $title = mysqli_real_escape_string($connect, $_POST['titleEdit']);
        $descript = mysqli_real_escape_string($connect, $_POST['descriptEdit']);

        $sql = "UPDATE todo_data SET title='$title', descript='$descript' WHERE sno='$sno'";
        $updateData = mysqli_query($connect, $sql);

        if ($updateData) {
            $updated = true;
            // header("Location: index.php?mssg=updated");
            // exit();
        }
    } else {
        // fetching data from table
        $title = mysqli_real_escape_string($connect, $_POST['title']);
        $descript = mysqli_real_escape_string($connect, $_POST['descript']);

        //Insertion Query
        $sql = "INSERT INTO todo_data (title, descript) VALUES ('$title', '$descript')";
        $addData = mysqli_query($connect, $sql);

        if ($addData) {
            $inserted = true;
            // header("Location: index.php?mssg=inserted");
            // exit();
        }
    }
}

// Handles delete

if(isset($_POST['delete'])){
    $sno = mysqli_real_escape_string($connect, $_POST['snoDelete']);
    $sql = "DELETE FROM todo_data WHERE sno='$sno'";
    $deleteData = mysqli_query($connect, $sql);

    if($deleteData){
        $deleted = true;
        // header("location: index.php?mssg=deleted");
        // exit();
    }
}
?>

<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo G</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.8/css/dataTables.dataTables.min.css">
</head>

<body>

    <!-- Edit Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/Projects/Crud_App/index.php" method="POST" class="my-4">
                    <div class="modal-body">
                        <input type="hidden" id="snoEdit" name="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="descript" class="form-label">Note Description</label>
                            <textarea class="form-control" id="descriptEdit" name="descriptEdit" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/Projects/Crud_App/index.php" method="POST">
                    <input type="hidden" id="snoDelete" name="snoDelete">
                    <div class="modal-body">
                        Are You sure you want to delete this note?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="delete" class="btn btn-primary btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">Todo G</a>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <?php

    // Showing alert message

    if ($inserted) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Successfull!</strong> you query has been added
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }
    if ($updated) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Successfull!</strong> you query has been updated
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }

    if ($deleted) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Successfull!</strong> you query has been deleted
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }

    ?>

    <div class="container-sm w-75  my-5">
        <h2>Add a Note</h2>
        <form action="/Projects/Crud_App/index.php" method="POST" class="my-4">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="descript" class="form-label">Note Description</label>
                <textarea class="form-control" id="descript" name="descript" rows="3"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>

        <table class="table table-hover" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Discription</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Showing Inserted data via tables.

                $sql = "SELECT * FROM todo_data";
                $result = mysqli_query($connect, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno++;
                    echo
                    "<tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['descript'] . "</td>
                        <td> <button type='button' class='delete btn btn-danger'  data-bs-toggle='modal' data-sno='" . $row['sno'] . "' data-bs-target='#deleteModal'>Delete</button> 
                        <button type='button' class='edit btn btn-primary' data-bs-toggle='modal' data-sno='" . $row['sno'] . "' data-bs-target='#exampleModal'>Edit</button> 
                        </td>
                    </tr>";
                }
                ?>

            </tbody>
        </table>
    </div>

    <div>
        <script src="https://code.jquery.com/jquery-4.0.0.js"
            integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>

        <script>
            let table = new DataTable('#myTable')

            // Edit Note
            const editNote = document.querySelectorAll('.edit')
            editNote.forEach((element) => {
                element.addEventListener("click", function (event) {
                    const tr = event.target.closest('tr')
                    const title = tr.getElementsByTagName('td')[0].textContent
                    const descript = tr.getElementsByTagName('td')[1].textContent

                    snoEdit.value = event.target.dataset.sno
                    titleEdit.value = title
                    descriptEdit.value = descript
                })
            })

            // Delete Note

            const deleteNote = document.querySelectorAll('.delete')
            deleteNote.forEach(button => {
                button.addEventListener("click", function () {
                    const sno = this.dataset.sno
                    document.getElementById('snoDelete').value = sno
                })
            })
        </script>
</body>

</html>