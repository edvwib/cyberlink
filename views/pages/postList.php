<?php
declare(strict_types=1);

$posts = $pdo->query("SELECT * FROM posts");
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {
    $score = getPostScoreByID(intval($post['post_id']), $pdo);
    $user = getUserByID(intval($post['user_id']), $pdo);
    $commentCount = getCommentCountByID(intval($post['post_id']), $pdo);
    ?>
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2">
        <div class="row">
          <span class="col-1"><?php echo ($score===1)?($score.'pt'):($score.'pts') ?></span>
          <a class="col-10 offset-1" href="http://<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a>
        </div>
        <div class="row">
          <span class="col-7 col-sm-5"><?php echo date($dateFormat, (int)$post['time']); ?></span>
          <?php if ($post['user_id'] != 0): ?>
              <a class="col-5 offset-sm-2 text-right" href="http://<?php echo parse_url($post['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($post['link'], PHP_URL_HOST); ?>)</a>
          <?php endif; ?>
        </div>
        <div class="row">
          <p class="col-12 mb-0"><?php echo ($post['description']!=null && strlen($post['description']) < 105)?(substr($post['description'], 0, 105). '...'):($post['description']) ?></p>
        </div>
        <div class="row">
          <a href="?page=user&user=<?php echo $user ?>" class="col-8 col-sm-6">/u/<?php echo $user ?></a>
          <a href="?page=post&post=<?php echo $post['post_id'] ?>"class="col-4 offset-sm-2 text-right">comments(<?php echo $commentCount ?>)</a>
        </div>
      </div>
    </div>
    <hr>
    <?php
}
