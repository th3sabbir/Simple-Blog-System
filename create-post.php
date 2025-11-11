<?php
require_once 'config/db.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

$error = '';
$user_id = get_current_user_id();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean_input($_POST['title']);
    $content = clean_input($_POST['content']);
    $status = clean_input($_POST['status']);
    
    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } else {
        // Generate slug from title
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        
        // Check if slug exists and make it unique
        $check_slug = "SELECT id FROM posts WHERE slug = ?";
        $stmt = $conn->prepare($check_slug);
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $slug .= '-' . time();
        }
        $stmt->close();
        
        // Insert post
        $insert_query = "INSERT INTO posts (user_id, title, slug, content, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param('issss', $user_id, $title, $slug, $content, $status);
        
        if ($stmt->execute()) {
            header('Location: dashboard.php?created=success');
            exit;
        } else {
            $error = "Failed to create post. Please try again.";
        }
        $stmt->close();
    }
}

$page_title = "Create Post - Blogify";
$active_page = 'dashboard';
?>

<?php include 'header.php'; ?>

    <section class="form-section">
        <div class="container-narrow">
            <div class="form-header">
                <a href="dashboard.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                <h1><i class="fas fa-plus"></i> Create New Post</h1>
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
                    <input type="text" id="title" name="title" placeholder="Enter an engaging title" required>
                </div>

                <div class="form-group">
                    <label for="content">Content *</label>
                    <textarea id="content" name="content" rows="15" placeholder="Write your post content here..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Create Post
                    </button>
                    <a href="dashboard.php" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>

    <?php include 'footer.php'; ?>
