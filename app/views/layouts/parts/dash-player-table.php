<tr class="spacer"></tr>
<tr class="post-row">
	<td class="post-cell"><img src=<?php echo url("/media/images") . "/" . $post->image ?> width="30" /></td>
	<td class="post-cell"><?php echo $post->email ?></td>
	<td class="post-cell"><?php echo $post->nick ?></td>
	<?php if(Auth::user()->type == User::$type["ADMIN"]){ ?>
	<td class="post-cell">
		<a href=<?php echo route("user-edit", $post->email) ?> class="icon-edit option"></a>
		<a href=<?php echo route("user-remove", $post->email) ?> class="icon-remove option"></a>
	</td>
	<?php } ?>
</tr>