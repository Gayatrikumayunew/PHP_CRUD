<?php

$servername = "localhost";
$usernmae = "root";
$password = "";
$database = "crud";

$conn = mysqli_connect($servername, $usernmae, $password, $database);

if (!$conn) {
    die("Sorry! Failed to connect with database" . mysqli_connect_error());
}

//updation



// insertion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['serialnoedit']) && !empty($_POST['serialnoedit'])) {
        $id = $_POST['serialnoedit'];
        $title =  htmlspecialchars( $_POST['titleEdit']);
        $descr =  htmlspecialchars($_POST['descriptionEdit']);
        $sql = "UPDATE `notes` SET `title` = '$title' ,`descr`='$descr' WHERE `sno` = '$id' ";

        if ($result = mysqli_query($conn, $sql)) {

            $insert = 'Your note has been update successfully.';
            header("Location: index.php?data=" . urlencode($insert));
        } else {
            $error = mysqli_error($conn);
            $insert = 'Your note has been  not Update .'.  $error;
            header("Location: index.php?data=" . urlencode($insert));
        }

    } else if (isset($_POST['add_note']) && !empty($_POST['title'])  && !empty($_POST['descr'])) {
        $title = htmlspecialchars($_POST['title']);
        $descr = htmlspecialchars($_POST['descr']);

        $sql = "INSERT INTO `notes` (`title` , `descr`) VALUES('$title','$descr')";
        if ($result = mysqli_query($conn, $sql)) {

            $insert = 'Your note has been inserted successfully.';
            header("Location: index.php?data=" . urlencode($insert));
        } else {
            $error = mysqli_error($conn);
            $insert = 'Your note has been  not inserted .' . $error;
            header("Location: index.php?data=" . urlencode($insert));
        }
    } else {
        $insert = 'Action not allow ';

        header("Location: index.php?data=" . urlencode($insert));
    }
}

if (isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM `notes` WHERE `sno` = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $insert =  "Note deleted successfully.";
        header("Location: index.php?data=" . urlencode($insert));
    } else {
        $insert = "Failed to delete the note.";
        header("Location: index.php?data=" . urlencode($insert));
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php crud app</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js">
    <style>
        .container {
            text-align: center;
            margin-top: 20px;
            display: flex;
            flex-direction: column;

        }

        .label {
            display: flex;
            flex-direction: flex-start;
            /* margin-left: 260px; */
        }

        .input {
            height: 70px;
        }

        button {
            color: white;
            background-color: #0070d3;
            width: fit-content;
            padding: 5px 10px;
            margin-top: 8px;
            outline: none;
            border: none;

        }

        .tab {
            width: 85%;
            margin-left: 120px
        }
    </style>
</head>

<body>
   
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="index.php" method="post">
                    <input type="hidden" name="serialnoedit" id="editId">

                        <div class="container">
                            <h2>Edit Your Note</h2>
                            <label for="title">Note Title</label>

                            <input type="text" class="form control" id="titleEdit" name="titleEdit">

                            <label for="desc" class="label"> Note Description</label>

                            <textarea name="descriptionEdit" id="descriptionEdit" class="form-control" rows="3"></textarea>
                            <button type="submit" name="update">Update Note</button>


                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>




    <!-- navbar  -->
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">iNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Contact
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- alert  -->
    <?php
    if (isset($_GET['data'])  && !empty($_GET['data'])) {
    ?>
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <?= $_GET['data'] ?>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
    <?php } ?>
    <!-- creating form  -->
    <form action="#" method="post">
        <input type="hidden" name="serialnoedit" id="serialnoedit">
        <div class="container">
            <h2>Add a Note</h2>
            <label for="note" class="label">Note Title</label>

            <input type="text" size="100" id="note" name="title">

            <label for="desc" class="label">Note Description</label>

            <input type="textfield" class="input " size="100" id="desc" name="descr">
            <button type="submit" name="add_note">Add Note</button>


        </div>

    </form>
    <div class="container2">
        <!-- //table  -->
        <div class="tab">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">Sno</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
        </div>

        <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $num = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $num = $num + 1;
            echo "
          <tr>
          <th>" . $num . "</th>
          <td>" . $row['title'] . "</td>
          <td>" . $row['descr'] . "</td>
         <td>
         <a href='./index.php?delete_id=" . $row['sno'] . "' class='btn btn-sm btn-primary'>Delete</a>
         <button class='edit btn btn-sm btn-primary' id=" . $row['sno'] . ">Edit</button>
     </td>";
        } ?>
        </tbody>
        </table>
        <hr>
    </div>
    <!-- modal  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



    <!-- j queru  -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        let table = new DataTable('#myTable');
    </script>
   
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit");
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);

            // Set values in the edit form
            titleEdit.value = title;
            descriptionEdit.value = description;
            serialnoedit.value = e.target.id;

            // Update the ID value in the hidden input field
            document.getElementById("editId").value = e.target.id;

            console.log(e.target.id);
            $('#editModal').modal('toggle');
        });
    });
</script>



</body>

</html>