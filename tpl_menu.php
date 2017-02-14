<div class="menu">
  <ul>
		<?php foreach($menu_items as $name => $item): ?>
			<li class="menu-item <?php if ($item->active) echo 'active' ?>">
				<a href="<?php echo $item->link?>"><?php echo $item->name ?></a>
			</li>
		<?php endforeach; ?>
  </ul>
</div>
