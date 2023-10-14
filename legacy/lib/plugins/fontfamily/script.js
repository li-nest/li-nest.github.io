/* javascript function to create fontfamily toolbar in dokuwiki */
/* see http://wiki.splitbrain.org/plugin:fontfamily for more info */

var plugin_fontfamily = {
  "TimesNewRoman":        "Times New Roman",
  "Arial":        					"Arial",
  "BrushScriptMT":        "Brush Script MT",
  "ComicSansMS":        "Comic Sans MS",
  "Georgia":        "Georgia",
  "Impact":        "Impact",
  "Trebuchet ":        "Trebuchet " ,
  "Verdana":        "Verdana",
  "Webdings":        "Webdings"
};

if (isUndefined(user_fontfamily)) {
  var user_fontfamily = { };
}

function plugin_fontfamily_make_fontfamily_button(name, value) {

  var b_id = name;	// picker id that we're creating
  var b_ico = document.createElement('img');
  b_ico.src = DOKU_BASE + 'lib/plugins/fontfamily/images/'+name+'.png';
  var btn = document.createElement('button');

  btn.className = 'pickerbutton';
  btn.value = value;
  btn.title = name;
  btn.style.height = '2em';
  btn.style.padding = '0em';
  btn.name = value;
  btn.appendChild(b_ico);
  
  var open = "<ff " + value + ">";
  var close ="<\/ff>";
  var sample = name + " Fontfamily";

  eval("btn.onclick = function(){ insertTags( '"
    + jsEscape('wiki__text') + "','"
    + jsEscape(open) + "','"
    + jsEscape(close) + "','"
    + jsEscape(sample) + "'); return false; } "
  );

  return(btn);

}

function plugin_fontfamily_toolbar_picker() {

                  // Check that we are editing the page - is there a better way to do this?
                  var edbtn = document.getElementById('edbtn__save');
                  if (!edbtn) return;
                  
                  var toolbar = document.getElementById('tool__bar');
                  if (!toolbar) return;

  // Create the picker button
  var p_id = 'picker_plugin_fontfamily';	// picker id that we're creating
  var p_ico = document.createElement('img');
  p_ico.src = DOKU_BASE + 'lib/plugins/fontfamily/images/toolbar_icon.png';
  var p_btn = document.createElement('button');
  p_btn.className = 'toolbutton';
  p_btn.title = 'Fontfamily';
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
  for( var ff in plugin_fontfamily ) {
    if (!isFunction(plugin_fontfamily[ff])) {
      var btn = plugin_fontfamily_make_fontfamily_button(ff,
          plugin_fontfamily[ff]);
      picker.appendChild(btn);
    }
  }
  


  var body = document.getElementsByTagName('body')[0];
  body.appendChild(picker);	// attach the picker <div> to the page body
  toolbar.appendChild(p_btn);	// attach the picker button to the toolbar
}

addInitEvent(plugin_fontfamily_toolbar_picker);

//Setup VIM: ex: et ts=2 sw=2 enc=utf-8 :
