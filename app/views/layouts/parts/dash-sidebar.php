<?php $user = Auth::user(); ?>

<nav id="menu">
	<ul>
		<li class="menu-item <?php echo !Request::segment(2) ? 'active': ''?>" id="perfil" onclick="dropdown(this)">
			<img src=<?php echo url('/media/images') . '/' . "$user->image"?>>
			<span class="menu-title"><?php echo trans("messages.perfil") ?></span>
			<nav class="submenu">
				<ul>
					<li class="submenu-item <?php echo Route::getCurrentRoute()->getName() == 'dashboard'? 'selected': ''?>"><a href=<?php echo route("dashboard")?>><?php echo trans("messages.perfil") ?></a></li>
					<li class="submenu-item"><a href=<?php echo route("logout")?>><?php echo trans("messages.disconnect") ?></a></li>
				</ul>
			</nav>
		</li>
		<li class="menu-item">
			<a href=<?php echo route("home")?> class="menu-icon icon-earth"></a>
			<span class="menu-title">Trotamundos</span>
		</li>
		<?php if($user->type != "normal") {?>
		<li class="menu-item <?php echo Request::segment(2) == 'post'? 'active': ''?>" onclick="dropdown(this)">
			<a class="menu-icon icon-post" ></a>
			<span class="menu-title"><?php echo trans("messages.posts-menu") ?></span>
			<nav class="submenu">
				<ul>
					<li class="submenu-item <?php echo Route::getCurrentRoute()->getName() == 'post-list'? 'selected': ''?>"><a href=<?php echo route("post-list")?>><?php echo trans("messages.posts-menu") ?></a></li>
					<li class="submenu-item <?php echo Route::getCurrentRoute()->getName() == 'post-new'? 'selected': ''?>"><a href=<?php echo route("post-new")?>><?php echo trans("messages.new") ?></a></li>
				</ul>
			</nav>
		</li>
		<?php } ?>

		<?php if($user->type == "admin") {?>
		<li class="menu-item <?php echo Request::segment(2) == 'user'? 'active': ''?>" onclick="dropdown(this)">
			<a class="menu-icon icon-users"></a>
			<span class="menu-title"><?php echo trans("messages.users") ?></span>
			<nav class="submenu">
				<ul>
					<li class="submenu-item <?php echo Route::getCurrentRoute()->getName() == 'user-list'? 'selected': ''?>"><a href=<?php echo route("user-list")?>><?php echo trans("messages.users") ?></a></li>
					<li class="submenu-item <?php echo Route::getCurrentRoute()->getName() == 'user-new'? 'selected': ''?>"><a href=<?php echo route("user-new")?>><?php echo trans("messages.create") ?></a></li>
				</ul>
			</nav>
		</li>
		<?php } ?>

	</ul>
</nav>
