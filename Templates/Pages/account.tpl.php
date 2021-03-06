<?php
  // Check if the current page is the user's profile
  if(isset($_GET['user_id']) && isset($_SESSION['user_id']))
    $using_current = $_GET['user_id'] == $_SESSION['user_id'];
  else $using_current = UserLoggedIn();
  
  // Normally, the information on this page is for the current user
  if($using_current) {
    $current_user = true;
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $descriptor = 'you want to';
  }
  // If it's from a specific user, query that from the database
  else if(isset($_GET['user_id'])) {
    include_once('settings.php');
    include_once('db_actions.php');
    include_once('pdo.inc.php');
    
    $user_id = $_GET['user_id'];
    $info = dbUsersGet(getPDOQuick(), $user_id, 'user_id', true);
    if(!$info) {
      $username = 'No such user exists!';
      $descriptor = false;
    }
    else {
      $username = $info['username'];
      $descriptor = $username . ' wants to';
    }
  }
  else return AccessDenied();
  
?>
<!-- Lists of books the user wants -->
<section id="account">
  <h1 class="standard_main standard_vert giant"><?php echo $username; ?></h1>
  <?php if($descriptor): ?>
  
  <div id="user_books" class="standard_main half_holder">
    <div id="user_books_buy" class="half left">
      <h2>Books <?php echo $descriptor; ?> buy</h2>
      <hr />
      <?php 
        PrintRequest("publicPrintUserBooks", array(
          'user_id' => $user_id,
          'format' => 'Medium',
          'action' => 'Buy'
        ));
      ?>
    </div>
    <div id="user_books_sell" class="half right">
      <h2>Books <?php echo $descriptor; ?> sell</h2>
      <hr />
      <?php 
        PrintRequest("publicPrintUserBooks", array(
          'user_id' => $user_id,
          'format' => 'Medium',
          'action' => 'Sell'
        ));
      ?>
    </div>
    <div class="half_after"></div>
  </div>
  <?php else: ?>
  <aside class='user_id_no'>(ID <?php echo $user_id; ?>)</aside>
  <?php endif; ?>
</section>

<!-- Recommended trades -->
<?php if(UserLoggedIn()): ?>
<section id="recommendations">
  <h1 class="standard_main standard_vert giant">
  <?php
    echo 'recommendations for you';
    if(!$using_current) echo ' and ' . $username;
  ?></h1>
  <div class="standard_main standard_vert">
    <?php
      // If you're the current user, find all matching entries in the entire database
      if($using_current)
        PrintRequest('publicPrintRecommendationsDatabase', array('user_id' => $user_id));
      // Otherwise you're another user, find the matches between the two of you
      else PrintRequest('publicPrintRecommendationsUser', array(
        'user_id_a' => $_SESSION['user_id'],
        'user_id_b' => $user_id
      ));
    ?>
  </div>
</section>
<?php endif; ?>

<!-- Display a feed of the most recently placed stuff -->
<?php if($using_current): ?>
<section id="recent">
  <h1 class="standard_main standard_vert giant">recent <?php echo getSchoolName(); ?> listings</h1>
  <div class="standard_main listings">
    <?php PrintRequest("publicPrintRecentListings"); ?>
  </div>
</section>
<?php endif; ?>