<?php 

	class Query{

		public $options;

		function __construct($options = null){
			$this->init($options);

			if($options)
				$this->mergeOptions($options);

		} 

		public function init($options){

			$this->options = [
				'id' => null,
				'title' => null,
				'type' => "all",
				'limit' => 4,
				'skip' => 0,
				'where' => null,
				'sport' => 5,
				'province' => null,
				'author' => null,
				'lang' => true,
				'orderby' => 'created_at',
				'order' => 'DESC',
				'paginate' => false,
				'page' => 0,
				// user query
				'email' => null,
				'nick' => null,
			];

		}

		public function mergeOptions($options){
			$this->options = array_merge($this->options,$options);
			if($this->options["paginate"])
				$this->paginate();
		}

		private function paginate(){
			$this->options["skip"] = $this->options["limit"] * $this->options["page"]; 
			$this->options["limit"]++;
		}
}

	

	