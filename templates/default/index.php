<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $config['language']; ?>" xml:lang="<?php echo $config['language']; ?>">
<head>
	<base href="http://<?php echo $_SERVER[ "HTTP_HOST" ]; ?>/" />
	<title><?php echo str_replace( '../', '',  $modules->get_filename( 'content' ) ).' - '.@$config[ 'title' ]; ?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8;" />

	<link href="templates/<?php echo $config[ 'template' ]; ?>/css/layout.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="templates/<?php echo $config[ 'template' ]; ?>/css/content.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="css/base.css" rel="stylesheet" type="text/css" media="screen" />


	<!-- Include these files only in IE -->
	<!--[if IE]>
	<link href="templates/<?php echo $config[ 'template' ]; ?>/css/ie.css" rel="stylesheet" type="text/css" media="screen" />
	<![endif]-->

	<!-- Include these files only in IE <= 6 -->
	<!--[if lte IE 6]>
	<link href="templates/<?php echo $config[ 'template' ]; ?>/css/ie6.css" rel="stylesheet" type="text/css" media="screen" />
	<script src="templates/<?php echo $config[ 'template' ]; ?>/js/ie6.js" type="text/javascript"></script>
	<![endif]-->

	<script type="text/javascript" src="js/mootools-core.js"></script>
	<script type="text/javascript" src="js/mootools-more.js"></script>
	<script type="text/javascript" src="js/mooplus.js"></script>
	<script type="text/javascript" src="configuration.js"></script>
</head>
<body>

	<div id="mainBody" class="mainBody">
		<div id="outerMenu">
		</div><!-- outerMenu -->
		<div class="mainContent">
			<div class="headerContent">
				<div id="logo_bg">
					<div id="backdrop"></div>
					<div id="logo" title="Return to <?php echo @$config[ 'sitename' ]; ?> Home" onclick="window.location='./'">
					</div><!-- logo -->
				</div><!-- logo_bg -->

				<div class="headerModule">
					<?php $modules->load( 'search' ); ?>
					<span id="headerbg"></span>
				</div><!-- headerModule -->

				<div class="toolbarModule">
					 <?php 
					 if ( $modules->exists( 'toolbar' ))
						 $modules->load( 'toolbar' ); 
					 ?>
				</div><!-- toolbarModule -->

				<?php $modules->load( 'main menu' ) ?>

			</div><!-- headerContent -->

			<div class="clear"></div>
			<div id="content">
				<?php
				//include( get_page( ) );
				$modules->load( 'content' );
				?>
				<div class="clear" style="height: 0;"></div>
			</div><!-- content -->

			<?php 
			if ( $modules->exists( 'footer' ) )
			{
				echo "<div id='footer'>\n";
				$modules->load( 'footer' );
				echo "</div>";
			}
			?>
		</div><!-- mainContent -->

		<br/>
		<div class="designer">Copyright &copy; <?php echo date( "Y" ).' '.$config[ 'site_owner' ] ?> - All Rights Reserved</div>
	</div><!-- mainBody -->


	<?php $modules->load( 'analytics' ); ?>
</body>
</html>

