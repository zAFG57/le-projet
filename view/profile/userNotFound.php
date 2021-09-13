<?php 
    include_once __DIR__ .'/../../templates/nav.php';

    $title = "My Profile"; $css = "profile.css";
    ob_start(); 
?>


    <header>
        <?= $nav ?>
    </header>

    <h1>User notFound</h1>


<?php $content = ob_get_clean(); ?>

<?php require __DIR__ . '/../../templates/baseTemplate.php'; ?>