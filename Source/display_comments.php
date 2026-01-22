<div class="comments_reply">
    <div class="name"><?php echo htmlspecialchars($comment['user_name']); ?></div>
    <div class="comment"><?php echo htmlspecialchars($comment['comment']); ?></div>
    <div class="date"><?php echo htmlspecialchars($comment['comment_date']); ?></div>
    
    <?php 
        $reply_comment_id = $comment['id'];
       

        // Fetch and display replies
        $fetch_replies = $dbConn->prepare('SELECT * FROM chat WHERE reply_comment_id = ?');
        $fetch_replies->execute([$reply_comment_id]);
        $replies = $fetch_replies->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($replies)) {
            foreach ($replies as $reply) {
                
                $comment = $reply; 
                include 'display_comments.php'; 
            }
        }
    ?>
</div>
