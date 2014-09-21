jQuery(document).ready(function(){
	jQuery('.top-scroll-nav a').each(function() {
	        jQuery(this).click(function(){
	                var anchorID = jQuery(this).attr("href");
	                anchorID = anchorID + " a";
	                jQuery(anchorID).click();
	                return true;
	        });

	});
	
	if (window.location.hash) {
            var hash = window.location.hash;
            hash = hash + " a";
            jQuery(hash).click();
    }
});
