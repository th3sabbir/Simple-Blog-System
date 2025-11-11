<?php
require_once '../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: login.php');
    exit;
}

// Get statistics
$total_users_query = "SELECT COUNT(*) as count FROM users";
$total_users = $conn->query($total_users_query)->fetch_assoc()['count'];

$total_posts_query = "SELECT COUNT(*) as count FROM posts";
$total_posts = $conn->query($total_posts_query)->fetch_assoc()['count'];

$total_comments_query = "SELECT COUNT(*) as count FROM comments";
$total_comments = $conn->query($total_comments_query)->fetch_assoc()['count'];

$total_views_query = "SELECT SUM(views) as total FROM posts";
$total_views = $conn->query($total_views_query)->fetch_assoc()['total'] ?? 0;

// Fetch all users
$users_query = "SELECT u.*, 
                (SELECT COUNT(*) FROM posts WHERE user_id = u.id) as post_count,
                (SELECT COUNT(*) FROM comments WHERE user_id = u.id) as comment_count
                FROM users u 
                ORDER BY u.created_at DESC";
$users_result = $conn->query($users_query);
$users = [];
while ($row = $users_result->fetch_assoc()) {
    $users[] = $row;
}

// Fetch all posts
$posts_query = "SELECT p.*, u.username, u.full_name,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comment_count
                FROM posts p
                JOIN users u ON p.user_id = u.id
                ORDER BY p.created_at DESC";
$posts_result = $conn->query($posts_query);
$posts = [];
while ($row = $posts_result->fetch_assoc()) {
    $posts[] = $row;
}

// Handle post deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete_post' && isset($_GET['id'])) {
    $post_id = (int)$_GET['id'];
    $delete_query = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $stmt->close();
    header('Location: dashboard.php?deleted=success');
    exit;
}

// Handle user deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete_user' && isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->close();
    header('Location: dashboard.php?user_deleted=success');
    exit;
}

$page_title = "Admin Dashboard - Blogify";
$active_page = 'admin_dashboard';
?>

<?php include 'header.php'; ?>

    <section class="dashboard-section">
        <div class="container">
            <div class="dashboard-header">
                <h1><i class="fas fa-shield-alt"></i> Admin Dashboard</h1>
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

            <?php if (isset($_GET['user_deleted']) && $_GET['user_deleted'] === 'success'): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    User deleted successfully!
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

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $total_users; ?></h3>
                        <p>Total Users</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $total_posts; ?></h3>
                        <p>Total Posts</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $total_comments; ?></h3>
                        <p>Total Comments</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo number_format($total_views); ?></h3>
                        <p>Total Views</p>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="dashboard-card">
                <h2><i class="fas fa-users"></i> All Users</h2>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Posts</th>
                                <th>Comments</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo $user['post_count']; ?></td>
                                    <td><?php echo $user['comment_count']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                    <td class="actions">
                                        <a href="dashboard.php?action=delete_user&id=<?php echo $user['id']; ?>" 
                                           class="btn-action btn-delete" 
                                           title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this user? This will also delete all their posts and comments.');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Posts Table -->
            <div class="dashboard-card">
                <h2><i class="fas fa-list"></i> All Posts</h2>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Author</th>
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
                                    <td><?php echo $post['id']; ?></td>
                                    <td>
                                        <a href="../post.php?slug=<?php echo urlencode($post['slug']); ?>" class="post-title-link">
                                            <?php echo htmlspecialchars($post['title']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($post['full_name']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $post['status']; ?>">
                                            <?php echo ucfirst($post['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo number_format($post['views']); ?></td>
                                    <td><?php echo $post['comment_count']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($post['created_at'])); ?></td>
                                    <td class="actions">
                                        <a href="../post.php?slug=<?php echo urlencode($post['slug']); ?>" 
                                           class="btn-action btn-view" 
                                           title="View" 
                                           target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="edit-post.php?id=<?php echo $post['id']; ?>" 
                                           class="btn-action btn-edit" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="dashboard.php?action=delete_post&id=<?php echo $post['id']; ?>" 
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
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
