<?php 
    print '
    <ul>
        <li><a href="index.php?menu=1">Početna</a></li>
        <li><a href="index.php?menu=2">Novosti</a></li>
        <li><a href="index.php?menu=6">Kontakt</a></li>
        <li><a href="index.php?menu=11">Galerija</a></li>
        <li><a href="index.php?menu=7">Recepti</a>
        <li><a href="index.php?menu=13">Kalkulator valuta</a></li>';
        
        if (!isset($_SESSION['user']['valid']) || $_SESSION['user']['valid'] == 'false') {
            print '
            <li><a href="index.php?menu=8">Registracija</a></li>
            <li><a href="index.php?menu=9">Prijava</a></li>';
        }
        else if ($_SESSION['user']['valid'] == 'true') {
            
            if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin') {
                print '<li><a href="index.php?menu=10">Admin</a></li>';
            }
            print '<li><a href="index.php?menu=12">Odjava</a></li>';
        }
        print '
    </ul>';
?>