<?php
$postPerPage = 5;
$queryPostTotal = $conn->query("SELECT img_id FROM camera_img");
$postTotal = $queryPostTotal->rowCount();
$pageTotal = ceil($postTotal / $postPerPage);
if (isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pageTotal)
{
    $_GET['page'] = intval($_GET['page']);
    $actualPage = $_GET['page'];
}
else { $actualPage = 1;}

$start = ($actualPage - 1) *  $postPerPage;
?>