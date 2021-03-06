<?php
  $isbn = $_TARGS['isbn'];
?>
<div class="entry">
  <!-- Form to submit entry -->
  <form class="add_entry" onsubmit="event.preventDefault(); entryAddSubmit(event, <?php echo $_TARGS['isbn']; ?>);">
    <span class="display_entry_before">I would like to</span>
    <select class="entry_action">
      <?php
        $options = getBookActions();
        echo '<option>' . implode('</option><option>', array_map('strtolower', $options)) . '</option>';
      ?>
    </select>
    a
    <select class="entry_state">
      <?php
        $options = array_reverse(getBookStates());
        echo '<option>' . implode('</option><option>', array_map('strtolower', $options)) . '</option>';
      ?>
    </select>
    <br /><span class="big entry_title"><?php echo $_TARGS['title']; ?></span><br />
    <span class="display_entry_for">for</span>
    <?php TemplatePrint("Forms/Money", $tabs + 4); ?>
    <input type="submit" value="Go!" />
    
    <!-- Div to hold entry results -->
    <div class="entry_results"></div>
  </form>
</div>