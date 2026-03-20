<?php

// Test web server file upload
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>Web Server Upload Test</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>Upload Attempt Results:</h3>";
    
    echo "<p><strong>POST data:</strong></p><pre>";
    print_r($_POST);
    echo "</pre>";
    
    echo "<p><strong>FILES data:</strong></p><pre>";
    print_r($_FILES);
    echo "</pre>";
    
    if (isset($_FILES['test_file'])) {
        $file = $_FILES['test_file'];
        echo "<p>Upload status: " . $file['error'] . "</p>";
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            echo "<p style='color: green;'>✓ Upload successful!</p>";
            echo "<p>Original name: " . htmlspecialchars($file['name']) . "</p>";
            echo "<p>Size: " . $file['size'] . " bytes</p>";
            echo "<p>Type: " . htmlspecialchars($file['type']) . "</p>";
            echo "<p>Temp location: " . htmlspecialchars($file['tmp_name']) . "</p>";
            
            // Test moving to storage
            $targetDir = '../storage/app/public/products/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            
            $targetPath = $targetDir . 'web_test_' . time() . '_' . basename($file['name']);
            
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                echo "<p style='color: green;'>✓ File moved to storage successfully!</p>";
                echo "<p>Target path: " . htmlspecialchars($targetPath) . "</p>";
            } else {
                echo "<p style='color: red;'>✗ Failed to move file to storage</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ Upload failed</p>";
            
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    echo "<p>File exceeds upload_max_filesize</p>";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo "<p>File exceeds MAX_FILE_SIZE</p>";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "<p>File was only partially uploaded</p>";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "<p>No file was uploaded</p>";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "<p>Missing temporary folder</p>";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "<p>Failed to write file to disk</p>";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "<p>File upload stopped by extension</p>";
                    break;
                default:
                    echo "<p>Unknown error</p>";
                    break;
            }
        }
    } else {
        echo "<p style='color: red;'>✗ No file data received</p>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Web Upload Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="file"] { padding: 10px; }
        button { padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; }
        button:hover { background: #005a87; }
        pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>Web Server File Upload Test</h1>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="test_file">Select a file to upload:</label>
            <input type="file" name="test_file" id="test_file" accept="image/*" required>
        </div>
        
        <div class="form-group">
            <label for="test_field">Test field:</label>
            <input type="text" name="test_field" id="test_field" value="test value">
        </div>
        
        <button type="submit">Upload File</button>
    </form>
    
    <hr>
    
    <h3>PHP Configuration:</h3>
    <ul>
        <li>upload_max_filesize: <?php echo ini_get('upload_max_filesize'); ?></li>
        <li>post_max_size: <?php echo ini_get('post_max_size'); ?></li>
        <li>max_file_uploads: <?php echo ini_get('max_file_uploads'); ?></li>
        <li>file_uploads: <?php echo ini_get('file_uploads'); ?></li>
        <li>upload_tmp_dir: <?php echo ini_get('upload_tmp_dir') ?: 'System default'; ?></li>
    </ul>
    
    <h3>Server Info:</h3>
    <ul>
        <li>PHP Version: <?php echo PHP_VERSION; ?></li>
        <li>Server API: <?php echo PHP_SAPI; ?></li>
        <li>Document Root: <?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown'; ?></li>
        <li>Request Method: <?php echo $_SERVER['REQUEST_METHOD']; ?></li>
        <li>Content Type: <?php echo $_SERVER['CONTENT_TYPE'] ?? 'Not set'; ?></li>
        <li>Content Length: <?php echo $_SERVER['CONTENT_LENGTH'] ?? 'Not set'; ?></li>
    </ul>
</body>
</html>
