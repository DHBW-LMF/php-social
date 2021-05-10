<?php
$currentpage = "home";
include('src/php/header.php');

$sql = "SELECT COUNT(*) AS ergebnis FROM post WHERE userID=".$_SESSION['userID'];
$row = mysqli_fetch_object($db->query($sql));
$userposts = $row->ergebnis;

$sql = "SELECT COUNT(*) AS ergebnis FROM follows WHERE `following`=".$_SESSION['userID'];
$row = mysqli_fetch_object($db->query($sql));
$userfollowers = $row->ergebnis;

$sql = "SELECT COUNT(*) AS ergebnis FROM follows WHERE userID=".$_SESSION['userID'];
$row = mysqli_fetch_object($db->query($sql));
$userfollowing = $row->ergebnis;

?>

<br>
<div class="container-fluid content">
    <div class="row">
        <div class="col-3 side">
            <div class="sidebar">
                <div class="personal">
                    <div class="profile-side-info">
                        <div class="center">
                            <a href="profile.php?user=<?php echo($_SESSION['username']) ?>">
                                <img src="<?php echo(getProfileAvatar($_SESSION['avatar'])) ?>" class="profile-pic-side"/>
                            </a>
                            <b><a class="post-username" href="profile.php?user=<?php echo ($_SESSION['username'] . "\">". $_SESSION['username'] . "</a>"); ?></b>
                            <b class="material-icons verified-follow"><?php echo ($_SESSION['verified'] ? 'verified' : ''); ?></b>
                        </div><br>
                        <div class="row">
                            <div class="col profile-info-row-content">
                                <?php echo($userposts); ?>
                            </div>
                            <div class="col profile-info-row-content">
                                <?php echo($userfollowers); ?>
                            </div>
                            <div class="col profile-info-row-content">
                                <?php echo($userfollowing); ?>
                            </div>
                        </div>           
                        <div class="row">
                            <div class="col profile-info-row">Posts </div>
                            <div class="col profile-info-row">Follower</div>
                            <div class="col profile-info-row">Folge ich</div>
                        </div>
                    </div>
                    <a href="post.php" class="profile-info-button">Neuen Post erstellen</a>
                </div>
                <div class="following">
                    <h3>Folge ich:</h3><br>
                    <?php
                    $sql = "SELECT * FROM follows INNER JOIN user ON follows.following = user.id WHERE follows.userID=".$_SESSION['userID'];
                    $res = $db->query($sql);
                    while($row = mysqli_fetch_object($res)) {
                        echo('
                        <div class="follower">
                            <a href="profile.php?user='.$row->username.'">
                                <img src="' . getProfileAvatar($row->avatar) . '" class="profile-pic-follow"/>
                            </a>
                            <b><a class="post-username" href="profile.php?user='.$row->username.'">'.$row->username.'</a></b>
                            <b class="material-icons verified-follow">'.($row->verified ? 'verified' : '').'</b>
                        </div>
                        <br>');
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="center-div">
                <?php
                    $query = "";
                    if(isset($_GET['query'])) {
                        echo('
                        <a class="material-icons arrow-back text-primary" onclick="window.history.back();">arrow_back</a>
                        <form method="get" action="index.php" class="search-form">
                            <div class="searchbar-main">
                                <input class="search_input-main" type="text" pattern="#[a-zA-Z0-9]+" name="query" value="'.$_GET['query'].'" placeholder="Search...">
                                <span class="material-icons fas fa-search">search</span>
                            </div>
                        </form>
                        ');
                        $query = htmlspecialchars("AND post.content LIKE '% ".$_GET['query']." %'");
                    }
                    echo getUserPosts(-1, $db, $query);
                ?>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</div>


<?php include('src/php/footer.php'); ?>