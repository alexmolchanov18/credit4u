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


	let domain = document.getElementById("domain").value;
	console.log(domain)



	// console.log(source,campaign,promo,tid1,tid2);


	//find all links
	let links = document.getElementsByTagName("a");
	// console.log(links);

	//select links only with rdr & go
	let new_link_array = [];
	for(let i = 0;i < links.length; i++){
		var link_href = links[i].getAttribute("href");
		// console.log(link_href);
		if(link_href.includes("rdr.salesdoubler") || link_href.includes("go.salesdoubler") || link_href.includes("www.prtslinprtslink")){
			// console.log("Success");
			// console.log(link_href);
			new_link_array[i] = links[i];
		}
	}
	let links_modal = document.getElementsByClassName("tid2place");
	console.log(links_modal);
	let new_links_modal = [];
	for(let i=0; i<links_modal.length; i++){
		new_links_modal[i] = links_modal[i]
	}


	//replace links to new with parametrs
	let number_offer = 0;
	new_link_array.forEach(function(e){
		number_offer++;
		console.log(number_offer);
		let get_current_link = e.getAttribute("href");	
		e.href = get_current_link + "&tid2=" + number_offer + "_" + domain + "&" + source + "&" + promo + "&" + campaign + "&" + tid1;
	});
	number_offer = 0;

	new_links_modal.forEach(function(e){
		number_offer++;
		let get_current_link = e.getAttribute("href");
		let modal_current_link = get_current_link.substring(0,get_current_link.indexOf("&"));
		e.href = modal_current_link + "&tid2=" + number_offer + "_" + domain + "&" + source + "&" + promo + "&" + campaign + "&" + tid1;
	});


});