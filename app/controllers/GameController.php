<?php 

	class GameController extends BaseController
	{
		
		function pagoPaypal(){
			Ipn::procesar_transaccion_IPN('alrolorojas-facilitator@gmail.com', 'USD');
		}

		function register($game){
			Player::create(["game" => $game, "user" => Auth::user()->email]);

			return Redirect::route("singlegame",$game);
		}
	}
 ?>