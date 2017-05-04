//////////////////////////////////////////////////////////////////
// Add One_half button
//////////////////////////////////////////////////////////////////
(function() {
    tinymce.create('tinymce.plugins.one_half', {
        init : function(ed, url) {
            ed.addButton('one_half', {
                title : 'Add a one_half column',
                image : url+'/images/btn_1.png',
                onclick : function() {
                     ed.selection.setContent('[one_half last="no"]...[/one_half]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_half', tinymce.plugins.one_half);
})();

//////////////////////////////////////////////////////////////////
// Add one_third button
//////////////////////////////////////////////////////////////////
(function() {
    tinymce.create('tinymce.plugins.one_third', {
        init : function(ed, url) {
            ed.addButton('one_third', {
                title : 'Add a one_third column',
                image : url+'/images/btn_2.png',
                onclick : function() {
                     ed.selection.setContent('[one_third last="no"]...[/one_third]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_third', tinymce.plugins.one_third);
})();

//////////////////////////////////////////////////////////////////
// Add one_fourth button
//////////////////////////////////////////////////////////////////
(function() {
    tinymce.create('tinymce.plugins.one_fourth', {
        init : function(ed, url) {
            ed.addButton('one_fourth', {
                title : 'Add a one_fourth column',
                image : url+'/images/btn_3.png',
                onclick : function() {
                    ed.selection.setContent('[one_fourth last="no"]...[/one_fourth]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_fourth', tinymce.plugins.one_fourth);
})();

//////////////////////////////////////////////////////////////////
// Add one_sixth button
//////////////////////////////////////////////////////////////////
(function() {
    tinymce.create('tinymce.plugins.one_sixth', {
        init : function(ed, url) {
            ed.addButton('one_sixth', {
                title : 'Add a one_sixth column',
                image : url+'/images/btn_5.png',
                onclick : function() {
                    ed.selection.setContent('[one_sixth last="no"]...[/one_sixth]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_sixth', tinymce.plugins.one_sixth);
})();

//////////////////////////////////////////////////////////////////
// Add two_third button
//////////////////////////////////////////////////////////////////
(function() {
    tinymce.create('tinymce.plugins.two_third', {
        init : function(ed, url) {
            ed.addButton('two_third', {
                title : 'Add a two_third column',
                image : url+'/images/btn_6.png',
                onclick : function() {
                    ed.selection.setContent('[two_third last="no"]...[/two_third]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('two_third', tinymce.plugins.two_third);
})();

//////////////////////////////////////////////////////////////////
// Add three_fourth button
//////////////////////////////////////////////////////////////////
(function() {
    tinymce.create('tinymce.plugins.three_fourth', {
        init : function(ed, url) {
            ed.addButton('three_fourth', {
                title : 'Add a three_fourth column',
                image : url+'/images/btn_8.png',
                onclick : function() {
                    ed.selection.setContent('[three_fourth last="no"]...[/three_fourth]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('three_fourth', tinymce.plugins.three_fourth);
})();

//////////////////////////////////////////////////////////////////
// Add five_sixth button
//////////////////////////////////////////////////////////////////
(function() {
    tinymce.create('tinymce.plugins.five_sixth', {
        init : function(ed, url) {
            ed.addButton('five_sixth', {
                title : 'Add a five_sixth column',
                image : url+'/images/btn_11.png',
                onclick : function() {
                    ed.selection.setContent('[five_sixth last="no"]...[/five_sixth]');

                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('five_sixth', tinymce.plugins.five_sixth);
})();