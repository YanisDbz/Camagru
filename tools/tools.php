<?php
session_start();
require_once 'pagination.php';

	$queryForPostLogout = "SELECT * FROM `camera_img` INNER JOIN users ON camera_img.user_id = users.id ORDER BY camera_img.img_id DESC LIMIT :start,:postPerPage";
	$stmt = $conn->prepare($queryForPostLogout);
	$result = $stmt->execute(array(
		'start'			=> $start,
		'postPerPage'	=> $postPerPage
	));
$count = $stmt->rowCount();
if($result && $count > 0)
{
	$data_post = $stmt->fetchAll();
}
?>