<?php $path = Route::getCurrentRoute()->getPath(); ?>

<header>
	<div id="home">
		<a href="<?php  echo route('home'); ?>"><span id="titleHome"><abbr title="home">TROTAMUND<span class="icon-earth"></span>S</abbr></span></a>
	</div>
	<div class="headerSeparator"></div>

	<div id="headerMenu">
		<nav>
			<ul>
				<li <?php echo (strpos($path, 'post') !== false)? "class=active":""; ?>><a href="<?php echo route(Publication::$type['NEW']); ?>"><?php echo trans("messages.posts") ?><div class="menuOver"></div></a></li>
				<li <?php echo (strpos($path, 'game') !== false)? "class=active":""; ?>><a href="<?php echo route(Publication::$type['EVENT']); ?>"><?php echo trans("messages.games") ?><div class="menuOver"></div></a></li>
			</ul>
		</nav>
	</div>

	<div class="headerSeparator"></div>

	<div id="header-user">
	<?php if(!Auth::check()){ ?>

	<div id="login">

		<?php echo Form::open(array('url' => 'login', 'method' => 'post')); ?>
			<div>
				<?php echo Form::text('email', null, array ("placeholder"=>trans("messages.email"))) ?>
				<?php echo Form::password('password',array ("placeholder"=>trans("messages.password"))) ?>
			</div>
			<div>
				<a href=<?php echo route("register-form") ?>><?php echo trans("messages.register") ?></a>
				<?php echo Form::submit(trans("messages.login") ,array("class" => "btn"));?>
			</div>
		<?php echo Form::close() ?>

	</div>
	<?php } else { 
		$user = Auth::user();
	?>
		<div id="perfil">
			<span id="user-name"><?php echo $user->nick ?></span>
			<img src= <?php echo url('/media/images') . '/' . $user->image ?>>
			<div id="user-menu-button" class="icon-right"></div>
			<ul id="user-menu">
				<li><a href=<?php echo route("dashboard") ?>><?php echo trans("messages.dash") ?></a></li>
				<li><a href=<?php echo route("logout") ?>><?php echo trans("messages.disconnect") ?></a></li>
			</ul>
		</div>
	<?php } ?>
	</div>
</header>
