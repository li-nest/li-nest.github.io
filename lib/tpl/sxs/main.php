<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include_once(dirname(__FILE__).'/conf.php');
include_once(dirname(__FILE__).'/lang/en/lang.php');
@include_once(dirname(__FILE__).'/lang/'.$conf['lang'].'/lang.php');
if ($conf['sxs_sitenav']) {
  include(dirname(__FILE__).'/sidebar.php');
}
include_once(dirname(__FILE__).'/sxs.php');
$user = sxs_get_user_info();
$perms = auth_quickaclcheck($ID);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php tpl_pagetitle()?> [<?php echo hsc($conf['title'])?>]</title>

  <?php tpl_metaheaders()?>

  <link rel="shortcut icon" href="<?php echo DOKU_TPL?>images/favicon.ico" />

  <?php /*old includehook*/ @include(dirname(__FILE__).'/meta.html')?>
	
  <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
  </script>
  <script type="text/javascript">
  _uacct = "UA-1887903-2";
  urchinTracker();
  </script>	
</head>
<a name="dokuwiki__top"></a>


<body <?php global $ACT; if($ACT=='login') { ?> onload="document.login_form.u.focus();";<?php } ?> >
  <?php /*old includehook*/ @include(dirname(__FILE__).'/topheader.html')?>

  <div class="dokuwiki"><!--start dokuwiki block-->
    <?php html_msgarea()?>

    <!--<?php /*old includehook*/ @include(dirname(__FILE__).'/header.html')?>-->
    
    <div id="content"><!--start content block-->
    <?php if($conf['breadcrumbs']) { ?>
    <div class="breadcrumbs">
      <?php if($conf['sxs_youarehere']) {
	    echo sxs_youarehere();
	    } else {
	    echo tpl_breadcrumbs();
	    }?>
    </div><!--end breadcrumbs-->
    <?php }?>
    
    <!--</div>-->
    <?php flush()?>
    
    <?php /*old includehook*/ @include(dirname(__FILE__).'/pageheader.html')?>
    
    <div class="page"><!--start page block-->
      <?php tpl_content()?>
      <div class="clearer">&nbsp;</div>
    
      <?php flush()?>
      <!--<div class="stylefoot">-->
      
      <hr />
      
      <table width="100%" ><tbody><tr>
	    
	    <td align="left">
	      <div class="toplink">
		<?php tpl_actionlink('top')?>
	      </div>
	    </td>
	    
	    <td align="right">
	      <!-- start page meta information -->
	      <div class="meta">
		<?php tpl_pageinfo()?>
	      </div>
	      <!-- end page meta information -->
	    </td>
	    
      </tr></tbody></table>
    </div><!--end page block-->
    
    </div><!--end content block-->

      <!-- start sidebar -->
      <div id="sidebar">
	
	<?php if ($conf['sxs_sitenav']) { ?>
	<!-- start site navigation box -->
	<div id="sitenav">
	  <div id="sitenav_title">
            <?php ptln(hsc($lang['sitenav_title']))?>
	  </div>
	  <?php html_sidebar('sitenav_content')?>
	</div>
	<!-- end site navigation box -->
	<?php } ?>
	
	<!-- start site commands box -->
	<div id="sitecmd">
	  <div id="sitecmd_title">
            <?php ptln(hsc($lang['sitecmd_title']))?>
	  </div>
	  <div id="sitecmd_content">
	    <?php sxs_sitecmds($perms, $user) ?>
	  </div>
	  
	</div>
	<!-- end site commands box -->
	
	<!-- start user info -->
	<div class="user">
	  <?php tpl_userinfo() ?>
	</div>
	<!-- end user info -->
	
	<!-- start footer -->
	<?php /*old includehook*/ @include(dirname(__FILE__).'/footer.html')?>
	<!-- end footer -->
	
      </div>
      <!-- end sidebar -->

      <?php /*old includehook*/ @include(dirname(__FILE__).'/pagefooter.html')?>
    </div><!--end dokuwiki block-->
  
  <div class="no"><?php tpl_indexerWebBug()?></div>

</body>
</html>
