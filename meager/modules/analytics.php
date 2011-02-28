<?php
/*
	Module
	======
		__Analytics__
			Embeds google analytics javascript file into your page.

		Options
		-------
			tracker : Your tracker number from the google analytics web site.
*/
if ( $this->get_opt('tracker') ) {
	printf(  "<script src='%sgoogle-analytics.com/ga.js' type='text/javascript'></script>", isset( $_SERVER[ "HTTPS" ] ) ? "https://ssl." : "http://www." );
?>

<script type="text/javascript"><!--
try {
	var pageTracker = _gat._getTracker("<?php echo $this->get_opt('tracker'); ?>");
	pageTracker._trackPageview();
} catch(err) {}
--></script>

<?php } ?>
