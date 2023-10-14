function indexmenu_toolbar_additions() {
    var edbtn,cmenu,indx_btn,toolbar = $('tool__bar');
    if(!toolbar) return;
    edbtn = $('edbtn__save');
    if(!edbtn) return;
    indexmenu_createPicker('picker_plugin_indexmenu');
    indx_btn = indexmenu_createToolbar();
    indx_btn.onclick = function(){indexmenu_ajax('req=local','picker_plugin_indexmenu',this,true);return false;};
    toolbar.appendChild(indx_btn);
    cmenu=window.indexmenu_contextmenu;
    if(cmenu[1]) {
	window.indexmenu_contextmenu[0]=cmenu[1].concat(cmenu[0]);
    }
}

function indexmenu_createThemes(data,indx_list) {
    var checkboxes=new Array(
			     new Array('<p><strong><em>Navigation</em></strong></p>',0),
			     new Array('navbar','The tree opens at the current namespace. Good for navigation sidebars.'),
			     new Array('id#random','To be used in case of two or more navbar indexmenu trees.'),
			     new Array('<p><strong><em>Sort</em></strong></p>',0),
			     new Array('tsort','Sort by title.'),
			     new Array('dsort','Sort by date.'),
			     new Array('msort','Sort by meta tag.'),
			     new Array('nsort','Sort namespaces.'),
			     new Array('<p><strong><em>Performance</em></strong></p>',0),
			     new Array('max#2','How many levels to render with ajax when a node is opened.'),
			     new Array('maxjs#2','How many levels to render in the client browser when a node is opened.'),
			     new Array('<p><strong><em>Others</em></strong></p>',0),
			     new Array('nocookie','No cookies.'),
			     new Array('nons','Show only pages.'),
			     new Array('nopg','Show only namespaces.'),
			     new Array('noscroll','Prevent to scrolling the tree when it does not fit the container width.'),
			     new Array('notoc','Disable the toc preview feature.')
			     );

    var btn,ico,title,key,url,adata,check,f,l,fo2,l2,la,f3,l3;
    adata=data.split(',');
    check=adata.shift();
    if (check != 'indexmenu') {
	indx_list.innerHTML='No themes';
	adata=[];
    } else {
	url=adata.shift();
	url += adata.shift();
    }
    f=document.createElement('fieldset');
    l=document.createElement('legend');
    l.innerHTML='<strong>Themes</strong>';
    f.appendChild(l);
    for (key in adata) {
	btn = document.createElement('button');
	btn.className = 'pickerbutton';
	ico = document.createElement('img');
	ico.src = url+'/'+adata[key]+'/base.'+indexmenu_findExt(adata[key]);
	title = adata[key];
	btn.title=title;
	btn.appendChild(ico);
	if (title == 'default') {
	    title = '';
	} else {
	    title = '#' + title;
	}
	eval('btn.onclick = function(){indexmenu_opts("'+title+'");}');
	if (title === '') { 
	    f.insertBefore(btn,indx_list.firstChild);
	} else {    
	    f.appendChild(btn);
	}
    }
    indx_list.appendChild(f);
    fo2=document.createElement('form');
    fo2.id='indexmenu_optfrm';
    fo2.className='indexmenu_opts';
    l2=document.createElement('p');
    l2.innerHTML='<strong>Options<strong>';
    f.appendChild(l2);
    for (key in checkboxes) {
	la = document.createElement('label');
	la.innerHTML=checkboxes[key][0]+' ';
	if (checkboxes[key][1]) {
	    la.title= checkboxes[key][1];
	    btn=document.createElement('input');
	    btn.type = 'checkbox';
	    btn.name = 'check';
	    btn.title = checkboxes[key][1];
	    btn.value = checkboxes[key][0];
	    fo2.appendChild(btn);
	}
	fo2.appendChild(la);
    }
    f.appendChild(fo2);
    indx_list.appendChild(f);
    f3=f.cloneNode(false);
    l3=l.cloneNode(false);
    l3.innerHTML='<strong>Extra</strong>';
    f3.appendChild(l3);
    btn = document.createElement('button');
    btn.className = 'pickerbutton';
    ico = document.createElement('img');
    ico.src = url+'/msort.gif';
    btn.title='Insert meta sort number';
    btn.appendChild(ico);
    btn.onclick = function(){insertTags(
	'wiki__text',
	'{{indexmenu_n>',
	'}}',
	'1'
	);
	$('picker_plugin_indexmenu').style.display='none';
	return false;
    };
    f3.appendChild(btn);
    indx_list.appendChild(f3);
}

function indexmenu_createToolbar (){
    var indx_ico = document.createElement('img');
    indx_ico.src = DOKU_BASE + 'lib/plugins/indexmenu/images/indexmenu_toolbar.png';
    var indx_btn = document.createElement('button');
    indx_btn.id = 'syntax_plugin_indexmenu';
    indx_btn.className = 'toolbutton';
    indx_btn.title = 'Insert the Indexmenu tree';
    indx_btn.appendChild(indx_ico);
    return indx_btn;
}

function indexmenu_createPicker(id) {
    var indx_list = document.createElement('div');
    indx_list.className = 'picker';
    indx_list.id=id;
    indx_list.style.position = 'absolute';
    indx_list.style.display  = 'none';
    var body = document.getElementsByTagName('body')[0];
    body.appendChild(indx_list);
    return indx_list;
}

function indexmenu_opts(m) {
    var i,v = '';
    var f=$('indexmenu_optfrm');
    for (i=0; i < f.length; i++) {
	if (f[i].checked) {
	    v = v + ' ' + f[i].value;
	}
    }
    insertTags(
	       'wiki__text',
	       '{{indexmenu>',
	       '|js'+m+v+'}}',
	       '#1'
	       );
    $('picker_plugin_indexmenu').style.display='none';
    return false;
}

function indexmenu_insertTags(lnk,sep) {
    var r,l=lnk;
    if (sep) {
	r=new RegExp (sep,"g");
	l=lnk.replace(r,':');
    }
    insertTags('wiki__text','[[',']]',l);
}

indexmenu_toolbar_additions();
