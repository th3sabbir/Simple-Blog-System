<?php
require_once 'config/db.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$user_id = get_current_user_id();
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch post and verify ownership
$query = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$stmt->close();

if (!$post) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean_input($_POST['title']);
    $content = clean_input($_POST['content']);
    $status = clean_input($_POST['status']);
    
    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } else {
        // Generate new slug if title changed
        $slug = $post['slug'];
        if ($title !== $post['title']) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
            
            // Check if new slug exists
            $check_slug = "SELECT id FROM posts WHERE slug = ? AND id != ?";
            $stmt = $conn->prepare($check_slug);
            $stmt->bind_param('si', $slug, $post_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $slug .= '-' . time();
            }
            $stmt->close();
        }
        
        // Update post
        $update_query = "UPDATE posts SET title = ?, slug = ?, content = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('ssssi', $title, $slug, $content, $status, $post_id);
        
        if ($stmt->execute()) {
            header('Location: dashboard.php?updated=success');
            exit;
        } else {
            $error = "Failed to update post. Please try again.";
        }
        $stmt->close();
    }
}

$page_title = "Edit Post - Blogify";
$active_page = 'dashboard';
?>

<?php include 'header.php'; ?>

    <section class="form-section">
        <div class="container-narrow">
            <div class="form-header">
                <a href="dashboard.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                <h1><i class="fas fa-edit"></i> Edit Post</h1>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="post-form">
                <div class="form-group">
                    <label for="title">Post Title *</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="content">Content *</label>
                    <textarea id="content" name="content" rows="15" required><?php echo htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="published" <?php echo $post['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                        <option value="draft" <?php echo $post['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Update Post
                    </button>
                    <a href="dashboard.php" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>

    <?php include 'footer.php'; ?>
