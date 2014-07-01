<?php 
	class GUI{
		static $templates = [
			"OTHER_FILTERS" => "other-filters.php", 
			"SPORT_FILTER" => "sport-filter.php",
			"SPAIN-MAP" => "spainMap.php",
			"GAME_ABOUT" => "game-about.php", 
			"POST_ABOUT" => "post-about.php",
			"MORE_AUTHOR" => "more-author.php",
			"TOP_PUBLICATIONS" => "top-publications.php",
			"SINGLE_POST" =>"single-post.php",  
			"SINGLE_GAME" =>"single-game.php",  
			// "SINGLE_ROUTE" =>"single-route.php",  
			"POST_LIST" =>"article-list.php",   
			"GAME_LIST" =>"article-list.php",   
			// "ROUTE_LIST" =>"route-list.php", 
			"DASH-SIDEBAR" =>"dash-sidebar.php", 
			"PERFIL" =>"dash-perfil.php", 
			"DASH-POST-LIST" =>"dash-post-list.php", 
			"DASH-POST-TABLE" => "dash-post-table.php",			
			"DASH-USER-LIST" =>"dash-user-list.php", 
			"DASH-USER-TABLE" => "dash-user-table.php",
			"DASH-PLAYER-LIST" =>"dash-player-list.php", 
			"DASH-PLAYER-TABLE" => "dash-player-table.php",
			"USER-NEW" => "dash-user-new.php",
			"USER-EDIT" => "dash-user-edit.php",
			"POST-NEW" => "dash-post-new.php",
			"GAME-NEW" => "dash-game-new.php",
			"POST-EDIT" => "dash-post-edit.php",
		];

		static function header($userType = null){
			 require app_path() . "/views/layouts/parts/header.php";
		}

		static function footer($userType = null){
			 require app_path() . "/views/layouts/parts/footer.php";
		}

		static function sidebar($options,$details = null){

			foreach ($options as $value) {

			 require app_path() . "/views/layouts/parts/" . $value;
			}
		}

		static function slider($query, $posts, $ajax = false){
			if($ajax){
				$articles = [];
				$type = $query->options["type"];

				foreach ($posts as $key => $post) {
					$articles[$key] = '<div class="article-intro">
										<div class="article-title"><a href="' . route("single" . $type) . '/' . $post->id . '" >' . $post->title . '</a></div>
										<img class="article-img" src=' . url("/media/posts")  . '/' . $post->$type->image . '>
										<div class="article-meta">';

					foreach ($post->sports as $sport) { 
						$articles[$key] .= '<span class="article-sport icon-' . strtolower($sport->icon). '"></span>';
					} 
					$articles[$key] .= '<span class="votes">' . $post->votes . '<span class="icon-like"></span></span>
															<span class="author">' . trans("messages.by") . ' <a href=' . route("author",$post->user->email) . '>' . $post->user->nick . '</a></span>
													</div>
													</div>';
				}	
				return $articles;
			}

			require app_path() . "/views/layouts/parts/home-list.php";
		}

		static function sliderArticles($query, $posts,&$json){
			$json["next"] = false;

			if($query->options["limit"] == count($posts)){
				unset($posts[count($posts)-1]);
				$json["next"] = true;
			}
			
			foreach ($posts as $post) {
			 	$json["articles"][] = require app_path() . "/views/layouts/parts/article-slider.php";
			}

			return $json;
		}

		static function loop($query, $posts, $template){

			$next = false;

			if($query->options["limit"] == count($posts)){
				unset($posts[count($posts)-1]);
				$next = true;
			}

			foreach ($posts as $post) {
				require app_path() . "/views/layouts/parts/" . $template;
			}

			self::paginate($query->options["page"],$next);
		}

		static function single($post, $template){
			require app_path() . "/views/layouts/parts/" . $template;
		}

		static function paginate($page,$next){
			$paginateLinks = [];
			$query = "";

			foreach (Input::except("page") as $key => $value) {
				$query .= $key . "=" . $value ."&";
			}

			if($next)
				$paginateLinks["next"] = "<a href='?page=" . ($page + 1) . "&$query' class='paginate next'>" . trans("messages.next") . "</a>";

			if($page > 0)
				$paginateLinks["previous"] = "<a href='?page=" . ($page - 1) . "&$query' class='paginate previous'>" . trans("messages.previous") . "</a>";

			echo implode(" ", $paginateLinks);
		}

		static function toTop(){
			echo '<span id="toTop" class="icon-to-top" onclick="goTop()"></span>';
		}

		static function help(){
			echo '<div id="help"><a href="' . route("help") . '">'. strtoupper(trans("messages.help")).'</a></div>';
		}

		static function dashboard($template,$data = null){
			 require app_path() . "/views/layouts/parts/" . $template;
		}

	}

 ?>