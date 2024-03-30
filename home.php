<?php
// Get the 3 most latest added products
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_created DESC LIMIT 3');
$stmt->execute();
$latest_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pdo = NULL;
?>

<?=template_header('Home')?>

<div class="featured">
    <h2>Gadgets</h2>
    <p>Essential belongings for you</p>
</div>
<div class="recentlyadded content-wrapper">
    <h2>Latest Products</h2>
    <p>Click above <strong>"Collections"</strong> Button to view our all products.</p>

    <div class="products">
        <?php foreach ($latest_products as $product): ?>
        <a href="index.php?page=product&id=<?=$product['product_id']?>" class="product">
            <img src="imgs/<?=$product['image_name']?>" width="300" height="300" alt="<?=$product['product_name']?>">
            <span class="name"><?=$product['product_name']?></span>
            <span class="price">
                &dollar;<?=$product['price']?>
                <?php if ($product['rrp'] > 0): ?>
                <span class="rrp">&dollar;<?=$product['rrp']?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?=template_footer()?>