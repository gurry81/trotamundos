<tr class="spacer"></tr>
<tr class="post-row">
	<td class="post-cell"><a href=<?php echo route("single" . $post->type, $post->id) ?>><?php echo $post->title ?></a></td>
	<td class="post-cell"><?php echo $post->type ?></td>
	<td class="post-cell"><?php echo $post->lang ?></td>
	<td class="post-cell"><a href=<?php echo route("user-edit", $post->user->email) ?>><?php echo $post->user->nick ?></a></td>
	<td class="post-cell"><?php echo $post->votes ?></td>
	<td class="post-cell"><?php echo $post->updated_at ?></td>
	<td class="post-cell">
		<a href=<?php echo route("post-edit", $post->id) ?> class="icon-edit option"></a>
		<a href=<?php echo route("post-remove", $post->id) ?> class="icon-remove option"></a>
		<?php if($post->type == Publication::$type["EVENT"]){ ?>
		<a href=<?php echo route("player-list" , $post->id) ?> class="icon-users option"></a>
		<?php } ?>
	</td>
</tr>