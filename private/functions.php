<?php
// functions.php - Image processing and helpers

function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function redirect_to($location) {
    header("Location: " . $location);
    exit;
}

function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function generate_unique_filename($original_filename) {
    $extension = pathinfo($original_filename, PATHINFO_EXTENSION);
    return uniqid('pokemon_', true) . '.' . strtolower($extension);
}

// IMAGE PROCESSING - Creates 200px thumbnail and 720px full-size
function process_pokemon_image($file, $target_dir = 'images/pokemon/') {
    $result = [
        'success' => false,
        'thumbnail' => null,
        'fullsize' => null,
        'error' => ''
    ];
    
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        $result['error'] = 'No file uploaded';
        return $result;
    }
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $result['error'] = 'Upload error: ' . $file['error'];
        return $result;
    }
    
    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime_type, $allowed_types)) {
        $result['error'] = 'Invalid file type. Only JPG, PNG, GIF, WEBP allowed.';
        return $result;
    }
    
    // Max 5MB
    if ($file['size'] > 5242880) {
        $result['error'] = 'File too large. Max 5MB.';
        return $result;
    }
    
    // Generate unique filenames
    $base_filename = generate_unique_filename($file['name']);
    $name_parts = pathinfo($base_filename);
    
    $thumbnail_filename = $name_parts['filename'] . '_thumb.' . $name_parts['extension'];
    $fullsize_filename = $name_parts['filename'] . '_full.' . $name_parts['extension'];
    
    // Create directories
    $thumbnail_dir = $target_dir . 'thumbnails/';
    $fullsize_dir = $target_dir . 'fullsize/';
    
    if (!is_dir($thumbnail_dir)) {
        mkdir($thumbnail_dir, 0755, true);
    }
    if (!is_dir($fullsize_dir)) {
        mkdir($fullsize_dir, 0755, true);
    }
    
    // Load image
    $source_image = null;
    switch ($mime_type) {
        case 'image/jpeg':
            $source_image = imagecreatefromjpeg($file['tmp_name']);
            break;
        case 'image/png':
            $source_image = imagecreatefrompng($file['tmp_name']);
            break;
        case 'image/gif':
            $source_image = imagecreatefromgif($file['tmp_name']);
            break;
        case 'image/webp':
            $source_image = imagecreatefromwebp($file['tmp_name']);
            break;
    }
    
    if (!$source_image) {
        $result['error'] = 'Failed to load image';
        return $result;
    }
    
    $orig_width = imagesx($source_image);
    $orig_height = imagesy($source_image);
    
    // Thumbnail: 200px wide
    $thumb_width = 200;
    $thumb_height = (int)(($orig_height / $orig_width) * $thumb_width);
    
    // Full-size: 720px wide (don't upscale)
    $full_width = min(720, $orig_width);
    $full_height = (int)(($orig_height / $orig_width) * $full_width);
    
    // Create thumbnail
    $thumbnail_image = imagecreatetruecolor($thumb_width, $thumb_height);

    // Preserve transparency for PNG/GIF
    if ($mime_type === 'image/png' || $mime_type === 'image/gif') {
        imagealphablending($thumbnail_image, false);
        imagesavealpha($thumbnail_image, true);
        $transparent = imagecolorallocatealpha($thumbnail_image, 0, 0, 0, 127);
        imagefill($thumbnail_image, 0, 0, $transparent);
    }

    imagecopyresampled($thumbnail_image, $source_image, 
                    0, 0, 0, 0, 
                    $thumb_width, $thumb_height, 
                    $orig_width, $orig_height);
    
    // Create full-size
    $fullsize_image = imagecreatetruecolor($full_width, $full_height);

    // Preserve transparency for PNG/GIF
    if ($mime_type === 'image/png' || $mime_type === 'image/gif') {
        imagealphablending($fullsize_image, false);
        imagesavealpha($fullsize_image, true);
        $transparent = imagecolorallocatealpha($fullsize_image, 0, 0, 0, 127);
        imagefill($fullsize_image, 0, 0, $transparent);
    }

    imagecopyresampled($fullsize_image, $source_image,
                    0, 0, 0, 0,
                    $full_width, $full_height,
                    $orig_width, $orig_height);
    
    // Save images
    $thumb_success = false;
    $full_success = false;
    
    switch ($mime_type) {
        case 'image/jpeg':
            $thumb_success = imagejpeg($thumbnail_image, $thumbnail_dir . $thumbnail_filename, 85);
            $full_success = imagejpeg($fullsize_image, $fullsize_dir . $fullsize_filename, 90);
            break;
        case 'image/png':
            $thumb_success = imagepng($thumbnail_image, $thumbnail_dir . $thumbnail_filename, 8);
            $full_success = imagepng($fullsize_image, $fullsize_dir . $fullsize_filename, 8);
            break;
        case 'image/gif':
            $thumb_success = imagegif($thumbnail_image, $thumbnail_dir . $thumbnail_filename);
            $full_success = imagegif($fullsize_image, $fullsize_dir . $fullsize_filename);
            break;
        case 'image/webp':
            $thumb_success = imagewebp($thumbnail_image, $thumbnail_dir . $thumbnail_filename, 85);
            $full_success = imagewebp($fullsize_image, $fullsize_dir . $fullsize_filename, 90);
            break;
    }
    
    imagedestroy($source_image);
    imagedestroy($thumbnail_image);
    imagedestroy($fullsize_image);
    
    if ($thumb_success && $full_success) {
        $result['success'] = true;
        $result['thumbnail'] = $thumbnail_filename;
        $result['fullsize'] = $fullsize_filename;
    } else {
        $result['error'] = 'Failed to save images';
    }
    
    return $result;
}

function delete_pokemon_images($thumbnail_filename, $fullsize_filename, $target_dir = 'images/pokemon/') {
    $thumbnail_path = $target_dir . 'thumbnails/' . $thumbnail_filename;
    $fullsize_path = $target_dir . 'fullsize/' . $fullsize_filename;
    
    if (file_exists($thumbnail_path)) {
        unlink($thumbnail_path);
    }
    if (file_exists($fullsize_path)) {
        unlink($fullsize_path);
    }
}

function set_success_message($message) {
    $_SESSION['success_message'] = $message;
}

function display_success_message() {
    if (isset($_SESSION['success_message'])) {
        $message = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        return '<div class="alert alert-success alert-dismissible fade show" role="alert">'
             . h($message) 
             . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>'
             . '</div>';
    }
    return '';
}
?>
