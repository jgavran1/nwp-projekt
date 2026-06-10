<?php
    # Zaštita od izravnog pristupa datoteci
    if(!defined('__APP__')) {
        die("Hacking attempt");
    }

    include_once("dbconn.php");

    $error = "";
    $success = "";

    if (isset($_POST['_action_']) && $_POST['_action_'] == 'register') {
        $username = mysqli_real_escape_string($MySQL, $_POST['username']);
        $email    = mysqli_real_escape_string($MySQL, $_POST['email']);
        $password = $_POST['password']; 
        $role     = mysqli_real_escape_string($MySQL, $_POST['role']);
        
        if ($role == 'admin') {
            $admin_password = $_POST['admin_password'];
            if ($admin_password !== 'Admin123') {
                $error = "Pogrešna dodatna lozinka za registraciju administratora!";
            }
        } else {
            $role = 'user';
        }

        if (empty($error)) {
            $check_query = "SELECT id FROM users WHERE username='$username' OR email='$email'";
            $check_result = mysqli_query($MySQL, $check_query);
            
            if (mysqli_num_rows($check_result) > 0) {
                $error = "Korisničko ime ili e-mail adresa već postoje u sustavu!";
            } else {
                $hashed_password = md5($password); 
                $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', '$role')";
                
                if (mysqli_query($MySQL, $query)) {
                    $success = "Registracija uspješna kao <strong>" . ucfirst($role) . "</strong>!";
                }
            }
        }
    }
?>

<div style="padding: 20px; font-family: sans-serif; max-width: 450px; margin: 0 auto; background: #eeeeee; border-radius: 8px;">
    <!-- Naslov u plavoj boji kao na snimci -->
    <h2 style="color: #2b358a; margin-top: 0; text-align: center;">Registracija novog računa</h2>
    
    <!-- Linija je sada plava, ne crvena -->
    <hr style="border: 1px solid #2b358a; margin-bottom: 25px; width: 80%;">

    <?php if (!empty($error)): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #f5c6cb; font-weight: bold;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #c3e6cb; font-weight: bold;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <form action="index.php?menu=8" method="POST">
        <input type="hidden" name="_action_" value="register">

        <label style="display:block; margin-bottom: 5px; font-weight: bold;">Korisničko ime:</label>
        <input type="text" name="username" required style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius: 4px;">

        <label style="display:block; margin-bottom: 5px; font-weight: bold;">E-mail adresa:</label>
        <input type="email" name="email" required style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius: 4px;">

        <label style="display:block; margin-bottom: 5px; font-weight: bold;">Lozinka:</label>
        <input type="password" name="password" required style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius: 4px;">

        <label style="display:block; margin-bottom: 5px; font-weight: bold;">Uloga na stranici:</label>
        <select name="role" id="roleSelect" onchange="toggleAdminField()" style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius: 4px; font-weight: bold;">
            <option value="user">Običan korisnik (User)</option>
            <option value="admin">Administrator (Admin)</option>
        </select>

        <div id="adminPasswordField" style="display: none; background: #e7f0ff; padding: 12px; border-radius: 4px; border: 1px solid #b3d1ff; margin-bottom: 15px;">
            <label style="display:block; margin-bottom: 5px; font-weight: bold; color: #2b358a;">Unesite tajnu lozinku za Admina:</label>
            <input type="password" name="admin_password" id="adminInput" style="width:100%; padding:8px; border:1px solid #2b358a; border-radius: 4px;">
        </div>

        <!-- Gumb je sada crn s plavim rubom -->
        <input type="submit" value="Registriraj se" style="background: #000000; color: #ffffff; padding: 12px 15px; border: 2px solid #2b358a; cursor: pointer; border-radius: 4px; font-weight: bold; width: 100%; font-size: 16px;">
    </form>
</div>

<script>
function toggleAdminField() {
    var roleSelect = document.getElementById("roleSelect");
    var adminField = document.getElementById("adminPasswordField");
    var adminInput = document.getElementById("adminInput");

    if (roleSelect.value === "admin") {
        adminField.style.display = "block";
        adminInput.required = true;
    } else {
        adminField.style.display = "none";
        adminInput.required = false;
        adminInput.value = "";
    }
}
</script>