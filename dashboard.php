<?php
require_once 'config/db.php';

// Check if user is logged in
if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$user_id = get_current_user_id();

// Fetch user's posts
$query = "SELECT p.*, 
          (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comment_count
          FROM posts p 
          WHERE p.user_id = ? 
          ORDER BY p.created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}
$stmt->close();

// Handle post deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $post_id = (int)$_GET['id'];
    
    // Verify ownership
    $check_query = "SELECT id FROM posts WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param('ii', $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $delete_query = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        $stmt->close();
        
        header('Location: dashboard.php?deleted=success');
        exit;
    }
    $stmt->close();
}

$page_title = "Dashboard - Blogify";
$active_page = 'dashboard';
?>

<?php include 'header.php'; ?>

    <!-- Dashboard Content -->
    <section class="dashboard-section">
        <div class="container">
            <div class="dashboard-header">
                <h1><i class="fas fa-tachometer-alt"></i> My Dashboard</h1>
                <a href="create-post.php" class="btn-primary">
                    <i class="fas fa-plus"></i> Create New Post
                </a>
            </div>

            <?php if (isset($_GET['deleted']) && $_GET['deleted'] === 'success'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Post deleted successfully!
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['created']) && $_GET['created'] === 'success'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Post created successfully!
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['updated']) && $_GET['updated'] === 'success'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Post updated successfully!
                </div>
            <?php endif; ?>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo count($posts); ?></h3>
                        <p>Total Posts</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo number_format(array_sum(array_column($posts, 'views'))); ?></h3>
                        <p>Total Views</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo array_sum(array_column($posts, 'comment_count')); ?></h3>
                        <p>Total Comments</p>
                    </div>
                </div>
            </div>

            <!-- Posts Table -->
            <div class="dashboard-card">
                <h2><i class="fas fa-list"></i> My Posts</h2>
                <?php if (count($posts) > 0): ?>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Views</th>
                                    <th>Comments</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post): ?>
                                    <tr>
                                        <td>
                                            <a href="post.php?slug=<?php echo urlencode($post['slug']); ?>" class="post-title-link">
                                                <?php echo htmlspecialchars($post['title']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo $post['status']; ?>">
                                                <?php echo ucfirst($post['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo number_format($post['views']); ?></td>
                                        <td><?php echo $post['comment_count']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($post['created_at'])); ?></td>
                                        <td class="actions">
                                            <a href="edit-post.php?id=<?php echo $post['id']; ?>" class="btn-action btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="dashboard.php?action=delete&id=<?php echo $post['id']; ?>" 
                                               class="btn-action btn-delete" 
                                               title="Delete"
                                               onclick="return confirm('Are you sure you want to delete this post?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>You haven't created any posts yet.</p>
                        <a href="create-post.php" class="btn-primary">
                            <i class="fas fa-plus"></i> Create Your First Post
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
