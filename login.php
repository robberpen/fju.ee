<?php session_start(); ?>
<!--.......session............-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//.....
//...........MySQL..include.
$id = $_POST['id'];
$pw = $_POST['pw'];

//.......
if($id == "admin" && $pw == "123456")
{
        $_SESSION['username'] = $id;
        //$_SESSION['username'] = $id;
        //echo '<enter>success!</center>';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=fju_layout.html>';
}
else
{
        echo '<center>fail</center>';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.html>';
}
?>
