<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "warhex_db";
$conn = @new mysqli($host, $user, $pass, $db);

$products = [];
if (!$conn->connect_error) {
    $res = $conn->query("SELECT * FROM products ORDER BY id ASC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $products[] = $row;
        }
    }
}
?>
<section id="products" class="products-section">

    <div class="container-fluid px-5">
        <div class="d-flex align-items-center justify-content-between pb-4 news-header-row">
            <div class="d-flex align-items-center gap-4">
                <h2 class="news-section-title mb-0 d-flex align-items-center">
                    <span class="series-slash me-2">//</span> PRODUCTS
                </h2>
                <div class="series-desc border-start ps-4">
                    <p class="mb-0 small fw-semibold">Official WarHex gear, hardware, and battle-ready equipment.</p>
                </div>
            </div>
            <a href="#" class="view-all text-decoration-none fw-bold d-flex align-items-center gap-1">
                VIEW ALL PRODUCTS <i class="bi bi-chevron-double-right"></i>
            </a>
        </div>
    </div>

    <div class="products-bento">
        <!-- Static text block A -->
        <div class="prod-cell prod-cell--a prod-cell--text">
            <div>
                <p class="prod-kicker"><span class="about-slash me-1">//</span> FEATURED</p>
                <h3 class="prod-big-title">HEX<br>COMBAT<br>GEAR.</h3>
                <p class="prod-big-desc">Engineered for warriors. Every piece of WarHex merchandise is designed with the same precision we put into our games.</p>
            </div>
        </div>

        <!-- Dynamic Products Loop -->
        <?php foreach($products as $index => $prod): ?>
            
            <?php 
                // Insert the full image banner after the first product to match original design
                if($index === 1): 
            ?>
            <div class="prod-cell prod-cell--c prod-cell--imgfull">
                <img src="assets/WarHex2.png" alt="Featured Product" class="prod-img--cover">
            </div>
            <?php endif; ?>

            <div class="prod-cell <?= htmlspecialchars($prod['cell_class']) ?>">
                <?php if(strpos($prod['cell_class'], 'reverse') !== false): ?>
                    <div class="prod-info">
                        <h4 class="prod-title"><?= htmlspecialchars($prod['title']) ?></h4>
                        <p class="prod-desc"><?= htmlspecialchars($prod['description']) ?></p>
                        <a href="#" class="prod-link">SHOP NOW <i class="bi bi-arrow-up-right"></i></a>
                    </div>
                    <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['title']) ?>" class="prod-img--sm">
                <?php else: ?>
                    <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['title']) ?>" class="prod-img--sm" <?= strpos($prod['cell_class'], 'prod-cell--e') !== false ? 'style="width:130px;height:130px;"' : '' ?>>
                    <div class="prod-info">
                        <h4 class="prod-title"><?= htmlspecialchars($prod['title']) ?></h4>
                        <p class="prod-desc"><?= htmlspecialchars($prod['description']) ?></p>
                        <a href="#" class="prod-link">SHOP NOW <i class="bi bi-arrow-up-right"></i></a>
                    </div>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>

        <!-- Static text block G -->
        <div class="prod-cell prod-cell--g prod-cell--text prod-cell--drops">
            <div>
                <p class="prod-kicker"><span class="about-slash me-1">//</span> LIMITED DROPS</p>
                <h3 class="prod-big-title">DROPS<br>EVERY<br>SEASON.</h3>
                <p class="prod-big-desc">New collections launching alongside every game release. Join the waitlist to get early access.</p>
                <a href="#" class="btn hero-button d-inline-flex align-items-center justify-content-between mt-3" style="width:210px;font-size:.85rem;">
                    <span>JOIN WAITLIST</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

    </div>
</section>
