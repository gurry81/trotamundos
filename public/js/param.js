var Param = {
	queryString: window.location.search,
	getArray: function(query){
		
		if(!query)
			return []

		var array = query.split("&");
		var newArray = Array();
		for (var param in array) {
			var param = array[param].split("=");
			newArray[param[0]] = param[1];
		};

		return newArray;
			
	},
	getString: function(array){
		var query = "";

		if(!array)
			return query;

		for (var param in array) {
			query += param + "=" + array[param] + "&";
		};
		return query;
	},
	getStringOfSerialize: function(array){
		var query = "";

		if(!array)
			return query;

		for (var param in array) {
			query += array[param].name + "=" + array[param].value + "&";
		};
		return query;
	},
	only: function(param){
		var query = this.clear(this.queryString);
		query = this.getArray(query);

		return query[param];

	},
	get: function(params,array){
		if(!params)
			return this.all(array);

		if(typeof params == "string")
			var query = params + "=" + this.only(params);
		else{
			var query = Array();
			for (var param in params) {
				query[param] = params[param] + "=" +this.only(params[param]);
			};
			query = query.join("&");
		}

		if(array)
			return this.getArray(query);
		else
			return query;

	},
	all : function(array){
			var query = this.clear(this.queryString);
			if(array)
				return this.getArray(query);
			return query;
			
	},
	except:function(elements,array){
		if(!elements)
			return this.all(array);
		else{
			var query = this.clear(this.queryString);
			query = this.getArray(query);

			for (var param in elements) {
				delete query[elements[param]];
			};

			if(array)
				return query;
			else{
				return this.getString(query);
			}
		}

	},
	has: function(param){
		var query = this.clear(this.queryString);
		query = this.getArray(query);

		for (var key in query) {
			 if(key == param){
			 	if(query[key] != "")
			 		return true
			 	return false;
			 }
		};
		return false;
	},
	clear: function(query){
		return query.replace(/^[?]/,"").replace(/[&]$/,"");
	},
	notNulls: function(params){
		var clearQuery = {};

		for (var param in params) {
			if(params[param] !== null){
				clearQuery[param] = params[param];
			}
		};

		return clearQuery;
	}
}