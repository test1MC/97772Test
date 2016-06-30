framelength = window.parent.frames.length;
if(framelength == 0) {
	
	//alert("I'm not in a frame");
	if (document.getElementById) {
		//make the link visible
	    linkdiv = document.getElementById("hs_toclink");
		currentname = linkdiv.className;
        linkdiv.className=currentname+"_visible";
		//get the link
		linkscripts = document.getElementsByTagName("script");
		for(i = 0;i<linkscripts.length;i++) {
			scriptname = linkscripts[i].name;
			scriptid = linkscripts[i].id;
			//alert(linkscripts[i].id);
			if(scriptname == "hs_js" || scriptid == "hs_js") {
				scriptpath = linkscripts[i].src;
				//alert(scriptpath);
				scriptpath = scriptpath.replace("hs_js.js","../index.html")
				//alert(scriptpath);
			}
		}
		//set the link
		link_a = linkdiv.getElementsByTagName("a");
		for(i = 0;i<link_a.length;i++) {
			linkname = link_a[i].name;
			if(linkname == "hs_a") {
				link_a[i].href = scriptpath;
				//alert("linkname="+linkname+" linkpath="+link_a[i].href);
			}
		}
	}
	
	

}