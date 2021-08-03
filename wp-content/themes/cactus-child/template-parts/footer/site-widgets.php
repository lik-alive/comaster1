<div class="footer-widget-area">
      <div class="row">
      <?php for ($i = 1; $i <= 4; $i++) : ?>
      <?php if (is_active_sidebar("footer-".$i)) : ?>
		<div class="col-md-3 col-sm-6">
        <?php dynamic_sidebar("footer-".$i); ?>
        </div>
        <?php endif; ?>
        <?php endfor; ?>
      </div>
    </div>