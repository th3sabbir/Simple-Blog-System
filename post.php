<?php
require_once 'config/db.php';

// Get post by slug
$slug = isset($_GET['slug']) ? clean_input($_GET['slug']) : '';

if (empty($slug)) {
    header('Location: index.php');
    exit;
}

// Fetch post
$query = "SELECT p.*, u.username, u.full_name, u.bio 
          FROM posts p 
          JOIN users u ON p.user_id = u.id 
          WHERE p.slug = ? AND p.status = 'published'";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $slug);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$stmt->close();

if (!$post) {
    header('Location: index.php');
    exit;
}

// Update view count
$update_views = "UPDATE posts SET views = views + 1 WHERE id = ?";
$stmt = $conn->prepare($update_views);
$stmt->bind_param('i', $post['id']);
$stmt->execute();
$stmt->close();

// Fetch comments
$comments_query = "SELECT c.*, u.username, u.full_name 
                   FROM comments c 
                   JOIN users u ON c.user_id = u.id 
                   WHERE c.post_id = ? AND c.status = 'approved' 
                   ORDER BY c.created_at DESC";
$stmt = $conn->prepare($comments_query);
$stmt->bind_param('i', $post['id']);
$stmt->execute();
$comments_result = $stmt->get_result();
$comments = [];
while ($row = $comments_result->fetch_assoc()) {
    $comments[] = $row;
}
$stmt->close();

// Handle comment submission
$comment_success = false;
$comment_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment']) && is_logged_in()) {
    $comment_content = clean_input($_POST['comment_content']);
    
    if (!empty($comment_content)) {
        $insert_comment = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_comment);
        $user_id = get_current_user_id();
        $stmt->bind_param('iis', $post['id'], $user_id, $comment_content);
        
        if ($stmt->execute()) {
            $comment_success = true;
            header("Location: post.php?slug=" . urlencode($slug) . "&comment=success");
            exit;
        } else {
            $comment_error = "Failed to post comment. Please try again.";
        }
        $stmt->close();
    } else {
        $comment_error = "Comment cannot be empty.";
    }
}

$page_title = htmlspecialchars($post['title']) . " - Blogify";
$active_page = 'home';
?>

<?php include 'header.php'; ?>

    <!-- Post Content -->
    <article class="post-detail">
        <div class="container-narrow">
            <!-- Post Header -->
            <header class="post-header">
                <a href="index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
                <h1 class="post-detail-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                <div class="post-meta-detail">
                    <div class="author-info">
                        <i class="fas fa-user-circle fa-2x"></i>
                        <div>
                            <strong><?php echo htmlspecialchars($post['full_name']); ?></strong>
                            <span>@<?php echo htmlspecialchars($post['username']); ?></span>
                        </div>
                    </div>
                    <div class="post-stats-detail">
                        <span class="date">
                            <i class="fas fa-calendar"></i>
                            <?php echo date('F d, Y', strtotime($post['created_at'])); ?>
                        </span>
                        <span class="views">
                            <i class="fas fa-eye"></i>
                            <?php echo number_format($post['views']); ?> views
                        </span>
                        <span class="comments">
                            <i class="fas fa-comment"></i>
                            <?php echo count($comments); ?> comments
                        </span>
                    </div>
                </div>
            </header>

            <!-- Post Body -->
            <div class="post-content">
                <?php echo display_content($post['content']); ?>
            </div>

            <!-- Author Bio -->
            <?php if (!empty($post['bio'])): ?>
            <div class="author-bio">
                <h3>About the Author</h3>
                <div class="author-bio-content">
                    <i class="fas fa-user-circle fa-3x"></i>
                    <div>
                        <h4><?php echo htmlspecialchars($post['full_name']); ?></h4>
                        <p><?php echo htmlspecialchars($post['bio']); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Comments Section -->
            <section class="comments-section">
                <h2>Comments (<?php echo count($comments); ?>)</h2>

                <!-- Comment Form -->
                <?php if (is_logged_in()): ?>
                    <?php if (isset($_GET['comment']) && $_GET['comment'] === 'success'): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            Your comment has been posted successfully!
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($comment_error)): ?>
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo $comment_error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="comment-form">
                        <div class="form-group">
                            <label for="comment_content">Leave a comment</label>
                            <textarea name="comment_content" id="comment_content" rows="4" placeholder="Share your thoughts..." required></textarea>
                        </div>
                        <button type="submit" name="submit_comment" class="btn-primary">
                            <i class="fas fa-paper-plane"></i> Post Comment
                        </button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        Please <a href="login.php">login</a> to leave a comment.
                    </div>
                <?php endif; ?>

                <!-- Comments List -->
                <div class="comments-list">
                    <?php if (count($comments) > 0): ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="comment-item">
                                <div class="comment-header">
                                    <i class="fas fa-user-circle fa-2x"></i>
                                    <div class="comment-author">
                                        <strong><?php echo htmlspecialchars($comment['full_name']); ?></strong>
                                        <span class="comment-date">
                                            <i class="fas fa-clock"></i>
                                            <?php echo date('M d, Y \a\t h:i A', strtotime($comment['created_at'])); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="comment-content">
                                    <?php echo display_content($comment['content']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state-small">
                            <i class="fas fa-comments"></i>
                            <p>No comments yet. Be the first to comment!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </article>

    <?php include 'footer.php'; ?>
