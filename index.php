<?php 
require_once 'controllers/authController.php';
require_once 'include/header.php';
require_once 'tools/tools.php';

$curdir = dirname($_SERVER['REQUEST_URI'])."/";
?>
<body onunload="unloadP('UniquePageNameHereScroll')" onload="loadP('UniquePageNameHereScroll')">
<?php foreach ($data_post as $elem) :?>
<section class="hero mt-5">
         <div class="container">
          <div class="row">	
		  	<div class="col-lg-6 offset-lg-3">
			<div class="cardbox shadow-lg bg-white">
			 <div class="cardbox-heading">
			  <div class="media m-0">
			   <div class="d-flex mr-3">
				<a href="user_profile.php?user=<?= urlencode($elem['user_id'])?>"><img class="img-fluid rounded-circle" src="<?= $elem['user_img'] ?>" alt="User"></a>
			   </div>
			   <div class="media-body">
			    <p class="m-0"><?php echo ucwords($elem['username']);?></p>
				<small><span><i class="icon ion-md-pin"></i>Paris, France</span></small>
				<small><span><i class="icon ion-md-time"></i> <?php echo time_elapsed_string(strtotime($elem['img_date']));?></span></small>
			   </div>
			  </div><!--/ media -->
			 </div><!--/ cardbox-heading -->
			 <div class="cardbox-item">
			  <img class="w-100 img-fluid <?php if(!empty($elem['img_filter'])){echo $elem['img_filter'];}?>" src="<?php echo $elem['img']?>" alt="Image">
			 </div><!--/ cardbox-item -->
			 <div class="cardbox-base">
			  <ul class="float-right">
			   <li><a><i class="fa fa-comments"></i></a></li>
			   <li><a><em class="mr-5"><?= getTotalComment($elem['img_id'])?></em></a></li>
			   <?php $link_fb = "http://127.0.0.1" . $curdir . "post.php?post=" . urlencode($elem['img_id']) . "&display=all";?>
			   <li> <div class="fb-share-button" 
    						data-href="<?= $link_fb ?>" 
    						data-layout="button_count">
					</div>
				</li>
			  </ul>
			  <ul>
			   <form action="index.php" method="post">
				<?php if(isset($_GET['page']) AND !empty($_GET['page'])) :?>
				<input type="hidden" name="post_page" value="<?= htmlspecialchars($_GET['page'])?>">
				<?php endif;?>
			   <input type="hidden" name="post_user" value="<?php echo $elem['user_id'];?>">
			   <input type="hidden" name="post_id" value="<?php echo $elem['img_id'];?>">
			   <li><button class="btn" type="submit" name="like_btn">
			   <?php  if (checkUserLike($elem['img_id'], $_SESSION['id'])) :?>
			   <i class="fa fa-heart fa-lg text-danger"></i>
			   <?php else :?>
			   <i class="fa fa-heart-o fa-lg"></i>
			   <?php endif; ?>
				</button></li>
				<?= UserLikeData($elem['img_id']) ?>
			   <li><a><span><?= getTotalLike($elem['img_id'])?> </span></a></li>
			   </form>
			  </ul>			   
			 </div><!--/ cardbox-base -->
			 <?php if(isset($_SESSION['username'])) :?>
			 <div class="cardbox-comments">
			 <p class="txt-break"><?= getUserComment($elem['img_id'], $_SESSION['id'])?></p>
			  <span class="comment-avatar float-left">
			   <a href="profile.php"><img class="rounded-circle" src="<?php echo $_SESSION['user_img'];?>" alt="..."></a>                            
			  </span>
			  <form action="index.php" method="post">
			  <div class="search">
			  <?php if(isset($_GET['page']) AND !empty($_GET['page'])) :?>
				<input type="hidden" name="post_page" value="<?= htmlspecialchars($_GET['page'])?>">
			   <?php endif;?>
			   <input placeholder="Write a comment" name="comment" type="text" required maxlength="100">
			   <input type="hidden" name="post_user" value="<?php echo $elem['user_id'];?>">
			   <input type="hidden" name="post_id" value="<?php echo $elem['img_id'];?>">
			  </div><!--/. Search -->
			 </div><!--/ cardbox-like -->
			 <button class="btn btn-warning btn-block"type="submit" name="comment-btn"><i class="fa fa-pencil"></i></button>
			 </form>	
			<?php else: ?>
			<div class="alert alert-warning text-center wt-100">
				<p> For like or comment the post please log first just <a href="login.php">Here</a></p>
			</div>
			<?php endif;?>		
			</div><!--/ cardbox -->
		   </div>
		   <?php if (isset($_SESSION['username']) AND getTotalComment($elem['img_id']) > 0 AND getTotalComment($elem['img_id']) - getUserCommentNum($elem['img_id'], $_SESSION['id']) > 0) :?>
		   <div class="col-lg-3">
			<div class="shadow-lg p-4 mb-2 bg-white author">
			 <a href="post.php?post=<?= urlencode($elem['img_id'])?>&display=all">Display <?= getTotalComment($elem['img_id']) - getUserCommentNum($elem['img_id'], $_SESSION['id'])?> other comments</a>
			</div>
		   </div>
			<?php endif;?>
		   <!--/ col-lg-3 -->
			
          </div><!--/ row -->
		 </div><!--/ container -->
		</section>
		<div id="fb-root"></div>
<?php endforeach; ?>
<?php if(getTotalPost() > 5) : ?>
<nav>
  <ul class="pagination pg-purple justify-content-center">
    <li class="page-item <?php if($actualPage == 1){echo "disabled";} ?>">
      <a href="index.php?page=<?= $actualPage - 1; ?>" class="page-link text-dark" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
	<?php for($i = 1; $i <= $pageTotal; $i++) :?>
		<?php if($i == $actualPage) :?>
			<li class="page-item active"><a href="index.php?page=<?= $i ?>" class="page-link text-dark"><?= $i; ?></a></li>
		<?php else: ?>
			<li class="page-item"><a href="index.php?page=<?= $i ?>" class="page-link text-dark"><?=  $i; ?></a></li>
		<?php endif; ?>
	<?php endfor; ?>
    <li class="page-item <?php if($actualPage == $pageTotal){echo "disabled";} ?>">
      <a href="index.php?page=<?= $actualPage + 1; ?>" class="page-link text-dark" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>
<?php endif; ?>
<script src="js/fixscroll.js?<?php echo time();?>"></script>
<?php require_once 'include/footer.php'; ?>