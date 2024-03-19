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
        min-height: 433px;
    }
    </style>
</head>

<body>
    <?php
  include 'partial/header.php';
  include 'partial/dbconnect.php';
  ?>
    <?php
  $id=$_GET['threadid'];
  $sql="SELECT * FROM `threads` WHERE thread_id=$id";
  $result=mysqli_query($conn,$sql);
  
  while($row=mysqli_fetch_assoc($result))
  {
        
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_user_id=$row['thread_user_id'];
        $sql2="SELECT user_email FROM `user` WHERE sno='$thread_user_id'";       
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        $posted_by=$row2['user_email'];
  }
  ?>
    <?php 
    $showalert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if($method=='POST')
    {
        // insert into db                   
        $comment=$_POST['comment']; 
        $comment = str_replace("<","&lt;","$comment");       
        $comment = str_replace(">","&gt;","$comment");       
        $sno=$_POST['sno'];        
        $sql="INSERT INTO `comment` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showalert=true;
        if($showalert)
        {
            echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong>Your comment has been added!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }

    }
    ?>
    <div class="container my-4">
        <div class=" jumbotron">
            <h1 class="display-4"> <?php echo $title;?></h1>
            <p class="lead"><?php echo $desc;?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum is sharing knowledge with each others Participate in online forums as you
                would in constructive, face-to-face discussions. ...
                Postings should continue a conversation and provide avenues for additional continuous dialogue. ...
                Do not post “I agree,” or similar, statements. ...
                Stay on the topic of the thread – do not stray. </p>
            <p>Posted by <b><?php echo $posted_by; ?> </b></p>
        </div>
    </div>
    <?php
    if((isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)){
    echo'<div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <form action="'. $_SERVER["REQUEST_URI"].'" method="post">

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'. $_SESSION["sno"] .'">
            </div>
            <button type="submit" class="btn btn-success ml-3">Post Comment</button>
        </form>
    </div>';
    }
    else
    {
        echo'<p>You are not logged in</p>';
    }
    ?>
    <div class="container" id="ques">
        <h1 class="py-2">Discuession</h1>
        <?php
       $id=$_GET['threadid'];
  $sql="SELECT * FROM `comment` WHERE thread_id=$id";
  $result=mysqli_query($conn,$sql);
  $noresult=true;
  while($row=mysqli_fetch_assoc($result))
  {
    $noresult=false;
          
        
        $desc=$row['comment_content'];
        $id=$row['comment_id'];
        $comment_time=$row['comment_time'];
        $thread_user_id=$row['comment_by']; 
        $sql2="SELECT user_email FROM `user` WHERE sno='$thread_user_id'";       
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
       echo' <div class="media my-3 d-flex my-0">
            <img src="a.png" width="34px" height="34px" class="my-2" alt="...">

            <div class="media-body">
            <p class="font-weight-bold my-0"><b>'.$row2['user_email'].' at '.$comment_time .'</b></p>
                '.$desc.'
            </div>
        </div>';
  }
  if($noresult)
  {
    echo '<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <p class="display-6">No Comments found</p>
      <p class="lead">Be the first person to comments</p>
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