<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "warhex_db";
$conn = @new mysqli($host, $user, $pass, $db);

$newsList = [];
if (!$conn->connect_error) {
    $res = $conn->query("SELECT * FROM news ORDER BY id ASC");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $newsList[] = $row;
        }
    }
}
?>
<section id="news" class="news-section">
    <div class="container-fluid px-5">
        <div class="d-flex align-items-center justify-content-between mb-0 pb-4 news-header-row">
            <div class="d-flex align-items-center gap-4">
                <h2 class="news-section-title mb-0 d-flex align-items-center">
                    <span class="series-slash me-2">//</span> NEWS
                </h2>
                <div class="series-desc border-start ps-4">
                    <p class="mb-0 small fw-semibold">Latest updates, announcements, and battle reports.</p>
                </div>
            </div>
            <a href="#" class="view-all text-decoration-none fw-bold d-flex align-items-center gap-1">
                VIEW ALL NEWS <i class="bi bi-chevron-double-right"></i>
            </a>
        </div>

        <div class="news-grid">
            <?php
            // Group news into chunks of 2 for rows
            $chunks = array_chunk($newsList, 2);
            foreach ($chunks as $index => $chunk):
                if ($index > 0) {
                    echo '<div class="news-row-divider"></div>';
                }
            ?>
            <div class="news-row">
                <?php foreach ($chunk as $i => $item): ?>
                    <?php if ($i > 0) { echo '<div class="news-col-divider"></div>'; } ?>
                    <div class="news-item">
                        <a href="#" class="news-thumb-link">
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="news-thumb">
                        </a>
                        <div class="news-body">
                            <a href="#" class="news-title-link">
                                <?= htmlspecialchars($item['title']) ?>
                            </a>
                            <div class="news-meta">
                                <div class="news-tags">
                                    <?php 
                                    $tags = explode(',', $item['tags']);
                                    foreach ($tags as $tag):
                                        $tag = trim($tag);
                                        if($tag):
                                    ?>
                                        <a href="#" class="news-tag"><?= htmlspecialchars($tag) ?></a>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </div>
                                <span class="news-date"><?= htmlspecialchars($item['date']) ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
