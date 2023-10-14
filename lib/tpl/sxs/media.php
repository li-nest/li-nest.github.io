<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
/**
 * DokuWiki SXS Template -- based on the Roundbox template
 *
 * @link   http://wiki.splitbrain.org/wiki:tpl:roundbox
 * @author Chris Arndt <chris@chrisarndt.de>
 * (changes by Mike Boyle)
 */

include_once(dirname(__FILE__).'/conf.php');
include_once(dirname(__FILE__).'/lang/en/lang.php');
@include_once(dirname(__FILE__).'/lang/'.$conf['lang'].'/lang.php');

/* include template helper functions */
include_once(dirname(__FILE__).'/sxs.php');

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>" lang="<?php echo $conf['lang']?>" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo hsc($lang['mediaselect'])?> [<?php echo hsc($conf['title'])?>]</title>
    <?php tpl_metaheaders()?>
    <link rel="shortcut icon" href="<?php echo DOKU_TPL?>images/favicon.ico" />
  </head>
  <body style="padding-right:2%;">
    <!-- start dokuwiki block -->
    <div class="dokuwiki">
      
      <!-- start content block -->
      <div id="content" style="width: 100%;">
	
	<!-- start page block -->
	<div id="page" class="page">
	  <div class="clearer">&nbsp;</div>
	  
	  <?php html_msgarea()?>
	  
	  <h1>
            <?php echo hsc($lang['mediaselect']) ?><br />
            <code><?php echo hsc($NS)?></code>
	  </h1>
	  
	  Step 1: Upload a file.
	  
	  <div class="uploadform">
            <?php sxs_mediauploadform($_REQUEST['filetype'])?>
	  </div>
	  
	  <!-- start mediaselect -->
	  <div class="mediaselect">
	    
	    <br />
	    Step 2: Select the file from the list shown here.
	    
            <!-- start mediaselect right-->
            <div class="mediaselect-right">
	      <?php sxs_mediafilelist($_REQUEST['filetype'])?>
            </div>
            <!-- end mediaselect right-->
	    
            <!-- start mediaselect left-->
            <div class="mediaselect-left">
              <b><a href="<?php echo DOKU_BASE ?>lib/exe/media.php?ns="><?php echo hsc($lang['namespaces']) ?></a></b>
	      
              <?php tpl_medianamespaces()?>
            </div>
            <!-- end mediaselect left-->
	    
	  </div>
	  <!-- end mediaselect -->
	  
	</div>
	<!-- end page block -->
	
      </div>
      <!-- end content block -->
      
    </div>
    <!-- end dokuwiki block -->
    
  </body>
</html>

