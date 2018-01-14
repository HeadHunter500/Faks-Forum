<?php

include('config.php');
if(isset($_GET['id']))
{
$id = intval($_GET['id']);
$dn1 = mysql_fetch_array(mysql_query('select count(id) as nb1, name, position from categories where id="'.$id.'" group by id'));
if($dn1['nb1']>0)
{
if(isset($_SESSION['username']) and $_SESSION['username']==$admin)
{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $design; ?>/style.css" rel="stylesheet" title="Style" />
        <title>Izbriši kategoriju</title>
    </head>
    <body>
    	<div class="header">

	    </div>
        <div class="content">
<?php
$nb_new_pm = mysql_fetch_array(mysql_query('select count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['userid'].'" and user1read="no") or (user2="'.$_SESSION['userid'].'" and user2read="no")) and id2="1"'));
$nb_new_pm = $nb_new_pm['nb_new_pm'];
?>
<div class="box">
	<div class="box_left">
    	<a href="<?php echo $url_home; ?>">Forum</a> &gt; <?php echo htmlentities($dn1['name'], ENT_QUOTES, 'UTF-8'); ?> &gt; Izbriši kategoriju
    </div>
	<div class="box_right">
    	<a href="list_pm.php">Vaša poruka(<?php echo $nb_new_pm; ?>)</a> - <a href="profile.php?id=<?php echo $_SESSION['userid']; ?>"><?php echo htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></a> (<a href="login.php">Odjava</a>)
    </div>
    <div class="clean"></div>
</div>
<?php
if(isset($_POST['confirm']))
{
	if(mysql_query('delete from categories where id="'.$id.'"') and mysql_query('delete from topics where parent="'.$id.'"') and mysql_query('update categories set position=position-1 where position>"'.$dn1['position'].'"'))
	{
	?>
	<div class="message">Kategorija je uspješno izbrisana.<br />
	<a href="<?php echo $url_home; ?>">Povratak na forum</a></div>
	<?php
	}
	else
	{
		echo 'GREŠKA';
	}
}
else
{
?>
<form action="delete_category.php?id=<?php echo $id; ?>" method="post">
	Sigurni ste da želite izbrisati kategoriju?
    <input type="hidden" name="confirm" value="true" />
    <input type="submit" value="Da" /> <input type="button" value="Ne" onclick="javascript:history.go(-1);" />
</form>
<?php
}
?>
		</div>

	</body>
</html>
<?php
}
else
{
	echo '<h2>YMorate biti admin da možete pristupiti ovom dijelu stranice: <a href="login.php">Prijava</a> - <a href="signup.php">Registracija</a></h2>';
}
}
else
{
	echo '<h2>The category you want to delete doesn\'t exist.</h2>';
}
}
else
{
	echo '<h2>The ID of the category you want to delete is not defined.</h2>';
}
?>