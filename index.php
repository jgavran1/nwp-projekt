<?php 
    define('__APP__', TRUE);
    
    session_start();

    if (isset($_GET['menu'])) {
        $menu = (int)$_GET['menu'];
    } else {
        $menu = 1;
    }
    
    if(isset($_GET['action'])) { $action   = (int)$_GET['action']; }
    include_once("dbconn.php"); 
    
    if(!isset($_POST['_action_']))  { $_POST['_action_'] = FALSE;  }
    
    if (!isset($menu)) { $menu = 1; }

print '
<!DOCTYPE html>
<html>  
    <head>
    <link rel="stylesheet" href="style.css">
    <title>Woodie Foodie</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="Woodie Foodie - gole torte i ostale slastice">
    <meta name="keywords" content="html,css,home,news,gallery,contact,about">
    <meta name="author" content="Josip Gavran">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
<body>
    <header>
        <div'; 
        if ($menu == 11) { print ' class="hero-gallery"'; }
        else { print ' class="hero-image"'; }  print '></div>
        <nav>';
            include("menu.php");
        print '</nav>
    </header>
    <main>';
        if (isset($_SESSION['message'])) {
            print $_SESSION['message'];
            unset($_SESSION['message']);
        }
    
    if (!isset($menu) || $menu == 1) { include("home.php"); }
    else if ($menu == 2) { include("news.php"); }
    else if ($menu == 3) { include("news-1.php"); }
    else if ($menu == 4) { include("news-2.php"); }
    else if ($menu == 5) { include("news-3.php"); }
    else if ($menu == 6) { include("contact.php"); }
    else if ($menu == 7) { include("recipes.php"); }
    else if ($menu == 11) { include("gallery.php"); }
    else if ($menu == 8) { include("register.php"); }
    else if ($menu == 9) { include("signin.php"); }
    else if ($menu == 10) { 
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            echo "<script>
                    alert('Nemate administratorska prava za pristup ovoj stranici!');
                    window.location.href = 'index.php?menu=1';
                  </script>";
            exit; 
        }
        include("admin.php"); 
    }
    else if ($menu == 12) { include("signout.php"); }
    else if ($menu == 13) { include("converter.php"); }
    
    print '
    </main>
    <footer>
        <p>Copyright &copy; ' . date("Y") . ' Josip Gavran</p>
    </footer>
</body>
</html>';
?>