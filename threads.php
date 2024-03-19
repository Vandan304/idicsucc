<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - coding forum</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 533px;
    }
    </style>
</head>

<body>
    <?php
  include 'partial/header.php';
  include 'partial/dbconnect.php';
  ?>
    <?php
  $id=$_GET['catid'];
  $sql="SELECT * FROM `categories` WHERE category_id=$id";
  $result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result))
  {
        $catdesc=$row['category_discription'];
        $catname=$row['category_name'];
  }
  ?>
    <?php 
    $showalert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if($method=='POST')
    {
        // insert into db                   
        $th_title=$_POST['title'];
        $th_desc=$_POST['desc'];
        $th_title = str_replace("<","&lt;","$th_title");       
        $th_title = str_replace(">","&gt;","$th_title");       
        $th_desc = str_replace("<","&lt;","$th_desc");       
        $th_desc = str_replace(">","&gt;","$th_desc");       
        $sno=$_POST['sno'];
        $sql="INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showalert=true;
        if($showalert)
        {
            echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong>Your thread has been added!Plzz wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }

    }

     ?>
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname;?> forums</h1>
            <p class="lead"><?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum is sharing knowledge with each others Participate in online forums as you
                would in constructive, face-to-face discussions. ...
                Postings should continue a conversation and provide avenues for additional continuous dialogue. ...
                Do not post “I agree,” or similar, statements. ...
                Stay on the topic of the thread – do not stray. </p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>


    <?php
if((isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true))
{
   echo '<div class="container">
        <h1 class="py-2">Start a discussions</h1>
    
        <form action="'. $_SERVER["REQUEST_URI"].'" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="title">
                <div id="emailHelp" class="form-text">keep your title as short and crisp as possible</div>
            </div>
            <input type="hidden" name="sno" value="'. $_SESSION["sno"] .'">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Elaborate your concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>'; 
}   
else
{
    echo "you are not logged in";
}

    ?>
    <div class="container" id="ques">
        <h1 class="py-2">Browse Questions</h1>
        <?php
  $id=$_GET['catid'];
  $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
  $result=mysqli_query($conn,$sql);
  $noresult=true; 
  while($row=mysqli_fetch_assoc($result))
  {
         $noresult=false;
        $ques=$row['thread_title'];
        $desc=$row['thread_desc'];
        $id=$row['thread_id'];
        $thread_time=$row['timestamp'];        
        $thread_user_id=$row['thread_user_id']; 
        $sql2="SELECT user_email FROM `user` WHERE sno='$thread_user_id'";       
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
         echo' <div class="media my-3 d-flex ml-3">
            <img src="a.png" width="34px" height="34px" class="mr-3 my-2" alt="...">
            <div class="media-body">
            <p class="font-weight-bold my-0"><b>Ask By '. $row2['user_email'].' at '.$thread_time .'</b></p>
                <h5 class="mt-0"><a class="text-dark remove-text-decoration" href="thread.php?threadid='.$id.'">'. $ques .'</a></h5>
                '.$desc.'
            </div>
        </div>';
  }
  if($noresult)
  {
    echo '<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <p class="display-6">No threads  found</p>
      <p class="lead">Be the first person to ask the question</p>
    </div>
  </div>';
  }
  ?>

        <?php
    include 'partial/footer.php';
  ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>
</body>

</html>