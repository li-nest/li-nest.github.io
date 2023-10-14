<?php
/**
 * Plugin Countdown: Displays countdown from a specific date
 *                   Syntax: <COUNTDOWN:date|description>
 * date has to be formatted as GNU date (see strtotime)
 * e.g.              <COUNTDOWN:yyyy-mm-dd|description>
 *                   <COUNTDOWN:mm/dd/yyy|description>
 *
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @author  Ekkart Kleinod <ekkart [at] ekkart.de> (V 2.x)
 * @author  Ron Peters <rbpeters [at] peterro.com> (V 1.0)
 *
 * @version 2.1.3 (2009-01-24)
 *          french language file
 * @version 2.1.2 (2008-07-20)
 *          estonian language file
 * @version 2.1.1 (2008-04-17)
 *          polish language file
 *          correct swedish translation for 'today'
 * @version 2.1 (2008-03-04)
 *          bugfix: no newline after "?>" (Warning: Cannot modify header information...)
 *          bugfix: computation of days with ceil (problem with 1 day into future)
 *          new: today, use_today
 * @version 2.0.1 (2008-02-20)
 *          swedish language file
 * @version 2.0 (2008-02-18)
 *          enhanced functionality
 *          enhanced input (using strtotime, and therefore GNU date formats)
 *          optional output of entered date
 * @version 1.0
 *          based on a nucleuswiki plugin by Trent Adams | Edmond Hui
 *          basic input functionality
 *
 * @since   1.0
 *
 * Attention: the last characters of the file have to be "?>", no newline or something else
 */

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * Plugin-Class for Countdown-Plugin.
 *
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from DokuWiki_Syntax_Plugin
 */
class syntax_plugin_countdown extends DokuWiki_Syntax_Plugin {

    /**
     * Plugin Constructor.
     */
    function syntax_plugin_countdown() {
      // enable direct access to language strings
      $this->setupLocale();
      // enable direct access to configuration
      $this->loadConfig();
    }

    /**
     * Return plugin info for admin page.
     */
    function getInfo(){
        return array(
            'author' => 'Ekkart Kleinod',
            'email'  => 'ekkart@ekkart.de',
            'date'   => '2009-01-24',
            'name'   => 'Countdown v2.1.3',
            'desc'   => $this->lang['plugins']['countdown']['desc'],
            'url'    => 'http://wiki.splitbrain.org/plugin:countdown',
        );
    }

    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }


    /**
     * Where to sort in?
     */
    function getSort(){
        return 721;
    }

    /**
     * Connect pattern to lexer.
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\<COUNTDOWN\:.*?\>',$mode,'plugin_countdown');
    }

    /**
     * Handle the match.
     */
    function handle($match, $state, $pos, &$handler){
        //strip <countdown: from start and > from end
        $stripped = substr($match,11,-1);
        // separate date from description
        $stripped = explode("|",$stripped);
        return $stripped;
    }

    /**
     * Create output.
     */
    function render($mode, &$renderer, $data) {

        if ($mode == 'xhtml') {

          $parsedDate = strtotime($data[0]);

          // check parsed date
          if ($parsedDate <= 0) {
            $renderer->doc .= $this->lang['plugins']['countdown']['wrongformat'] . $data[0] . ": " . $data[1];
          } else {

            // get description
            if ($data[1]) {
              $description = $data[1];
            } else {
              $description = $this->lang['plugins']['countdown']['nodesc'];
            }

            // compute date difference in days
            // 86400 = 24*60*60 = seconds of one day
            $difference = ($parsedDate - time(void)) / 86400;

            // convert $time into integer value
            $difference = ceil($difference);

            // output
            if (($difference == 0) && $this->conf['plugins']['countdown']['use_today']) {
              // today is...
              $renderer->doc .= "<strong>" . $this->lang['plugins']['countdown']['today'] . "</strong>";
            } else {
              // ... day[s] ...
              $renderer->doc .= "<strong>" . sprintf("%.0f", abs($difference)) . "</strong> ";
              $renderer->doc .= (abs($difference) == 1) ? $this->lang['plugins']['countdown']['oneday'] : $this->lang['plugins']['countdown']['days'];
              $renderer->doc .= " ";
              // "since" or "until"
              $renderer->doc .= ($difference < 0) ? $this->lang['plugins']['countdown']['since'] : $this->lang['plugins']['countdown']['until'];
            }
            $renderer->doc .= " " . $description;

            // output date?
            if ($this->conf['plugins']['countdown']['include_date']) {
              $renderer->doc .= " (" . strftime($this->lang['plugins']['countdown']['outputformat'], $parsedDate) . ")";
            }

          }

          return true;

        }

        return false;

    }

}
?>
