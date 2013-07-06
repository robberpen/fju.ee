<?php session_start(); ?>
<!--.......session............-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//.....
//...........MySQL..include.
$id = $_POST['id'];
$pw = $_POST['pw'];

//.......
$sql = "SELECT * FROM member_table where username = '$id'";
$result = mysql_query($sql);
$row = @mysql_fetch_row($result);

//............
//..MySQL...........
if($id != null && $pw != null && $id == "admin" && $pw == "123456")
{
        $_SESSION['username'] = $id;
        //$_SESSION['username'] = $id;
        echo '<enter>success!</center>';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=member.php>';
}
else
{
        echo '<center>fail</center>';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
}
?>
