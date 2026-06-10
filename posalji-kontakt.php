<?php
// 1. Podaci za spajanje na tvoju bazu podataka
$host = "localhost";
$user = "root";       // Tvoje korisničko ime za bazu (češće 'root')
$pass = "";           // Tvoja lozinka za bazu (češće prazno na localhostu)
$db_name = "tvoja_baza_podataka"; // <--- OVDJE UPIŠI IME SVOJE BAZE

$conn = new mysqli($host, $user, $pass, $db_name);

// Provjera veze
if ($conn->connect_error) {
    die("Veza s bazom nije uspjela: " . $conn->connect_error);
}

// Setiranje UTF-8 znakova za naša slova (č, ć, š...)
$conn->set_charset("utf8");

// 2. Provjera jesu li podaci poslani iz forme
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Čišćenje unosa od zlonamjernog koda
    $ime = $conn->real_escape_string($_POST['firstname']);
    $prezime = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $drzava = $conn->real_escape_string($_POST['country']);
    $poruka = $conn->real_escape_string($_POST['subject']);

    // 3. SQL upit za unos u bazu
    $sql = "INSERT INTO poruke (ime, prezime, email, drzava, poruka) 
            VALUES ('$ime', '$prezime', '$email', '$drzava', '$poruka')";

    if ($conn->query($sql) === TRUE) {
        // Ako je uspješno, vrati korisnika natrag na kontakt formu i javi mu uspjeh
        echo "<script>
                alert('Poruka je uspješno poslana!');
                window.location.href = 'index.php?menu=3';
              </script>";
    } else {
        echo "Greška pri spremanju poruke: " . $conn->error;
    }
}

$conn->close();
?>