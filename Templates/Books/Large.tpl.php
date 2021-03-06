<?php
  $isbn = $_TARGS['isbn'];
  $google_id = $_TARGS['google_id'];
  $title = $_TARGS['title'];
  $year = isset($_TARGS['year']) ? $_TARGS['year'] : false;
  $authors = $_TARGS['authors'];
  $description = isset($_TARGS['description']) ? $_TARGS['description'] : false;
  $pages = isset($_TARGS['pages']) ? $_TARGS['pages'] : false;
  $publisher = isset($_TARGS['publisher']) ? $_TARGS['publisher'] : false;
  
  // Search results are treated differently
  $is_search = isset($_TARGS['is_search']) && $_TARGS['is_search'];
  if($is_search) {
    if(strlen($description) > 490) {
      $description = substr($description, 0, 487);
      $description = substr($description, 0, strrpos($description, ' ')) . '...';
    }
  }
?>
<div class="book book_large">
  <?php if(!$is_search): ?>
  <!-- Main book heading -->
  <h1 class="standard_main standard_vert"><?php echo $title; ?></h1> 
  <?php endif; ?>
  
  <!-- Left-floating image (dominates a left column) -->
  <img src="http://bks2.books.google.com/books?id=<?php echo $google_id; ?>&printsec=frontcover&img=1&zoom=1&source=gbs_api" />
  
  <!-- Main holder for the book template of the page -->
  <div class="display_book_holder">
    <!-- Quick book info (author, year, Google link) -->
    <div class="display_book_info">
      <h2>
        <div class="a-emph viewgoogle"><a target="_blank" href="<?php echo getGoogleLink($google_id); ?>">View on Google</a></div>
        <?php if($is_search): ?>
        <h2 class="book_title"><?php echo getLinkHTML('book', $title, array('isbn'=>$isbn)); ?></h1>
        <?php endif; ?>
        <span class="authors"><?php echo str_replace('\n', ', ', $authors); ?></span>
        <aside><?php if($year) echo '(' . $year . ')'; ?></aside>
      </h2>
    </div>
    
    <!-- Large area for the book description -->
    <div class="display_book_description">
      <blockquote><?php echo htmlentities($description); ?></blockquote>
    </div>
    
    <!-- Right-floating export links -->
    <div class="display_book_export"><?php TemplatePrint('Books/Export', $tabs + 4, $_TARGS); ?></div>
    
    <!-- If there's information on publisher or number of pages, print some -->
    <?php if($publisher || $pages): ?>
    <div class="display_book_extra">
      <aside>
        <?php if($pages): echo $pages; ?> pages <?php endif; ?>
        <?php if($publisher && $pages) echo '/'; ?>
        <?php if($publisher): ?>Published by <strong><?php echo $publisher; ?></strong><?php endif; ?>
      </aside>
    </div>
    <?php endif; ?>
  </div>
  <div class="display_book_after"></div>
</div>