<?php
require_once 'config/db.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$posts_per_page = 9;
$offset = ($page - 1) * $posts_per_page;

// Get total posts count for pagination
$total_posts_query = "SELECT COUNT(*) as count FROM posts WHERE status = 'published'";
$total_result = $conn->query($total_posts_query);
$total_posts = $total_result->fetch_assoc()['count'];
$total_pages = ceil($total_posts / $posts_per_page);

// Fetch latest posts with pagination
$query = "SELECT p.*, u.username, u.full_name,
          (SELECT COUNT(*) FROM comments WHERE post_id = p.id AND status = 'approved') as comment_count
          FROM posts p
          JOIN users u ON p.user_id = u.id
          WHERE p.status = 'published'
          ORDER BY p.created_at DESC
          LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $posts_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();
$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}
$stmt->close();

// Get featured post (most viewed)
$featured_query = "SELECT p.*, u.username, u.full_name
                   FROM posts p
                   JOIN users u ON p.user_id = u.id
                   WHERE p.status = 'published'
                   ORDER BY p.views DESC
                   LIMIT 1";
$featured_result = $conn->query($featured_query);
$featured_post = $featured_result ? $featured_result->fetch_assoc() : null;
?>

<?php include 'header.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Discover Stories That Matter</h1>
                <p class="hero-subtitle">Join our community of writers and readers sharing ideas, insights, and inspiration</p>
                <?php if (!is_logged_in()): ?>
                    <a href="register.php" class="btn-hero">Start Writing Today</a>
                <?php else: ?>
                    <a href="dashboard.php" class="btn-hero">Go to Dashboard</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="hero-overlay"></div>
    </section>

    <!-- Featured Post -->
    <?php if ($featured_post): ?>
    <section class="featured-section">
        <div class="container">
            <h2 class="section-title">Featured Post</h2>
            <div class="featured-post">
                <div class="featured-post-content">
                    <span class="featured-badge">
                        <i class="fas fa-star"></i> Featured
                    </span>
                    <h3 class="featured-title">
                        <a href="post.php?slug=<?php echo urlencode($featured_post['slug']); ?>">
                            <?php echo htmlspecialchars($featured_post['title']); ?>
                        </a>
                    </h3>
                    <p class="featured-excerpt">
                        <?php echo display_excerpt($featured_post['content'], 200); ?>
                    </p>
                    <div class="post-meta">
                        <span class="author">
                            <i class="fas fa-user"></i>
                            <?php echo htmlspecialchars($featured_post['full_name']); ?>
                        </span>
                        <span class="date">
                            <i class="fas fa-calendar"></i>
                            <?php echo date('M d, Y', strtotime($featured_post['created_at'])); ?>
                        </span>
                        <span class="views">
                            <i class="fas fa-eye"></i>
                            <?php echo number_format($featured_post['views']); ?> views
                        </span>
                    </div>
                    <a href="post.php?slug=<?php echo urlencode($featured_post['slug']); ?>" class="btn-read-more">
                        Read More <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Blog Posts List -->
    <section class="posts-section">
        <div class="container">
            <h2 class="section-title">Latest Posts</h2>
            <?php if (count($posts) > 0): ?>
                <div class="posts-list-container">
                    <?php foreach ($posts as $post): ?>
                        <article class="post-item">
                            <div class="post-item-content">
                                <h3 class="post-item-title">
                                    <a href="post.php?slug=<?php echo urlencode($post['slug']); ?>">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h3>
                                <p class="post-item-excerpt">
                                    <?php echo display_excerpt($post['content'], 180); ?>
                                </p>
                                <div class="post-item-meta">
                                    <span class="meta-item author">
                                        <i class="fas fa-user-circle"></i>
                                        <?php echo htmlspecialchars($post['full_name']); ?>
                                    </span>
                                    <span class="meta-item date">
                                        <i class="fas fa-calendar-alt"></i>
                                        <?php echo date('M d, Y', strtotime($post['created_at'])); ?>
                                    </span>
                                    <span class="meta-item comments">
                                        <i class="fas fa-comments"></i>
                                        <?php echo $post['comment_count']; ?> Comments
                                    </span>
                                    <span class="meta-item views">
                                        <i class="fas fa-eye"></i>
                                        <?php echo number_format($post['views']); ?> Views
                                    </span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php
                    // Previous button
                    if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="pagination-btn pagination-prev">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    <?php endif; ?>

                    <div class="pagination-numbers">
                        <?php
                        // Show page numbers
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);

                        // Show first page if not in range
                        if ($start_page > 1): ?>
                            <a href="?page=1" class="pagination-btn">1</a>
                            <?php if ($start_page > 2): ?>
                                <span class="pagination-dots">...</span>
                            <?php endif; ?>
                        <?php endif;

                        // Show page numbers
                        for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="pagination-btn <?php echo $i === $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor;

                        // Show last page if not in range
                        if ($end_page < $total_pages): ?>
                            <?php if ($end_page < $total_pages - 1): ?>
                                <span class="pagination-dots">...</span>
                            <?php endif; ?>
                            <a href="?page=<?php echo $total_pages; ?>" class="pagination-btn"><?php echo $total_pages; ?></a>
                        <?php endif; ?>
                    </div>

                    <?php
                    // Next button
                    if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="pagination-btn pagination-next">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>No posts available yet. Be the first to write one!</p>
                    <?php if (is_logged_in()): ?>
                        <a href="dashboard.php" class="btn-primary">Create Post</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>
