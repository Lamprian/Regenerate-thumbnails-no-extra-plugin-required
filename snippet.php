function regenerateThumbnails()
{
    global $wpdb;
    
    $images = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%'");
 
    foreach ($images as $image)
    {
        $id = $image->ID;
        $fullsizepath = get_attached_file($id);
 
        if (false === $fullsizepath || !file_exists($fullsizepath))
            return;
 
        require_once(ABSPATH . 'wp-admin/includes/image.php');
 
        if (wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $fullsizepath)))
            return true;
        else
            return false;
    }
}
