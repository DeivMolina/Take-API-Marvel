<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel Characters</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Marvel Characters</h1>
    <div class="row">
        <?php if (isset($characters) && !empty($characters)): ?>
            <?php foreach ($characters as $character): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="<?= $character['thumbnail'] ?>" class="card-img-top" alt="<?= $character['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $character['name'] ?></h5>
                            <p class="card-text"><?= $character['description'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No characters found.</p>
        <?php endif; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
