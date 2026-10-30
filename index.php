
<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header('location:Login.php');
  exit();
}
require_once 'inc/header.php'; 
require_once 'db/connection.php';

$numPosts="select count(*) as total from posts";
$resQuery=mysqli_query($connect,$numPosts);
$totalPosts=mysqli_fetch_assoc($resQuery)['total'];

if(isset($_GET['page'])){
    $page=$_GET['page'];
}else{
    $page=1;
}

$limit=3;
$offset=($page-1)*$limit;
$numberOfPages=ceil($totalPosts/$limit);
if($page < 1){
  header("Location:index.php?page=1");
  exit();
}elseif($page > $numberOfPages){
  header("Location:index.php?page=$numberOfPages");
  exit();
}
$query="SELECT * FROM posts limit $limit offset $offset";
$result=mysqli_query($connect,$query);
$posts=mysqli_fetch_all($result,MYSQLI_ASSOC);
?>
    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="banner header-text">
      <div class="owl-banner owl-carousel">
        <div class="banner-item-01">
          <div class="text-content">
            <!-- <h4>Best Offer</h4> -->
            <!-- <h2>New Arrivals On Sale</h2> -->
          </div>
        </div>
        <div class="banner-item-02">
          <div class="text-content">
            <!-- <h4>Flash Deals</h4> -->
            <!-- <h2>Get your best products</h2> -->
          </div>
        </div>
        <div class="banner-item-03">
          <div class="text-content">
            <!-- <h4>Last Minute</h4> -->
            <!-- <h2>Grab last minute deals</h2> -->
          </div>
        </div>
      </div>
    </div>
    <!-- Banner Ends Here -->
    

    <div class="latest-products">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <?php
     if(isset($_SESSION['successLogin'])){
            ?> 
            <div class="alert alert-success w-25">
            <p> 
            <?php
            echo $_SESSION['successLogin'];
            ?>
            </p>
            </div> <?php
        }
        unset($_SESSION['successLogin']);
        ?>
        <?php
     if(isset($_SESSION['successPost'])){
            ?> 
            <div class="alert alert-success w-25">
            <p> 
            <?php
            echo $_SESSION['successPost'];
            ?>
            </p>
            </div> <?php
        }
        unset($_SESSION['successPost']);
        ?>
        <?php if(isset($_SESSION['successPostUpdate'])){
            ?> 
            <div class="alert alert-success w-25">
            <p> 
            <?php
            echo $_SESSION['successPostUpdate'];
            ?>
            </p>
            </div> <?php
        }
        unset($_SESSION['successPostUpdate']);
        ?>
            <div class="section-heading">
              <h2>Latest Posts</h2>
              <!-- <a href="products.html">view all products <i class="fa fa-angle-right"></i></a> -->
            </div>
          </div>
          <?php foreach($posts as $post){ ?>
          <div class="col-md-4">
            <div class="product-item">
              <a href="#"><img src="assets/images/postImage/<?=$post['image']; ?>" alt=""></a>
              <div class="down-content">
                <a href="#"><h4><?=$post['title']; ?></h4></a>
                <h6><?=$post['created_at']; ?></h6>
                <p><?=$post['body'];?> </p>
                <!-- <ul class="stars">
                  <li><i class="fa fa-star"></i></li>
                  <li><i class="fa fa-star"></i></li>
                  <li><i class="fa fa-star"></i></li>
                  <li><i class="fa fa-star"></i></li>
                  <li><i class="fa fa-star"></i></li>
                </ul>
                <span>Reviews (24)</span> -->
                <div class="d-flex justify-content-end">
                  <a href="viewPost.php?id=<?=$post['id']; ?>" class="btn btn-info "> view</a>
                </div>
                
              </div>
            </div>
          </div>
          <?php } ?>
          
        </div>
      </div>
      <nav aria-label="Page navigation example" class="d-flex justify-content-center">
  <ul class="pagination">
    <li class="page-item <?php if($page==1) echo "disabled"; ?>"><a class="page-link" href="index.php?page=<?=$page-1; ?>">Previous</a></li>
    <?php for($i=1;$i<=$numberOfPages;$i++){ ?>
    <li class="page-item"><a class="page-link" href="index.php?page=<?=$i; ?>"><?=$i; ?></a></li>
    <?php } ?>
    
    <li class="page-item <?php if($page==$numberOfPages) echo "disabled"; ?>"><a class="page-link" href="index.php?page=<?=$page+1; ?>">Next</a></li>
  </ul>
</nav>
    </div>

 
    
<?php require_once 'inc/footer.php' ?>
