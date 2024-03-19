<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - coding forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    .container {
        min-height: 82vh;
    }
    </style>
</head>

<body>
    <?php
  include 'partial/header.php';
  include 'partial/dbconnect.php';
  ?>
    <div class="container my-3">
        <h1>Search results for <em>"<?php echo $_GET['search']?>"</em></h1>
        <?php
        $noresult=true;
    $search=$_GET['search'];
     $sql="select * from threads where match(thread_title,thread_desc) against('$search')";
     $result=mysqli_query($conn,$sql);
     
     while($row=mysqli_fetch_assoc($result))
     {
           $noresult=false;
           $title=$row['thread_title'];
           $desc=$row['thread_desc'];
           $thread_id=$row['thread_id'];
           $url="thread.php?threadid=".$thread_id;
           echo '<div class="result">
     <h3><a href="'.$url.'" class="text-dark">'.$title.'</a>
     </h3>
     <p>'.$desc.'</p>
     </div>';
     }
     if($noresult)
  {
    echo '<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <p class="display-6">No Results found</p>
      <p class="lead">It looks like there aren\'t many great matches for your search
      Try shortening your search to focus on the most important keywords or phrases.
      Need help? Take a look at other tips for searching on forum.</p>
    </div>
  </div>';
  }
     
  ?>


    </div>

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