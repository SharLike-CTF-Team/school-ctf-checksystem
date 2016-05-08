var AjaxContent = function(){
  var container_div = '';
	var content_div = '';
	return {
		getContent : function(url){
			$(container_div).animate({opacity:0}, //Turn the opacity to 0
					function(){ // the callback, loads the content with ajax
						$(container_div).load(url+" "+content_div, //only loads the selected portion
						function(){
						   $(container_div).animate({opacity:1}); //and finally bring back the opacity back to 1
					}
				);
			});
		},
		ajaxify_links: function(elements){

      //alert(c);
			$(elements).find("a").click(function(){
        		$(elements).find("li.active").removeClass("active");
        		$(this).parents("li").addClass("active");
				AjaxContent.getContent(this.href);
				return false; //prevents the link from beign followed
			});
		},
		init: function(params){ //sets the initial parameters
			container_div = params.containerDiv;
			content_div = params.contentDiv;
			return this; //returns the object in order to make it chainable
		}
	}
}();
