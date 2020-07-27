window.addEventListener("load",function(){
	let home_href = window.location.search.replace( '?', '');
	console.log(home_href);
		let keys = {};
		home_href.split('&').forEach(function(item) {
	    item = item.split('=');
	    keys[item[0]] = item[1];
	});

	

	if(keys["source"] == undefined){
		source = "source="
	}else{
		source = "source=" + keys["source"]
	}

	if(keys["promo"] == undefined){
		promo = "promo="
	}else{
		promo = "promo=" + keys["promo"]
	}

	if(keys["campaign"] == undefined){
		campaign = "campaign="
	}else{
		campaign = "campaign=" + keys["campaign"]
	}
	if(keys["tid2"] == undefined){
		tid2 = "tid2="
	}else{
		tid2 = "tid2=" + keys["tid2"]
	}
	if(keys["tid1"] == undefined){
		tid1 = "tid1="
	}else{
		tid1 = "tid1=" + keys["tid1"]
	}



	



	console.log(source,campaign,promo,tid1,tid2);


	//find all links
	let links = document.getElementsByTagName("a");
	// console.log(links);

	//select links only with rdr & go
	let new_link_array = [];
	for(let i = 0;i < links.length; i++){
		var link_href = links[i].getAttribute("href");
		// console.log(link_href);
		if(link_href.includes("rdr.salesdoubler")|| link_href.includes("go.salesdoubler")){
			// console.log("Success");
			// console.log(link_href);
			new_link_array[i] = links[i];
		}
	}
	// console.log(new_link_array);


	//replace links to new with parametrs
	new_link_array.forEach(function(e){
		let get_current_link = e.getAttribute("href");
		console.log(get_current_link);
		e.href = get_current_link + "&" + source + "&" + promo + "&" + campaign + "&" + tid2+ "&" + tid1;
		console.log(e);
	});



});