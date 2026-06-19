<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "tvoja_baza_podataka";

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Veza s bazom nije uspjela: " . $conn->connect_error);
}

$conn->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $ime = $conn->real_escape_string($_POST['firstname']);
    $prezime = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $drzava = $conn->real_escape_string($_POST['country']);
    $poruka = $conn->real_escape_string($_POST['subject']);

    $sql = "INSERT INTO poruke (ime, prezime, email, drzava, poruka) 
            VALUES ('$ime', '$prezime', '$email', '$drzava', '$poruka')";

    if ($conn->query($sql) === TRUE) {
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