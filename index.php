<!DOCTYPE html>
<html lang="en">
<?php

$insert=false;
$delete=false;
$update=false;
          
          $con=mysqli_connect('localhost','root','','todolist');
          $method=$_SERVER['REQUEST_METHOD'];
          
          if(isset($_GET['delete'])){
            $sno = $_GET['delete'];
            $delete = true;
            $sql = "DELETE FROM `todolist` WHERE `todolist`.`srno` = $sno";
            $result = mysqli_query($con, $sql);
            
          }
          if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (isset( $_POST['snoEdit'])){
              // Update the record
                $sno = $_POST["snoEdit"];
                
                $title = $_POST["titleEdit"];
                
            
              // Sql query to be executed
              $sql = "UPDATE `todolist` SET `title` = '$title' WHERE `todolist`.`srno` = $sno"; 
              $result = mysqli_query($con, $sql);
              if($result){
                $update = true;
            }
        }
        else{
          $sql = "INSERT INTO `todolist` (`title`, `timestamp`) VALUES ('$title', current_timestamp());"; 
              $result = mysqli_query($con, $sql);
              $insert;
        }
       
        
    }
          ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">ToDoList</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Tasks
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="index.php">All</a>
                        <a class="dropdown-item" onclick="changeToC()" href="#">Completed</a>

                        <a class="dropdown-item" onclick="changeToP()" href="#">Pending</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <?php
    
    if($insert){
    
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your note has been added!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }

  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
    <!-- Navbar ends here -->
    <!-- Body -->

    <!--for demo wrap-->
    <script>
        function changeToC(){

            heading.innerText="Completed Tasks"
        }
        function changeToP(){
            
            heading.innerText="Pending Tasks"
        }
    </script>
      <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="index.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
    <table class="table-top">
        <tr>
            <td>
            </td>
            <td>
                <h1 id="heading">All Tasks</h1>
            </td>
            <td>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 " type="submit">Search</button>
                </form>

            </td>
        </tr>


    </table>
    <section class="table-main">
        <form class="form-inline my-2 my-lg-0" method="post" action="index.php">
            <input class="form-control py-3" type="text" name="title" placeholder="Title" id="title">
            <button class="btn btn-outline-success mx-3 my-2 " type="submit">Add</button>
        </form>

        <table>
            <tr>
                <th>Sr no.</th>
                <th>Title</th>

                <th>Actions</th>
                <th>Completed</th>
            </tr>

            <?php
                
    
    $query="SELECT * FROM `todolist`";
    $result=mysqli_query($con,$query);
    $srno=1;


          while($row=mysqli_fetch_assoc($result)){
            $srnodb=$row['srno'];
            $title=$row['title'];
            $time=$row['timestamp'];
            
            
            
            echo '<tr>
            <td>'.$srno.'</td>
            <td>'.$title.'</td>
            <td>
            
            <button type="button" id="'.$srnodb.'" class=" edit btn btn-warning">Edit</button>
            <button type="button" id="d'.$srnodb.'" class=" delete btn btn-danger">Delete</button>
            </td>
            <td>
                <input type="checkbox" name="" id="'.$srno.'">
            </td>
            </tr>';
            $srno++;
          }

          
          
          ?>

        </table>

    </section>
    </div>

    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
        
        tr = e.target.parentNode.parentNode;
        console.log(tr)
        title = tr.getElementsByTagName("td")[1].innerText;
        
       
        titleEdit.value = title;
        
        snoEdit.value = e.target.id;

        console.log(snoEdit)
        $('#editModal').modal('toggle');
      })
    })
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ");
            sno = e.target.id.substr(1);

            if (confirm("Are you sure you want to delete this note!")) {
                console.log("yes");
                window.location = `index.php?delete=${sno}`;
                // TODO: Create a form and use post request to submit a form
            } else {
                console.log("no");
            }
        })
    })
    </script>

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

</html>