<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "warhex_db";
$conn = @new mysqli($host, $user, $pass, $db);

$seriesList = [];
if (!$conn->connect_error) {
    $res = $conn->query("SELECT * FROM series ORDER BY id ASC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $seriesList[] = $row;
        }
    }
}
?>
<section id="series" class="series-section py-5">
    <div class="container-fluid px-5">
        <div class="d-flex align-items-center mb-4">
            <h2 class="series-title mb-0 me-4 d-flex align-items-center">
                <span class="series-slash me-2">//</span> SERIES
            </h2>
            <div class="series-desc border-start ps-4">
                <p class="mb-0 small fw-semibold">Introducing the WarHex game series produced so far.</p>
                <p class="mb-0 small fw-semibold">Experience each story, worldview, and battle.</p>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <ul class="nav nav-pills series-filters gap-3">
                <li class="nav-item"><a class="nav-link active js-series-filter" href="#" data-filter="ALL">ALL</a></li>
                <li class="nav-item"><a class="nav-link js-series-filter" href="#" data-filter="ACTION">ACTION</a></li>
                <li class="nav-item"><a class="nav-link js-series-filter" href="#" data-filter="RPG">RPG</a></li>
                <li class="nav-item"><a class="nav-link js-series-filter" href="#" data-filter="ADVENTURE">ADVENTURE</a></li>
                <li class="nav-item"><a class="nav-link js-series-filter" href="#" data-filter="STRATEGY">STRATEGY</a></li>
                <li class="nav-item"><a class="nav-link js-series-filter" href="#" data-filter="SURVIVAL">SURVIVAL</a></li>
            </ul>
            <div class="series-search-wrap">
                <div class="series-search-field">
                    <i class="bi bi-search"></i>
                    <input class="series-search-input" type="search" placeholder="Search series" aria-label="Search series">
                </div>
            </div>
        </div>
       
        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-4 mb-5">
            <?php foreach($seriesList as $index => $item): ?>
            <div class="col">
                <div class="card series-card h-100" data-category="<?= htmlspecialchars($item['category']) ?>">
                    <div class="position-relative">
                        <span class="series-num position-absolute z-2 unskew" style="top:10px;left:10px;">
                            <?= sprintf('%02d', $index + 1) ?>
                        </span>
                        <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>" style="height:185px;object-fit:cover;">
                    </div>
                    <div class="card-body d-flex flex-column p-0 unskew">
                        <div class="px-3 pt-3 pb-2">
                            <h5 class="series-title-text mb-0"><?= htmlspecialchars($item['title']) ?></h5>
                        </div>
                        <div class="d-flex align-items-center mt-auto border-top px-3 py-2">
                            <span class="series-genre pe-3"><?= htmlspecialchars($item['genre']) ?></span>
                            <span class="series-year border-start ps-3"><?= htmlspecialchars($item['release_year']) ?></span>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0 p-3 unskew">
                        <a href="#" class="series-card-link" aria-label="Open series details">
                            <i class="bi bi-arrow-up-right fw-bold fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
