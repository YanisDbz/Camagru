<?php 
require_once 'constants.php';

try
{
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $options);
}
catch (PDOException $e)
{
    die('Erreur : '.$e->getMessage());
}
$query = $pdo->prepare("CREATE DATABASE IF NOT EXISTS camagru");
if ($query->execute())
    echo "Database successfully created.\n";
$query->closeCursor();
try
{
    $DB_DSN = 'mysql:host=127.0.0.1;dbname=camagru;charset=utf8';
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $options);
}
catch(PDOException $e)
{
        die('Erreur : '.$e->getMessage());
}
/* Create camera */
$camera = "CREATE TABLE `camera_img`(
    `img_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `img` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
    `img_filter` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
    `img_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
$query = $pdo->prepare($camera);
if($query->execute()){
    echo "Camera_img table created !<br>";
}
else{
    echo "error<br>";
}
$query->closeCursor();

$dump_camera = "INSERT INTO `camera_img` (`img_id`, `user_id`, `img`, `img_filter`, `img_date`) VALUES
(1, 1, 'web/img/5e54093974079.jpeg', 'none', '2020-02-24 18:34:49'),
(2, 1, 'web/img/5e540cc44c983.jpeg', 'sydney', '2020-02-24 18:49:56'),
(3, 1, 'web/img/5e540cd892777.jpeg', 'arctic', '2020-02-24 18:50:16'),
(4, 1, 'web/img/5e540ced2742f.jpeg', 'texas', '2020-02-24 18:50:37'),
(5, 1, 'web/img/5e540cfe88741.jpeg', 'none', '2020-02-24 18:50:54'),
(6, 1, 'web/img/5e540d25a4d27.jpeg', 'paris', '2020-02-24 18:51:33');";

$query = $pdo->prepare($dump_camera);
if($query->execute()){
    echo "Camera_img data inserted !<br>";
}
else{
    echo "error<br>";
}
$query->closeCursor();

/* Post_comment */

$post_comment = "CREATE TABLE `post_comment` (
    `id` int(11) NOT NULL,
    `post_id` int(11) NOT NULL,
    `comment_user_id` int(11) NOT NULL,
    `post_user_id` int(11) NOT NULL,
    `comment` varchar(256) COLLATE utf8mb4_general_ci NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$query = $pdo->prepare($post_comment);
if($query->execute()){
    echo "Post comment table created !<br>";
}
else{
    echo "error<br>";
}
$query->closeCursor();

/* Post Like */

$post_like = "CREATE TABLE `post_like` (
    `id` int(11) NOT NULL,
    `post_id` int(11) NOT NULL,
    `like_user_id` int(11) NOT NULL,
    `post_user_id` int(11) NOT NULL,
    `status` tinyint(4) NOT NULL DEFAULT '0'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$query = $pdo->prepare($post_like);
if($query->execute()){
    echo "Post like table created !<br>";
}
else{
    echo "error<br>";
}
$query->closeCursor();

/* user_table */

$user = "CREATE TABLE `users` (
    `id` int(11) NOT NULL,
    `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
    `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
    `verified` tinyint(4) NOT NULL,
    `token` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
    `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
    `log_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `notification` tinyint(4) NOT NULL DEFAULT '1',
    `user_img` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'web/avatar/avatar7.png'
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$query = $pdo->prepare($user);
if($query->execute()){
    echo "User table created !<br>";
}
else{
    echo "error<br>";
}
$query->closeCursor();

$user_dump = "INSERT INTO `users` (`id`, `username`, `email`, `verified`, `token`, `password`, `log_date`, `notification`, `user_img`) VALUES
(1, 'yanis', 'yanis.debbouza96@gmail.com', 1, '83eaea7c844bb479d80eb9e237a6797da8179f3beae205d2695fdd093bf0ccfc938d21cf68c62370f9f47e70ab3e63e20110', 
'$2y$10\$rJfiO0UPmfRKU/eT07q68eWHyo/HzgC7Y/wMrl8BSdBUSDBJmRTwG', '2020-02-24 18:59:47', 1, 'web/user_img/laugh.gif');";

$query = $pdo->prepare($user_dump);
if($query->execute()){
    echo "User yanis created !<br>";
}
else{
    echo "error<br>";
}
$query->closeCursor();

/* Primary key */
$camera_indexes = "ALTER TABLE `camera_img`
ADD PRIMARY KEY (`img_id`);";
$query = $pdo->prepare($camera_indexes);
$query->execute();
$query->closeCursor();

$post_comment_indexes = "ALTER TABLE `post_comment`
ADD PRIMARY KEY (`id`);";
$query = $pdo->prepare($post_comment_indexes);
$query->execute();
$query->closeCursor();

$post_like_indexes = "ALTER TABLE `post_like`
ADD PRIMARY KEY (`id`);";
$query = $pdo->prepare($post_like_indexes);
$query->execute();
$query->closeCursor();

$user_indexes = "ALTER TABLE `users`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `email` (`email`);";
$query = $pdo->prepare($user_indexes);
$query->execute();
$query->closeCursor();

/* Auto increment */
$camera_increment = "ALTER TABLE `camera_img`
MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;";
$query = $pdo->prepare($camera_increment);
$query->execute();
$query->closeCursor();

$post_comment_increment = "ALTER TABLE `post_comment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
$query = $pdo->prepare($post_comment_increment);
$query->execute();
$query->closeCursor();

$post_like_increment = "ALTER TABLE `post_like`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
$query = $pdo->prepare($post_like_increment);
$query->execute();
$query->closeCursor();

$user_increment = "ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;";
$query = $pdo->prepare($user_increment);
$query->execute();
$query->closeCursor();

echo "All data inserted !<br>";

echo "<br>Redirection....<br>";
header("Refresh:2; url=../index.php")
?>