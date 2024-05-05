<?php

session_start();
$_SESSION['user_id'];

if(!isset($_SESSION['user_id'])) {
    header('Location: /get_login.php');
}
$userId = $_COOKIE['user_id'];

$pdo = new PDO("pgsql:host=db; port=5432; dbname=dbname", 'dbuser', 'dbpwd');
$stmt = $pdo->query("SELECT * FROM products");
//$stmt->execute(['id' => $userId]);
$result = $stmt->fetchAll();

//print_r($result);
//echo "city: {$user['city']}";
?>

<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach ($result as $product): ?>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                </div>
                <?php echo $product['name']; ?>
                </div>
                <img class="card-img-top" src="<?php echo $product['image']; ?> " alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $product['information']; ?></p>
                    <div class="card-footer">
                        <?php echo 'Цена ', $product['price'] , ' рублей'; ?>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    body {
        font-style: sans-serif;
    }

    a:hover {
        text-decoration: none;
        font-size: 13px;
    }

    h3 {
        line-height: 2em;
    }

    .card {
        font-size: 29px;
        max-width: 30rem;
        color: purple;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 13px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 19px;
        color: rebeccapurple;
    }

    .card-footer{
        font-weight: bold;
        font-size: 20px;
        color: black;
        line-height: 3em;
    }
</style>

