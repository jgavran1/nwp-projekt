<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = htmlspecialchars($_POST['firstname']);
    $prezime = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $drzava = htmlspecialchars($_POST['country']);
    $poruka = htmlspecialchars($_POST['subject']);
    $datum = date("d.m.Y. H:i");
    $id = uniqid();

    // Zapisuje u tekstualnu datoteku
    $jedna_linija = $id . "|" . $datum . "|" . $ime . "|" . $prezime . "|" . $email . "|" . $drzava . "|" . str_replace("\n", " ", $poruka) . "\n";
    file_put_contents("poruke.txt", $jedna_linija, FILE_APPEND);

    // Iskače obavijest i vraća te nazad na kontakt formu (menu=3)
    // Iskače obavijest i vraća te nazad na kontakt formu
    echo "<script>
            alert('Poruka uspješno poslana!');
            window.location.href = 'index.php?menu=6';
          </script>";
}
?>