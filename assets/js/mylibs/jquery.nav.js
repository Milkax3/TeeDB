//nav li.large:hover{ width:306px }
var timeOut    = 500;
var closeTimer = 0;
var menuItem = 0;
var menuMain = 0;
var focus = 0;
var outside = 0;

function setFocus(){
	focus = 1;
}

function navOpen(){ 
	navCancel();
   	navClose();   	
   	
	$(this).find('input').focus(function(){ if(!focus){ focus = 1;  } });
	$(this).find('input').blur(function(){ 
		if(focus){ 
			focus = 0; 
			if(outside){
				outside = 0;
				navTimer();
			}
		}
	});

   	//menuMain = $(this).css('width', '306px');
   	menuItem = $(this).find('ul').css('visibility', 'visible');
   	$(this).find('ul').css('width', '');
}

function navClose(){ 
	if(menuItem) {
		menuItem.css('visibility', 'hidden');
		menuItem.css('width', '0px');
		//menuMain.css('width', '');
	}
}

function navTimer(){  
	if(!focus){
		closeTimer = window.setTimeout(navClose, timeOut);	
	}else if(!outside){
		outside = 1;
	}
}

function navCancel(){  	
	if(outside){
		outside = 0;
	}
	
	if(closeTimer){  
		window.clearTimeout(closeTimer);
		closeTimer = null;
   	}
}

/*document.onclick = navClose; */