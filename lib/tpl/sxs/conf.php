<?php
/*
 * additional configuration options used by the SXS template
 */
$conf['sxs_sidebar_orientation'] = 'right';               // side the sidebar is on left|right
$conf['sxs_sitenav'] = false;                             // show site navigation in sidebar true|false
$conf['sxs_tagline'] = 'Wiki Pages';                      // tagline under wiki title
$conf['sxs_roundcorners'] = false;                        // main boxes with round corners? (mozilla only)
$conf['sxs_youarehere'] = true;                           // hierarchical navigation instaad of breadcrumbs
$conf['sxs_crumbsep'] = ' &rarr; ';                       // Specifies what separates each breadcrumb
$conf['sxs_index'] = 'home';                              // Sets the name for the index page of namespaces
$conf['sxs_removeunderscore'] = true;                     // Removes underscore from breadcrumb links
$conf['sxs_actions'] = array('edit', 'history', 'index', 'recent', 'admin', 'profile', 'login');
//$conf['sxs_actions'] = array('edit', 'history', 'index', 'spec', 'recent', 'purge', 'admin', 'profile', 'login');
                                                          // which actions should be available in the command box in the sidebar?
$conf['sxs_uselinks'] = true;                             // use links instead of buttons
$conf['sxs_act_ac_lvl'] = array(
    'admin' => AUTH_ADMIN,       // only admins can see the 'Admin' button
    'edit' => AUTH_EDIT,         // Show "Edit this page" only to users that have at least edit level access
    'history' => AUTH_EDIT,      // same for "Old revisions"
    'profile' => AUTH_ADMIN,
);
$conf['sxs_act_users'] = array(
    'edit' => '@reviewers,@editors',          // Always show edit to users of the groups 'reviewers' and 'editors'
    	      				      // If they don't have edit level access, they will see "Show page source"
    'history' => '@users,@reviewers,@editors',
    'recent' => '@users',
    //'purge' => '@SXS',
    //'spec' => '@spec',                       // Only SpEC members (and admins) should see the SpEC link
    'profile' => '@users',                    // Anybody who is logged in should be able to see the profile
    'login' => '@ALL',                        // Everybody should be able to see the Login button/link
);
?>
