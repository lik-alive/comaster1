<form role="search" class="search-form" action="<?php echo esc_url(home_url('/'));?>">
 <div>
  <label class="sr-only"><?php _e("Search for","cactus");?>:</label>
   <input type="text" name="s" value="" placeholder="<?php esc_attr_e("Search...","cactus");?>">
   <input type="submit" value="">
  </div>
 </form>