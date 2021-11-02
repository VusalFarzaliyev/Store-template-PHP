<?php
  include "config.php";
  $update =false;
  $id=0;
  $bookname ='';
  $category ='';
  $publisher='';
  $price    ='';
  // INSERT DATA
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['submit'])and !empty($_POST['bookname'])and !empty($_POST['category'])and !empty($_POST['publisher'])and !empty($_POST['price'])){
      $bookname = $_POST['bookname'];
      $category = $_POST['category'];
      $publisher= $_POST['publisher'];
      $price    = $_POST['price'];

      $sql = "INSERT INTO bookstore (`bookname`,`category`,`publisher`,`price`)
              VALUES('$bookname','$category','$publisher','$price')";
      $insert = mysqli_query($conn,$sql);
      if(!$insert){
        echo "Problem var!";
      }
      else{
        header("Location:index.php");
      }
    }
  }
  //SELECT LIST DATA
  $sql = " SELECT *  FROM  `bookstore` ORDER BY `id` DESC ";
  $select    = mysqli_query($conn,$sql);
  $result    = mysqli_fetch_all($select,1);
  
  // EDIT DATA
  if(isset($_GET['action']) and !empty($_GET['action']) and $_GET['action']=='edit'){
    $id = $_GET['id'];
    $res = $conn->query("SELECT * FROM bookstore WHERE id=$id") or die($conn->error());
    if($res){
      $row=$res->fetch_array();
      $update = true;
      $bookname= $row['bookname'];
      $category= $row['category'];
      $publisher= $row['publisher'];
      $price= $row['price'];
      $sql ="UPDATE bookstore SET bookname='$bookname',category='$category',publisher='$publisher',price='$price' WHERE id='$id'";
      
    }
    else{
      echo "Problem var!!!";
    }
  }
  
  // DELETE DATA
  if(isset($_GET['action']) and !empty($_GET['action']) and $_GET['action']=='del'){
    $sql= "DELETE FROM `bookstore` Where `id`=".$_GET['id'];
    $delete=mysqli_query($conn,$sql);
    if(!$delete){
      echo "sehv oldu!";
      print_r($delete);
    }
    else{
      header("Location:index.php");
    }
  }
  // DELETE ALL DATA
  if(isset($_GET['action']) and !empty($_GET['action']) and $_GET['action']=='deletall'){
    $sql = "DELETE FROM `bookstore`";
    $delete_all =mysqli_query($conn,$sql);
    if(!$delete_all){
      echo "Silinmedi!";
      print_r($delete_all);
    }
    else{
      header("Location:index.php");
    }
  }
  // SEARCH DATA
  if(isset($_POST['search'])){
    $searchKey=$_POST['search'];
    $sql = "SELECT * FROM bookstore WHERE `bookname` LIKE '%$searchKey%' ";
    $query = mysqli_query($conn,$sql);
    
    if(!$query){
        echo "sehv var";
    }
    else{
        $result = mysqli_fetch_all($query,1);    
        }
  }
  else{ 
    $sql = " SELECT * FROM  `bookstore` ORDER BY `id` DESC ";
    $select    = mysqli_query($conn,$sql);
    $result    = mysqli_fetch_all($select,1);
  }

  
  
?>


<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Book Store</title>
    <link rel="icon"type="image/icon" href="ico.jpeg">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
     <!-- Font awesome -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
   
  </head>
  <body>
      <div class="container text-center">
          <h1 class="bg-dark py-4 text-info "><i class="fas fa-store mr-2" ></i>BOOK STORE<i class="fas fa-store ml-2" ></i></h1>
          <div class="d-flex justify-content-center">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/formdata" class="w-50">
            <input type="hidden"name="id" value="<?php $result['id'];?>">
              <div class="form-gorup">
              <div class="pt-2">
                  <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-warning" ><i class="fas fa-book"></i></span>
                      </div>
                      <input value="<?php echo $bookname?>" name="bookname" type="text" class="form-control" placeholder="Book Name" >
                  </div>
                </div>
                <div class="pt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-warning" ><i class="fas fa-list"></i></span>
                      </div>
                      <input value="<?php echo $category?>" name="category" type="text" class="form-control" placeholder="Category">
                  </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-warning" ><i class="fas fa-user-friends"></i></span>
                                </div>
                                <input value="<?php echo $publisher?>" name="publisher"  type="text" class="form-control" placeholder="Publisher" >
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="pt-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-warning"><i class="fas fa-dollar-sign"></i></i></span>
                                </div>
                                <input value="<?php echo $price?>" name="price" type="text" class="form-control" placeholder="Price" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-group row">
                  <div class="form-outline col-11">
                    <input name="search" placeholder="Search" type="search" class="form-control mt-4" />
                  </div>
                  <button name="submit" type="submit" class="btn btn-primary mt-4">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
                <div class="d-flex ml-5">
                <button value="submit" type="submit" name="submit" onClick="submit" class="btn btn-success mt-4 ml-5"><i class="far fa-save"></i></button>
                <a href="index.php" type="button"  onClick="refresh" class="btn btn-primary mt-4 ml-5"><i class="fas fa-sync-alt"></i> </a>
                <a href="index.php?action=deletall" value="delete" type="delete" name="delete" class="btn btn-danger mt-4 ml-5" onclick="return confirm('Delete all data?!')"><i class="fas fa-trash-alt"></i></a>
                </div>
              </div>
            </form>
          </div>
          <div class="d-flex table-data">
            <table class="table table-striped table-dark">
              <thead class="thead-dark">
                <tr>
                  <th>№</th>
                  <th>Book Name</th>
                  <th>Category</th>
                  <th>Publisher</th>
                  <th>Price($)</th>
                  <th>Action</th>
                </tr>
                <?php
                    
                  
                    foreach($result as $key => $value)
                    {
            ?>
                <tr>
                <td><?=$value['id'];?></td>
                <td><?=$value['bookname'];?></td>
                <td><?=$value['category'];?></td>
                <td><?=$value['publisher'];?></td>
                <td><?=$value['price'];?></td>
                <td>
                    <a href="index.php?action=edit&id=<?=$value['id'];?>" name="edit" class="btn btn-primary">Edit</a>
                    <a href="index.php?action=del&id=<?=$value['id'];?>" name="delete" class="btn btn-danger">Delete</a>
                </td>
                </tr>
            <?php  } ?>
              </thead>  
            </table>
          </div>
      </div>

  </body>
</html>