<?php
    require "includes/header.php";
    require "config.php";

    // Check if user is logged in
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    // Get user details
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_SESSION['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Dashboard error: " . $e->getMessage());
    }

    // Check session timeout (30 minutes)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        session_unset();
        session_destroy();
        header("Location: login.php?msg=session_expired");
        exit();
    }
    $_SESSION['last_activity'] = time();
?>

<div class="container py-5">
    <div class="row">
        <!-- Welcome Section -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h4>
                            <p class="text-muted mb-0">Here's what's happening with your account</p>
                        </div>
                        <div>
                            <a href="logout.php" class="btn btn-outline-danger">Sign Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Account Status</h5>
                    <p class="card-text text-success mb-0">Active</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Last Login</h5>
                    <p class="card-text mb-0"><?php echo date('M j, Y H:i'); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Email Address</h5>
                    <p class="card-text mb-0"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                </div>
            </div>
        </div>

        <!-- Account Details -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Account Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted">Username</label>
                        <p class="mb-0"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Email</label>
                        <p class="mb-0"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    </div>
                    <div>
                        <label class="text-muted">Account Created</label>
                        <p class="mb-0"><?php echo isset($user['created_at']) ? date('F j, Y', strtotime($user['created_at'])) : 'N/A'; ?></p>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="#" class="btn btn-sm btn-primary">Edit Profile</a>
                    <a href="#" class="btn btn-sm btn-outline-secondary">Change Password</a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Update Profile
                            <span class="badge bg-primary rounded-pill">→</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Security Settings
                            <span class="badge bg-primary rounded-pill">→</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Notification Preferences
                            <span class="badge bg-primary rounded-pill">→</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Privacy Settings
                            <span class="badge bg-primary rounded-pill">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Section -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Activity logging will be implemented in the next update.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Custom Dashboard Styles -->
<style>
.card {
    border: none;
    border-radius: 10px;
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
.card-header {
    border-bottom: 1px solid rgba(0,0,0,.05);
}
.list-group-item {
    border: none;
    padding: 1rem 1.25rem;
    margin-bottom: 0.5rem;
    border-radius: 8px !important;
    background-color: #f8f9fa;
}
.list-group-item:hover {
    background-color: #e9ecef;
}
.badge {
    transition: transform 0.2s;
}
.list-group-item:hover .badge {
    transform: translateX(5px);
}
</style>

<?php require "includes/footer.php"; ?>