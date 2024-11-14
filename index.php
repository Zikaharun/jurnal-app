<?php
session_start(); // Mulai sesi

require_once 'app/data/Category.php';
require_once 'app/Services/Logic.php';

$listJurnal = new Logic();

// Cek apakah ada data jurnal di session
if (isset($_SESSION['journals'])) {
    
    // Muat jurnal dari session ke dalam $listJurnal
    foreach ($_SESSION['journals'] as $savedJournal) {
        $journal = new Category(
            $savedJournal['id'],
         $savedJournal['title'],
          $savedJournal['date'],
       $savedJournal['content'],
  $savedJournal['category']
        );
        $listJurnal->addJurnal($journal);
    }
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $content = $_POST['content'];
    $category = $_POST['category'];

    if (!empty($id) && !empty($title) && !empty($date) && !empty($content) && !empty($category)) {
        // Cek apakah jurnal dengan ID yang sama sudah ada
        $isJournalExist = false;
        foreach ($_SESSION['journals'] as $savedJournal) {
            if ($savedJournal['id'] == $id) {
                $isJournalExist = true;
                break;
            }
        }

        if ($isJournalExist) {
            echo "<script>alert('Journal with this ID already exists!')</script>";
        } else {
            // Tambahkan jurnal jika belum ada
            $journal = new Category($id, $title, $date, $content, $category);
            $listJurnal->addJurnal($journal);

            // Simpan data jurnal ke session
            $_SESSION['journals'][] = [
                'id' => $id,
                'title' => $title,
                'date' => $date,
                'content' => $content,
                'category' => $category
            ];

            echo "<script>Journal successfully added!</script>";
        }
    } else {
        echo "<script>Fields cannot be blank!</script>";
    }
}

$journals = $listJurnal->getJurnalList();

if(isset($_GET['id'])) {
    $idDelete = $_GET['id'];


    $isDeleted = false;

    foreach($_SESSION['journals'] as $key => $savedJournal) {

        if($savedJournal['id'] == $idDelete) {
            unset($_SESSION['journals'][$key]);
            $_SESSION['journals'] = array_values($_SESSION['journals']);
            $isDeleted = true;
            break;
        }

        if ($isDeleted) {
            $listJurnal->deleteJurnal($idDelete);
            echo "<script>alert('success deleted!')</script>";
            header("Location: index.php");
        } else {
            header("Location: index.php");
            echo "<script>alert('failed!')</script>";
     
        }
    }
}

$findById = null;

if(isset($_POST['find'])) {
    $findId = $_POST['findId'];
    $findById = $listJurnal->findbyid($findId);

} elseif(isset($_POST['btn-back'])) {
    $findById = null;
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>OOP-PHP</title>

</head>
<body>
    <form action="" method="post">
        <div class="container">
        <label for="findId" class="my-3">find by id: </label>
        <input type="number" name="findId" placeholder="find by id.." class="form-control mb-3">
        <button name="find" type="submit" class="btn btn-primary">find</button>
        </div>
    </form>
    <div class="container">
    <form action="" method="post">
        <div class="my-3">
        <input type="number" class="form-control" name="id" id="id">
        </div>
        
        <div class="mb-3">
        <label for="title" class="mb-3">Title: </label>
        <input type="text" class="form-control" name="title" id="title" placeholder="title">
        </div>
        <div class="mb-3">
        <label for="date" class="mb-3">Date: </label>
        <input type="date" name="date" id="date" class="form-control">
        </div>
        <div class="mb-3">
        <textarea name="content" id="content" placeholder="content" class="form-control"></textarea>
        </div>
        <div class="mb-3">
        <label for="category" class="mb-3">Category: </label>
        <input type="text" name="category" id="category" class="form-control">
        </div>
        
        <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>

    <div class="container">
    <h2 class="text-center">Daftar Jurnal:</h2>

    <?php if($findById) : ?>

        <h3 class="text-justify">Title: <?=htmlspecialchars($findById->getTitle()) ?></h3>
    <p class="text-justify">Date: <?=htmlspecialchars($findById->getDate())?></p>
    <p class="text-justify">Content: <?=htmlspecialchars($findById->getContent())?></p>
    <p class="text-justify">Category: <?=htmlspecialchars($findById->getNameCategory())?></p>
    <a href="index.php?id=<?= $findById->getId(); ?>" class="text-justify btn-outline-info">
        delete
    </a>
    <form action="" method="post">
    <button name="btn-back" class="btn btn-secondary mt-3">back</button>
    </form>

    <hr>

    <?php else : ?>


    
    <?php

foreach ($journals as $jurnal) :?>
    <h3 class="text-justify">Title: <?=htmlspecialchars($jurnal->getTitle()) ?></h3>
    <p class="text-justify">Date: <?=htmlspecialchars($jurnal->getDate())?></p>
    <p class="text-justify">Content: <?=htmlspecialchars($jurnal->getContent())?></p>
    <p class="text-justify">Category: <?=htmlspecialchars($jurnal->getNameCategory())?></p>
    <a href="index.php?id=<?= $jurnal->getId(); ?>" class="text-justify btn-outline-info">
        delete
    </a>
    <hr>

<?php endforeach; ?>
    </div>

<?php endif ?>
    
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
