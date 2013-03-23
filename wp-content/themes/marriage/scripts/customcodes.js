(function() { 
    tinymce.create('tinymce.plugins.fullcontent', {  
        init : function(ed, url) {  
            ed.addButton('fullcontent', {  
                title : 'Add a full width section',  
                image : url+'/images/sectionfull.gif',  
                onclick : function() {  
                     ed.selection.setContent('[fullcontent title=""]' + ed.selection.getContent() + '[/fullcontent]'); 
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('fullcontent', tinymce.plugins.fullcontent);
	
    tinymce.create('tinymce.plugins.halfcontent', {  
        init : function(ed, url) {  
            ed.addButton('halfcontent', {  
                title : 'Add a half width section',  
                image : url+'/images/sectionhalf.gif',  
                onclick : function() {  
                     ed.selection.setContent('[halfcontent title=""]' + ed.selection.getContent() + '[/halfcontent]'); 
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('halfcontent', tinymce.plugins.halfcontent);	
	
    tinymce.create('tinymce.plugins.twothirdscontent', {  
        init : function(ed, url) {  
            ed.addButton('twothirdscontent', {  
                title : 'Add a 2/3 width section',  
                image : url+'/images/section2third.gif',  
                onclick : function() {  
                     ed.selection.setContent('[twothirdscontent title=""]' + ed.selection.getContent() + '[/twothirdscontent]'); 
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('twothirdscontent', tinymce.plugins.twothirdscontent);	
		  
    tinymce.create('tinymce.plugins.onethirdscontent', {  
        init : function(ed, url) {  
            ed.addButton('onethirdscontent', {  
                title : 'Add a 1/3 width section',  
                image : url+'/images/sectionthird.gif',  
                onclick : function() {  
                     ed.selection.setContent('[onethirdscontent title=""]' + ed.selection.getContent() + '[/onethirdscontent]'); 
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('onethirdscontent', tinymce.plugins.onethirdscontent);
	
	
    tinymce.create('tinymce.plugins.quartercontent', {  
        init : function(ed, url) {  
            ed.addButton('quartercontent', {  
                title : 'Add a 1/4 width section',  
                image : url+'/images/sectionfourth.gif',  
                onclick : function() {  
                     ed.selection.setContent('[quartercontent title=""]' + ed.selection.getContent() + '[/quartercontent]'); 
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('quartercontent', tinymce.plugins.quartercontent);
	
    tinymce.create('tinymce.plugins.video', {  
        init : function(ed, url) {  
            ed.addButton('video', {  
                title : 'Add a flexible video',  
                image : url+'/images/videosection.gif',  
                onclick : function() {  
                     ed.selection.setContent('[video]' + ed.selection.getContent() + '[/video]'); 
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('video', tinymce.plugins.video);
	
    tinymce.create('tinymce.plugins.icon', {  
        init : function(ed, url) {  
            ed.addButton('icon', {  
                title : 'Add a block icon',  
                image : url+'/images/iconblock.gif',  
                onclick : function() {  
                     ed.selection.setContent('[icon title="" iconurl="" iconlink=""]' + ed.selection.getContent() + '[/icon]'); 
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        },  
    });  
    tinymce.PluginManager.add('icon', tinymce.plugins.icon);

})();