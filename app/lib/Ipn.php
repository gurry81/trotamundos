<?php 
	class Ipn{

		static function log_paypal($numero,$texto){
			$ddf = fopen(app_path() . '/lib/logs/error.log','a');
			fwrite($ddf,"[".date("r")."] Código: $numero: $texto\r\n");
			fclose($ddf);
		}

		static function log_paypal_personal($numero,$texto,$email){
			$raw_post_array = explode('@',$email);
			$nombre = $raw_post_array[0];
			$ddf = fopen(app_path() . '/lib/logs/'.$nombre.'.log','a');
			fwrite($ddf,"[".date("r")."] Código: $numero: $texto\r\n");
			fclose($ddf);
		}

	static function procesar_transaccion_IPN($email, $moneda){
		Ipn::log_paypal("000","Peticion recibida");
		
			var_dump($_POST);
		if($_POST){
			Ipn::log_paypal("000","POST");
			// Obtenemos los datos en formato variable1=valor1&variable2=valor2&...
			$raw_post_data = file_get_contents('php://input');
		
			// Los separamos en un array
			$raw_post_array = explode('&',$raw_post_data);
		
			// Separamos cada uno en un array de variable y valor
			$myPost = array();
			foreach($raw_post_array as $keyval){
				$keyval = explode("=",$keyval);
				if(count($keyval) == 2)
					$myPost[$keyval[0]] = urldecode($keyval[1]);
			}
			
			$custom = explode('#',$myPost['custom']);
			$id_game = $custom[0];
			$user = $custom[1];
		
			// Nuestro string debe comenzar con cmd=_notify-validate
			$req = 'cmd=_notify-validate';
			if(function_exists('get_magic_quotes_gpc')){
				$get_magic_quotes_exists = true;
			}
			foreach($myPost as $key => $value){
				// Cada valor se trata con urlencode para poder pasarlo por GET
				if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
					$value = urlencode(stripslashes($value));
				} else {
					$value = urlencode($value);
				}
		
				//Añadimos cada variable y cada valor
				$req .= "&$key=$value";
			}
		
			Ipn::log_paypal_personal("Enviando", $req, $user);
		
			$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');   // Esta URL debe variar dependiendo si usamos SandBox o no. Si lo usamos, se queda así.
			// $ch = curl_init('https://www.paypal.com/cgi-bin/webscr');         // Si no usamos SandBox, debemos usar esta otra linea en su lugar.
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		
			if( !($res = curl_exec($ch)) ) {
				// Ooops, error. Deberiamos guardarlo en algún log o base de datos para examinarlo después.
				curl_close($ch);
				exit;
			}
			curl_close($ch);
		
			if (strcmp ($res, "VERIFIED") == 0) {
		
				$error = false;
		
				Ipn::log_paypal_personal("002", "Estado VERIFIED devuelto por Paypal al reenviarle el paquete de vuelta.", $user);
				/**
				 * A partir de aqui, deberiamos hacer otras comprobaciones rutinarias antes de continuar. Son opcionales, pero recomiendo al menos las dos primeras. Por ejemplo:
				 *
				 * * Comprobar que $_POST["payment_status"] tenga el valor "Completed", que nos confirma el pago como completado.
				 * * Comprobar que no hemos tratado antes la misma id de transacción (txd_id)
				 * * Comprobar que el email al que va dirigido el pago sea nuestro email principal de PayPal
				 * * Comprobar que la cantidad y la divisa son correctas
				*/
		
				Ipn::log_paypal_personal("Verificando estado del pago", $myPost['payment_status']."= Completed", $user);
				if($myPost['payment_status']==='Completed'){
					Ipn::log_paypal_personal("Estado del pago verificado", "El estado del pago ha sido verificado correctamente: ".$myPost['payment_status'], $user);
				}else{
					Ipn::log_paypal_personal("Estado del pago incorrecto", "El estado del pago recibido no es el correcto: ".$myPost['payment_status'], $user);
					$error = true;
				}
		
				Ipn::log_paypal_personal("Verificando Email vendedor", $myPost['business']." = ".$email, $user);
				if($myPost['business']===$email){
					Ipn::log_paypal_personal("Vendedor verificado", "El vendedor ha sido verificado correctamente: ".$myPost['business'], $user);
				}else{
					Ipn::log_paypal_personal("Vendedor incorrecto", "El vendedor recibido no es el correcto: ".$myPost['business'], $user);
					$error = true;
				}
		
				Ipn::log_paypal_personal("Verificando divisa", $myPost['mc_currency']." = ".$moneda, $user);
				if($myPost['mc_currency']===$moneda){
					Ipn::log_paypal_personal("Divisa verificada", "La divisa ha sido verificada correctamente: ".$myPost['mc_currency'], $user);
				}else{
					Ipn::log_paypal_personal("Divisa incorrecta", "La divisa recibida no es correcta: ".$myPost['mc_currency'], $user);
					$error = true;
				}
				
				$game = Game::find($id_game);

				if($myPost['mc_gross'] != $game->price){
					Ipn::log_paypal_personal("Precio incorrecto", "El dinero recibido no es el correcto: ".$myPost['mc_gross'], $user);
					$error = true;
				}
				
				// $socio = selectSocioPorEmail($user);
				// if($tipo_socio == "PEOPLE_EMPRESA") {
				// 	$tipo_socio = "PEOPLE";
				// }
				// $idTipoSocio = seleccionarTipoSocio($tipo_socio);
				
				// if($socio['tipo_socio'] == $idTipoSocio['id']){
				// 	Ipn::log_paypal_personal("Tipo socio verificado", "El tipo de socio ha sido verificada correctamente: ".$socio['tipo_socio'], $user);
				// }else{
				// 	Ipn::log_paypal_personal("Tipo socio incorrecto", "El tipo de socio recibido no es correcto: ".$socio['tipo_socio'], $user);
				// 	$error = true;
				// }
		
				// Después de las comprobaciones, toca el procesamiento de los datos.
				if(!$error){
					$resultado = Game::register($user, $id_game);
					if($resultado){
						Ipn::log_paypal_personal("Activando socio", "El socio: ".$user." de tipo ".$tipo_socio." se está activando.", $user);
						
						// $resultado_pagado = setContratoVigenteSocioPagado($user);
						
						// if($resultado_pagado){
						// 	Ipn::log_paypal_personal("Contrato como PAGADO", "El socio: ".$user." de tipo ".$tipo_socio." ha pagado.", $user);
						// }else{
						// 	Ipn::log_paypal("ERROR Contrato PAGADO","El contrato_socio no se ha cambiado a estado PAGADO correctamente", $user);
						// }
						
					}else{
						Ipn::log_paypal_personal("ERROR al registrar USUARIO","El usuario no se ha activado correctamente", $user);
					}
				}else{
					Ipn::log_paypal_personal("ERROR", "No se ha activado el socio debido a algún error de verificación.", $user);
				}
			} else if (strcmp ($res, "INVALID") == 0) {
				// El estado que devuelve es INVALIDO, la información no ha sido enviada por PayPal. Deberías guardarla en un log para comprobarlo después
				Ipn::log_paypal("001", "Valor INVALID devuelto por Paypal al reenviar el paquete");
			}
		} else {// Si no hay datos $_POST
			// Podemos guardar la incidencia en un log, redirigir a una URL...
			Ipn::log_paypal("000","No ha llegado una petición POST.");
		}
	}
	}
 ?>