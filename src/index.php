<?php

$arquivos = scandir(__DIR__);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exercícios PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Exercícios PHP</h1>

    <ul>
        <?php foreach ($arquivos as $arquivo): ?>
            <?php if (strpos($arquivo, 'exercicio-') !== false): ?>
                <li>
                    <a href="<?= $arquivo ?>">
                        <?= $arquivo ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>