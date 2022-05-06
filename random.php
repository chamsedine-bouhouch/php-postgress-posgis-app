<?php
    function return_x_or_o(){
        if(rand(1,10)>5){
            return "X";
        }else{
            return "O";
        }
    }
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tic-Tac-Toe</title>
</head>
<body>
    <table>
        <tr>
            <td><?php echo return_x_or_o(); ?></td>
            <td><?php echo return_x_or_o(); ?></td>
            <td><?php echo return_x_or_o(); ?></td>
        </tr>
         <tr>
            <td><?php echo return_x_or_o(); ?></td>
            <td><?php echo return_x_or_o(); ?></td>
            <td><?php echo return_x_or_o(); ?></td>
        </tr>
        <tr>
            <td><?php echo return_x_or_o(); ?></td>
            <td><?php echo return_x_or_o(); ?></td>
            <td><?php echo return_x_or_o(); ?></td>
        </tr>
    </table>
    <?php
    if(isset($_GET['id']))
        echo $_GET['id'];
    else echo "ID not set.";

    foreach ($_GET as $key=>$val){
        echo "<br>".$key."=".$val."<br>";
    }
    ?>
</body>
</html>