<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Посты</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/navbar-fixed/">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href=".">Посты</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
        </div>
    </div>
</nav>

<main class="container">
    <div class="rounded mt-5">
        <h1 class="">Посты</h1>
        <?php $i = 1; ?>
        <?php foreach ($chunk as $key => $post) { ?>
            <div class="card mb-5">
                <div class="card-header">
                    <?=$post->pubDate?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?=$post->title?></h5>
                    <p class="card-text">Автор: <?=$post->author?></p>
                    <p class="card-text"><a href="<?=$post->link?>"><?=$post->link?></a></p>
                    <button class="btn btn-primary mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?=$i?>" aria-expanded="false" aria-controls="collapseExample<?=$i?>">
                        Читать
                    </button>
                    <div class="card-text collapse" id="collapseExample<?=$i?>"><?=$post->description?></div>
                </div>
            </div>
            <?php $i++; ?>
        <?php } ?>

        <ul class="pagination"><?=$pagenav?></ul>
    </div>
</main>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
