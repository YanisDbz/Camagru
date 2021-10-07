<?php 
require_once 'controllers/authController.php';
require_once 'include/header.php';
require_once 'tools/commentConf.php';

if($_GET['display'] != 'all' || empty($_GET['post']) || empty($_GET['display'])){
	header('location: index.php');
}
$curdir = dirname($_SERVER['REQUEST_URI'])."/";
?>
<section class="hero mt-5">
         <div class="container">
          <div class="row">	
		  	<div class="col-lg-6 offset-lg-3">
			<div class="cardbox shadow-lg bg-white">
			 <div class="cardbox-heading">
			  <div class="media m-0">
			   <div class="d-flex mr-3">
				<a href="user_profile.php?<?= urlencode($user['user_id'])?>"><img class="img-fluid rounded-circle" src="<?php echo $user['user_img'];?>" alt="User"></a>
			   </div>
			   <div class="media-body">
			    <p class="m-0"><?php echo ucwords($user['username']);?></p>
				<small><span><i class="icon ion-md-pin"></i>Paris, France</span></small>
				<small><span><i class="icon ion-md-time"></i> <?php echo time_elapsed_string(strtotime($user['img_date']));?></span></small>
			   </div>
			  </div><!--/ media -->
			 </div><!--/ cardbox-heading -->			  
			 <div class="cardbox-item">
			  <img class="w-100 img-fluid <?php if(!empty($user['img_filter'])){echo $user['img_filter'];}?>" src="<?php echo $user['img']?>" alt="Image">
			 </div><!--/ cardbox-item -->
			 <div class="cardbox-base">
			  <ul class="float-right">
			   <li><a><i class="fa fa-comments"></i></a></li>
			   <li><a><em class="mr-5"><?= getTotalComment($user['img_id'])?></em></a></li>
			   <?php $link_fb = "http://127.0.0.1" . $curdir . "post.php?post=" . urlencode($elem['img_id']) . "&display=all";?>
			   <li> <div class="fb-share-button" 
    						data-href="<?= $link_fb ?>" 
    						data-layout="button_count">
					</div>
				</li>
			  </ul>
			  <ul>
			   <form action="index.php" method="post">
			   <input type="hidden" name="post_user" value="<?php echo $user['user_id'];?>">
			   <input type="hidden" name="post_id" value="<?php echo $user['img_id'];?>">
			   <li><button class="btn" type="submit" name="like_btn_comment">
			   <?php  if (checkUserLike($user['img_id'], $_SESSION['id'])) :?>
			   <i class="fa fa-heart fa-lg text-danger"></i>
			   <?php else :?>
			   <i class="fa fa-heart-o fa-lg"></i>
			   <?php endif; ?>
				</button></li>
				<?= UserLikeData($user['img_id']) ?>
			   <li><a><span><?= getTotalLike($user['img_id'])?> </span></a></li>
			   </form>
			  </ul>	   
			 </div><!--/ cardbox-base -->
			 <?php if(isset($_SESSION['username'])) :?>
			 <div class="cardbox-comments">
			  <span class="comment-avatar float-left">
			   <a href="profile.php"><img class="rounded-circle" src="<?php echo $_SESSION['user_img'];?>" alt="..."></a>                            
			  </span>
			  <form index="index.php" method="post">
			  <div class="search">
			   <input placeholder="Write a comment" name="comment" type="text" required>
			   <input type="hidden" name="post_user" value="<?php echo $user['user_id'];?>">
			   <input type="hidden" name="post_id" value="<?php echo $user['img_id'];?>">
			  </div><!--/. Search -->
			 </div><!--/ cardbox-like -->
			 <button class="btn btn-warning btn-block"type="submit" name="comment-btn-comment"><i class="fa fa-pencil"></i></button>
			 </form>	
			<?php else: ?>
			<div class="alert alert-warning text-center wt-100">
				<p> For like or comment the post please log first just <a href="login.php">Here</a></p>
			</div>
			<?php endif;?>		
			</div><!--/ cardbox -->
		   </div>
		   <div class="col-lg-3">
			<div class="shadow-lg p-4 mb-2 bg-white author">
			<div class="author">
             <?php foreach ($allComment as $comment) :?>
			<p class="txt-break"><?= getUsername($comment['comment_user_id']) . ' ' . $comment['comment'] ?></p>
			<?php endforeach;?>
			</div>
			</div>
		   </div>
		   <!--/ col-lg-3 -->		
          </div><!--/ row -->
		 </div><!--/ container -->
		</section>
<script src="js/fixscroll.js?<?php echo time();?>"></script>
<?php require_once 'include/footer.php'; ?>