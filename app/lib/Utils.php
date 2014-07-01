<?php 
	class Utils{
		static function baseUrl(){
 			return Config::get('globalVars.base_url');	
		}
		
		static function importRoutes($path){
			foreach (glob($path . "/*.php") as $file) {
				require $file;
			}
		}

		static function page(){
			return (isset($_GET["page"]))? $_GET["page"] : 0;
		}

		static function getDateFormat($lang){
			if(!$lang)
				$lang = Lang::getLocale();
			
			require app_path() . '/lib/date-formats.php';

			return $dateFormat[$lang];
		}

		static function parseDate($date, $lang = null){
			$format = self::getDateFormat($lang);
			if(gettype($date) == "string")
				$date = new DateTime($date);

			return $date->format($format);
		}

		static function upload($file,$directory = "images"){
			if($file){
				$path = public_path() . '/media/' . $directory;
				$filename = $file->getClientOriginalName();

				while(file_exists($path . '/' .$filename)){
					$filename = rand() . $filename; 
				}
				
				$file->move($path, $filename);
				return $filename;
			}

			return false;

		}
	}
 ?>