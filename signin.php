<?php
    if(!defined('__APP__')) {
        die("Hacking attempt");
    }

    include_once("dbconn.php");

    $error = "";

    if (isset($_POST['_action_']) && $_POST['_action_'] == 'signin') {
        $username = mysqli_real_escape_string($MySQL, $_POST['username']);
        $password = $_POST['password'];
        
        $hashed_password = md5($password);
        
        $query  = "SELECT * FROM users WHERE username='$username' AND password='$hashed_password'";
        $result = mysqli_query($MySQL, $query);
        
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            
            $_SESSION['user']['valid'] = 'true';
            $_SESSION['user']['id'] = $row['id'];
            $_SESSION['user']['username'] = $row['username'];
            
            $_SESSION['user']['role'] = $row['role']; 
            
            if (isset($row['first_name']) && isset($row['last_name'])) {
                $_SESSION['user']['fullname'] = $row['first_name'] . ' ' . $row['last_name'];
            } else {
                $_SESSION['user']['fullname'] = $row['username'];
            }
            
            echo '<meta http-equiv="refresh" content="0; URL=index.php?menu=1">';
            exit;
        } else {
            $error = "Pogrešno korisničko ime ili lozinka!";
        }
    }
?>

<div style="padding: 20px; font-family: sans-serif; max-width: 450px; margin: 0 auto; background: #eeeeee; border-radius: 8px;">
    <h2 style="color: #2b358a; margin-top: 0; text-align: center;">Prijava u sustav</h2>
    
    <hr style="border: 1px solid #2b358a; margin-bottom: 25px; width: 80%;">

    <?php if (!empty($error)): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #f5c6cb; font-weight: bold;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?menu=9" method="POST">
        <input type="hidden" name="_action_" value="signin">

        <label style="display:block; margin-bottom: 5px; font-weight: bold;">Korisničko ime:</label>
        <input type="text" name="username" required style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius: 4px;">

        <label style="display:block; margin-bottom: 5px; font-weight: bold;">Lozinka:</label>
        <input type="password" name="password" required style="width:100%; padding:10px; margin-bottom: 20px; border:1px solid #ccc; border-radius: 4px;">

        <input type="submit" value="Prijavi se" style="background: #000000; color: #ffffff; padding: 12px 15px; border: 2px solid #2b358a; cursor: pointer; border-radius: 4px; font-weight: bold; width: 100%; font-size: 16px;">
    </form>
</div>