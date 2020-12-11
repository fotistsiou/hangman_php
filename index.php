<?php
    session_start();
    $letters = ["Α","Β","Γ","Δ","Ε","Ζ","Η","Θ","Ι","Κ","Λ","Μ","Ν","Ξ","Ο","Π","Ρ","Σ","Τ","Υ","Φ","Χ","Ψ","Ω"];
    if (!isset($_GET['letter'])) {
        $_SESSION['letters'] = [];
        $words = ["ΑΝΑΖΗΤΗΣΗ","ΕΒΔΟΜΑΔΑ","ΔΙΧΤΥ","ΠΕΦΤΩ","ΕΙΡΗΝΙΚΟΣ","ΣΚΕΠΗ","ΚΙΝΗΣΗ","ΠΙΑ","ΑΙΤΙΑ","ΕΙΡΩΝΙΚΟΣ","ΒΕΡΑΝΤΑ","ΛΕΙΤΟΥΡΓΙΑ","ΒΑΡΟΝΟΣ","ΚΟΣΜΟΣ","ΘΗΚΗ","ΠΑΓΟΥΡΙ","ΣΤΡΑΤΟΠΕΔΟ","ΠΕΡΙΕΧΩ","ΚΟΥΒΕΝΤΑ","ΖΥΓΑΡΙΑ","ΟΥΛΗ","ΠΩΛΗΣΗ","ΓΚΑΡΑΖ","ΣΥΝΤΑΞΗ","ΜΙΖΕΡΙΑ","ΠΑΝΩΛΕΘΡΙΑ","ΚΤΗΜΑ","ΚΝΗΜΗ","ΣΑΜΠΟΥΑΝ","ΠΑΡΑΓΓΕΛΙΑ","ΛΑΜΒΑΝΩ","ΜΑΓΕΙΡΑΣ","ΥΨΩΝΩ","ΤΟΠΙΟ","ΑΣΤΑΚΟΣ","ΑΠΑΓΟΡΕΥΣΗ","ΑΣΤΙΚΟΣ","ΝΥΦΗ","ΠΡΙΟΝΙΖΩ","ΣΥΜΜΑΧΙΚΟΣ","ΠΟΥΛΜΑΝ","ΕΚΤΙΜΗΣΗ","ΘΕΜΕΛΙΟ","ΚΡΟΚΟΣ","ΕΠΑΓΓΕΛΜΑ","ΔΙΑΣΚΕΔΑΖΩ","ΣΥΝΑΛΛΑΓΜΑ","ΒΟΣΚΟΣ","ΤΡΩΓΛΗ","ΜΑΡΚΑ","ΑΓΡΙΟΣ","ΓΛΟΜΠΟΣ","ΤΑΥΤΙΖΩ","ΝΟΙΚΙ","ΖΑΡΑ","ΜΟΡΦΗ","ΓΙΑΛΟΣ","ΟΙΚΙΣΜΟΣ","ΟΛΟΚΛΗΡΟΣ","ΕΠΙΣΚΕΨΗ","ΠΕΤΡΕΛΑΙΟ","ΦΕΓΓΑΡΙ","ΑΠΕΙΚΟΝΙΣΗ","ΚΑΝΕΝΑΣ","ΑΕΤΟΣ","ΣΕΛΑ","ΙΔΑΝΙΚΟΣ","ΠΑΡΑΠΗΓΜΑ","ΞΕΝΑΓΟΣ","ΑΡΙΣΤΕΡΟΣ","ΣΥΜΒΟΛΑΙΟ","ΣΑΚΑΚΙ"];
        $randIndex = array_rand($words);
        $_SESSION['word'] = $words[$randIndex];
        $_SESSION['tries'] = 6;
    } else {
        array_push($_SESSION['letters'], $_GET['letter']);
    }
    
    $word = '';
    $found = true;
    $wordarray = preg_split('//u', $_SESSION['word'], 0, PREG_SPLIT_NO_EMPTY);
    
    foreach ($wordarray as $letter){
        if (in_array($letter, $_SESSION['letters'])) {
            $word .= $letter;
        } else {
            $word .= '_ ';
            $found = false;
        }
    }

    if (isset($_GET['letter']) && !in_array($_GET['letter'], $wordarray)){
        $_SESSION['tries']--;
    }
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Κρεμάλα</title>
</head>
<body class="bg-light">
    <div class="container p-3 mt-4 bg-dark text-white border border-secondary text-center">

        <h1>Κρεμάλα</h1>

        <?php if (!isset($_GET['letter'])): ?>
            <h3>Πάτα το γράμμα που σου δίνεται και ξεκίνα το παιχνίδι!</h3>
        <?php else: ?>
            <h3>Το παιχνίδι ξεκίνησε!</h3>
        <?php endif ?>

        <h2>
            <?php 
               if (!isset($_GET['letter'])) {
                    echo $wordarray[0];
                    for ($i=1; $i<count($wordarray); $i++) {
                        echo "_ ";
                    }
               } else {
                    echo $word;
               };
            ?>
        </h2>

        <h3>
            <?php foreach($letters as $index => $letter): ?>
                <?php if($index % 6 == 0) echo '<br/>' ?>
                <?php if (in_array($letter, $_SESSION['letters'])): ?>
                    <button class="btn btn-danger m-2"><?= $letter ?></button>
                <?php else: ?>
                    <?php if($_SESSION['tries'] > 0): ?>
                        <a href="<?= $_SERVER['PHP_SELF'] ?>?letter=<?= $letter ?>">
                    <?php endif ?>
                        <button class="btn btn-info m-2"><?= $letter ?></button>
                        </a>
                <?php endif ?>
            <?php endforeach ?>
        </h3>

        <h3>
            <?php if ($found): ?>
                <p>Μπράβο κέρδισες!</p>
            <?php elseif($_SESSION['tries'] == 0): ?>
                <p>Δυστυχώς έχασες, δοκίμασε ξανά.</p>
            <?php else: ?>
                <p>Έχεις <?= $_SESSION['tries'] ?> από τις 6 προσπάθειες.</p>
            <?php endif ?>
        </h3>

        <div>
            <a href="<?= $_SERVER['PHP_SELF'] ?>"><button class="btn btn-primary">Νέο παιχνίδι</button></a>
        </div>

    </div>
</body>
</html>