// JavaScript Document



(function() {
    // Creates a new plugin class and a custom listbox
    tinymce.create('tinymce.plugins.td_article_block', {
        createControl: function(n, cm) {
            switch (n) {
                case 'td_article_block':
                    var mlb = cm.createListBox('td_article_block', {
                        title : 'Article blocks',
                        onselect : function(v) {
                            
                            
                            switch(v) {
                                case '[slide]':
                                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[block_slide category="YOUR_CATEGORY" filter="" number="5"][/block_slide]');
                                    break;
                                
                                case '[block_1]':
                                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[block_1 category="YOUR_CATEGORY_NAME" category2="YOUR_OTHER_CATEGORY_NAME" filter="" number="5"][/block_1]');
                                    break;
                                    
                                case '[block_2]':
                                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[block_2 category="YOUR_CATEGORY" filter="" number="5"][/block_2]');
                                    break;
                                    
                                    
                                case '[block_gallery]':
                                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[block_gallery number="10" category="YOUR_CATEGORY"][/block_gallery]');
                                    break;
  
  
                            }
                        }
                        
                        
                    });
                    
                    
                    // Add some values to the list box
                    mlb.add('[slide]', '[slide]');
                    mlb.add('[block_1]', '[block_1]');
                    mlb.add('[block_2]', '[block_2]');
                    mlb.add('[block_gallery]', '[block_gallery]');
                   
                    

                    
                    // Return the new listbox instance
                    return mlb;
            }
            return null;
        }
    });
    tinymce.PluginManager.add('td_article_block', tinymce.plugins.td_article_block);
})();