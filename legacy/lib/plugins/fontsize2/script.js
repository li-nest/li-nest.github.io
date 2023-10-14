/* javascript function to create fontsize2 toolbar in dokuwiki */
/* see http://wiki.splitbrain.org/plugin:fontsize2 for more info */
 
var plugin_fontsize2 = {
 
  "0_5":      "0.5em",
  "0_6":         "0.6em",
  "0_7":      "0.7em",
  "0_8":      "0.8em",
  "0_9":      "0.9em", 
  "1":        "1em",
  "1_1":        "1.1em",
  "1_2":        "1.2em",
  "1_4":        "1.4em",
  "1_6":        "1.6em",
  "1_8":        "1.8em",
  "2":        "2em",
  "2_2":        "2.2em",
  "2_4":        "2.4em",
  "2_6":        "2.6em",
  "2_8":        "2.8em",
  "3":        "3em",
  "3_5":        "3.5em",
  "4":        "4em",
  "4_5":        "4.5em",
  "5":        "5em",
  "5_5":        "5.5em",
  "6":        "6em",
  "6_5":        "6.5em",
  "7":        "7em",
  "8":        "8em",
  "9":        "9em",
  "10":        "10em" 
};
 
if (isUndefined(user_fontsize2)) {
  var user_fontsize2 = { };
}
 
function plugin_fontsize2_make_fontsize2_button(name, value) {
 
  var b_id = name;	// picker id that we're creating
  var b_ico = document.createElement('img');
  b_ico.src = DOKU_BASE + 'lib/plugins/fontsize2/images/'+name+'.png';
  var btn = document.createElement('button');
 
  btn.className = 'pickerbutton';
  btn.value = value;
  btn.title = name;
  btn.style.height = '10em';
  btn.style.padding = '0em';
  btn.name = value;
  btn.appendChild(b_ico);
 
  var open = "<fs " + value + ">";
  var close ="<\/fs>";
  var sample = name + " 100%";
 
  eval("btn.onclick = function(){ insertTags( '"
    + jsEscape('wiki__text') + "','"
    + jsEscape(open) + "','"
    + jsEscape(close) + "','"
    + jsEscape(sample) + "'); return false; } "
  );
 
  return(btn);
 
}
 
function plugin_fontsize2_toolbar_picker() {
 
                  // Check that we are editing the page - is there a better way to do this?
                  var edbtn = document.getElementById('edbtn__save');
                  if (!edbtn) return;
 
                  var toolbar = document.getElementById('tool__bar');
                  if (!toolbar) return;
 
  // Create the picker button
  var p_id = 'picker_plugin_fontsize2';	// picker id that we're creating
 
  var p_ico = document.createElement('img');
  p_ico.src = DOKU_BASE + 'lib/plugins/fontsize2/images/toolbar_icon.png';
  var p_btn = document.createElement('button');
  p_btn.className = 'toolbutton';
  p_btn.title = 'Fontsize';
  p_btn.appendChild(p_ico);
  eval("p_btn.onclick = function() { showPicker('" 
    + p_id + "',this); return false; }");
 
  // Create the picker <div>
  var picker = document.createElement('div');
  picker.className = 'picker';
  picker.id = p_id;
  picker.style.position = 'absolute';
  picker.style.display = 'none';
 
  /// Add a button to the picker <div> for each of the colors
  for( var fs in plugin_fontsize2 ) {
    if (!isFunction(plugin_fontsize2[fs])) {
      var btn = plugin_fontsize2_make_fontsize2_button(fs,
          plugin_fontsize2[fs]);
      picker.appendChild(btn);
    }
  }
 
 
 
  var body = document.getElementsByTagName('body')[0];
  body.appendChild(picker);	// attach the picker <div> to the page body
  toolbar.appendChild(p_btn);	// attach the picker button to the toolbar
}
 
addInitEvent(plugin_fontsize2_toolbar_picker);
 
//Setup VIM: ex: et ts=2 sw=2 enc=utf-8 :