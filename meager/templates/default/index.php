<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $config['language']; ?>" xml:lang="<?php echo $config['language']; ?>">
<head>
	<base href="http://<?php echo $_SERVER[ "HTTP_HOST" ].$config[ 'http_root' ]; ?>/" />
	<title><?php echo str_replace( '../', '',  $modules->get_filename( 'content' ) ).' - '.@$config[ 'title' ]; ?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8;" />

	<link href="meager/templates/<?php echo $config[ 'template' ]; ?>/css/layout.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="meager/templates/<?php echo $config[ 'template' ]; ?>/css/content.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="css/base.css" rel="stylesheet" type="text/css" media="screen" />

	<!-- Include these files only in IE <= 6 -->
	<!--[if lte IE 6]>
	<link href="meager/templates/<?php echo $config[ 'template' ]; ?>/css/ie6.css" rel="stylesheet" type="text/css" media="screen" />
	<script src="meager/templates/<?php echo $config[ 'template' ]; ?>/js/ie6.js" type="text/javascript"></script>
	<![endif]-->
	<!-- Include these files only in IE <= 7 -->
	<!--[if lte IE 7]>
	<link href="meager/templates/<?php echo $config[ 'template' ]; ?>/css/ie7.css" rel="stylesheet" type="text/css" media="screen" />
	<script src="meager/templates/<?php echo $config[ 'template' ]; ?>/js/ie7.js" type="text/javascript"></script>
	<![endif]-->
	<!-- Include these files only in IE <= 8 -->
	<!--[if lte IE 8]>
	<link href="meager/templates/<?php echo $config[ 'template' ]; ?>/css/ie8.css" rel="stylesheet" type="text/css" media="screen" />
	<script src="meager/templates/<?php echo $config[ 'template' ]; ?>/js/ie8.js" type="text/javascript"></script>
	<![endif]-->
	<!-- Include these files only in IE -->
	<!--[if IE]>
	<link href="meager/templates/<?php echo $config[ 'template' ]; ?>/css/ie.css" rel="stylesheet" type="text/css" media="screen" />
	<script src="meager/templates/<?php echo $config[ 'template' ]; ?>/js/ie.js" type="text/javascript"></script>
	<![endif]-->

<?php 
if ( $modules->exists( 'head' ))
	$modules->load( 'head' );
?>

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

			<?php
			if ( isset( $_SESSION[ 'username' ])) {
				echo "<div id='user_control'>";
				echo $_SESSION[ 'username' ];		
				echo "</div>";
			}
			?>

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

