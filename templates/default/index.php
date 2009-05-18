<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo LANGUAGE; ?>" xml:lang="<?php echo LANGUAGE; ?>">
<head>
	<title><?php echo @$config[ 'title' ]; ?></title>
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
</head>
<body>


<div id="wrap-a">


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
 <?php $modules->load( 'toolbar' ); ?>
</div><!-- toolbarModule -->

<div id="navigation">
<?php $modules->load( 'main menu' ) ?>
</div>

</div><!-- headerContent -->

<div id="user3">


</div><!-- user3 -->

<div class="clear"></div>
<!-- add which page this is for easier selection ? -->
<div id="content_">

<?php

//include( get_page( ) );
$modules->load( 'main_content' );

?>
<div class="clear" style="height: 0;"></div>
</div><!-- mainContent -->

<?php 
if ( $modules->exists( 'footer' ) )
{
	echo "<div id='footer'>\n";
	$modules->load( 'footer' );
	echo "</div>";
}
?>
</div><!-- mainBody -->

<br/>
<div class="designer">Copyright &copy; <?php echo date( "Y" ).' '.$config[ 'site_owner' ] ?> - All Rights Reserved</div>
</div>


<script type="text/javascript" src="js/mootools-more.js"></script>
<script type="text/javascript" src="js/mootools-extras.js"></script>
<script type="text/javascript" src="configuration.js"></script>
<script type="text/javascript" src="js/ecoliwebsearch.js"></script>
</body>
</html>

