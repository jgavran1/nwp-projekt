<?php
    # Zaštita od izravnog pristupa datoteci
    if(!defined('__APP__')) {
        die("Hacking attempt");
    }

    # Spajanje na bazu podataka
    include_once("dbconn.php");

    # --- 1. AKCIJA: BRISANJE KORISNIKA ---
    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $query = "DELETE FROM users WHERE id = $id";
        mysqli_query($MySQL, $query);
        
        # Osvježi stranicu nakon brisanja i ostani na tabu korisnika
        header("Location: index.php?menu=10&tab=users");
        exit;
    }

    # --- 2. AKCIJA: SPREMANJE UREĐENIH PODATAKA KORISNIKA (UPDATE) ---
    if (isset($_POST['_action_']) && $_POST['_action_'] == 'edit_user') {
        $id = (int)$_POST['id'];
        $username = mysqli_real_escape_string($MySQL, $_POST['username']);
        $email = mysqli_real_escape_string($MySQL, $_POST['email']);
        
        $query = "UPDATE users SET username='$username', email='$email' WHERE id=$id";
        mysqli_query($MySQL, $query);
        
        # Vrati se natrag na tablicu korisnika
        header("Location: index.php?menu=10&tab=users");
        exit;
    }

    # --- 3. AKCIJA: BRISANJE PORUKE IZ DATOTEKE ---
    if (isset($_GET['action']) && $_GET['action'] == 'delete_message' && isset($_GET['msg_id'])) {
        $id_za_brisanje = $_GET['msg_id'];
        if (file_exists("poruke.txt")) {
            $sve_poruke = file("poruke.txt");
            $novi_sadrzaj = "";

            foreach ($sve_poruke as $linija) {
                $podaci = explode("|", $linija);
                if ($podaci[0] != $id_za_brisanje) {
                    $novi_sadrzaj .= $linija;
                }
            }
            file_put_contents("poruke.txt", $novi_sadrzaj);
        }
        # Vrati se natrag na tablicu poruka
        header("Location: index.php?menu=10&tab=messages");
        exit;
    }

    # Određivanje koji je tab trenutno aktivan (Korisnici su zadani)
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'users';

    echo '<div style="padding: 20px; font-family: sans-serif;">';
    echo '<h2>Administracijski Panel</h2>';

    # --- MINI IZBORNIK ZA ADMINA (Tabovi na vrhu) ---
    echo '<div style="margin-bottom: 20px; border-bottom: 2px solid #2b358a; padding-bottom: 10px;">';
    echo '<a href="index.php?menu=10&tab=users" style="padding: 10px 20px; text-decoration: none; font-weight: bold; color: ' . ($active_tab == 'users' ? 'white' : '#2b358a') . '; background: ' . ($active_tab == 'users' ? '#2b358a' : '#f1f1f1') . '; border-radius: 4px 4px 0 0; margin-right: 5px;">Korisnici</a>';
    echo '<a href="index.php?menu=10&tab=messages" style="padding: 10px 20px; text-decoration: none; font-weight: bold; color: ' . ($active_tab == 'messages' ? 'white' : '#2b358a') . '; background: ' . ($active_tab == 'messages' ? '#2b358a' : '#f1f1f1') . '; border-radius: 4px 4px 0 0;">Poruke s kontakta</a>';
    echo '</div>';

    # Zajednički CSS stilovi za tablice unutar admina (tvoj dizajn)
    ?>
    <style>
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #2b358a;
            margin-top: 15px;
        }
        .admin-table th {
            background-color: black;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border: 1px solid #2b358a;
        }
        .admin-table td {
            padding: 10px;
            border: 1px solid #2b358a;
            color: black;
            font-weight: bold;
            background-color: #ffffff;
        }
        .btn-action {
            background: #f1f1f1;
            color: black;
            padding: 4px 10px;
            text-decoration: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            margin-right: 5px;
            display: inline-block;
        }
        .btn-action:hover {
            background: #ddd;
        }
        .btn-green { background: #28a745; color: white; border-color: #28a745; }
        .btn-green:hover { background: #218838; }
        .btn-red { background: #dc3545; color: white; border-color: #dc3545; }
        .btn-red:hover { background: #c82333; }
    </style>
    <?php

    # ------------------ PRIKAZ A: KORISNICI ------------------
    if ($active_tab == 'users') {
        
        # PRIKAZ FORME ZA UREĐIVANJE KORISNIKA (Ako je kliknut 'Update')
        if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $query = "SELECT * FROM users WHERE id = $id";
            $result = mysqli_query($MySQL, $query);
            $user = mysqli_fetch_assoc($result);

            if ($user) {
                ?>
                <div style="max-width: 400px; background: #f4f4f4; padding: 20px; border-radius: 5px; border: 1px solid #ccc; margin-top: 20px;">
                    <h3>Uredi korisnika: <?php echo htmlspecialchars($user['username']); ?></h3>
                    <form action="index.php?menu=10&tab=users" method="POST">
                        <input type="hidden" name="_action_" value="edit_user">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        
                        <label style="display:block; margin-bottom: 5px; font-weight: bold;">Korisničko ime:</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required style="width:100%; padding:8px; margin-bottom:15px; border:1px solid #ccc; border-radius: 4px;"><br>
                        
                        <label style="display:block; margin-bottom: 5px; font-weight: bold;">E-mail adresa:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required style="width:100%; padding:8px; margin-bottom:15px; border:1px solid #ccc; border-radius: 4px;"><br>
                        
                        <input type="submit" value="Spremi promjene" style="background: #007BFF; color: white; padding: 10px 15px; border: none; cursor: pointer; border-radius: 4px; font-weight: bold;">
                        <a href="index.php?menu=10&tab=users" style="margin-left: 10px; color: #666; text-decoration: none; line-height: 35px;">Odustani</a>
                    </form>
                </div>
                <?php
            }
        } else {
            # GLAVNA TABLICA KORISNIKA
            ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 35%;">Username</th>
                        <th style="width: 35%;">Email</th>
                        <th style="width: 20%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT id, username, email FROM users";
                    $result = mysqli_query($MySQL, $query);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>';
                        echo '<a href="index.php?menu=10&tab=users&action=edit&id=' . $row['id'] . '" class="btn-action">Update</a>';
                        echo '<a href="index.php?menu=10&tab=users&action=delete&id=' . $row['id'] . '" class="btn-action" onclick="return confirm(\'Jeste li sigurni da želite obrisati ovog korisnika?\')">Delete</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <?php
        }
    }

    # ------------------ PRIKAZ B: PORUKE S KONTAKTA ------------------
    if ($active_tab == 'messages') {
        if (file_exists("poruke.txt") && filesize("poruke.txt") > 0) {
            $sve_poruke = file("poruke.txt");
            ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 12%;">Datum</th>
                        <th style="width: 18%;">Ime i Prezime</th>
                        <th style="width: 15%;">E-mail</th>
                        <th style="width: 10%;">Država</th>
                        <th style="width: 30%;">Poruka</th>
                        <th style="width: 15%;">Akcija</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($sve_poruke as $linija) {
                        $podaci = explode("|", trim($linija));
                        if (count($podaci) < 7) continue; 
                        
                        $msg_id = $podaci[0];
                        $datum  = $podaci[1];
                        $ime    = $podaci[2];
                        $prezime= $podaci[3];
                        $email  = $podaci[4];
                        $drzava = $podaci[5];
                        $poruka = $podaci[6];

                        echo '<tr>';
                        echo '<td>' . $datum . '</td>';
                        echo '<td>' . $ime . ' ' . $prezime . '</td>';
                        echo '<td>' . $email . '</td>';
                        echo '<td>' . $drzava . '</td>';
                        echo '<td>' . htmlspecialchars($poruka) . '</td>';
                        echo '<td>';
                        echo '<a href="mailto:' . $email . '?subject=Odgovor na upit - Woodie Foodie" class="btn-action btn-green">Odgovori</a>';
                        echo '<a href="index.php?menu=10&tab=messages&action=delete_message&msg_id=' . $msg_id . '" class="btn-action btn-red" onclick="return confirm(\'Sigurno želiš ukloniti ovu poruku?\')">Ukloni</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo '<p style="margin-top:15px; font-weight:bold; color:#666;">Nema pristiglih poruka.</p>';
        }
    }

    echo '</div>';
?>