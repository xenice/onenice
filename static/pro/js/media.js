jQuery(function($) {
    $(document).ready(function(){
        $('#add-resource').click(function(){
            var reg = new RegExp('\\[(\\[?)(data)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)\\[\\/\\2\\])?)(\\]?)');
            if(!reg.test($('#content').val())){
                wp.media.editor.insert(default_shotcode);
                //wp.media.editor.insert("[data\nprice = ''\nargs= ''\ndownload=''\nbuy=''\ndemo=''\ncontact=''\nimage=''\n\ntitle_1=''\nprice_1=''\nimage_1=''\n  url_1=''\n\ntitle_2=''\nprice_2=''\nimage_2=''\n  url_2=''\n\ntitle_3=''\nprice_3=''\nimage_3=''\n  url_3=''\n\ntitle_4=''\nprice_4=''\nimage_4=''\n  url_4=''\n/]\n");
            }
        });
    });
 
    function open_media_window(){
        if (this.window === undefined) {
            this.window = wp.media({
                    title: 'Insert a media',
                    library: {type: 'application'},
                    multiple: false,
                    button: {text: 'Insert'}
                });
     
            var self = this; // Needed to retrieve our variable in the anonymous function below
            this.window.on('select', function() {
                var first = self.window.state().get('selection').first().toJSON();
                var size = renderSize(first.filesizeInBytes);
                size=size.replace(/\s+/g,"");
                console.log(first);
                wp.media.editor.insert('[xn_file id="' + first.id + '" url="' + first.url + '" title="' + first.title + '" size="' + size + '" type="' + first.subtype + '"]' );
            });
        }
     
        this.window.open();
        return false;
    }
    
    function renderSize(value){
        if(null==value||value==''){
            return "0 Bytes";
        }
        var unitArr = new Array("Bytes","KB","MB","GB","TB","PB","EB","ZB","YB");
        var index=0;
        var srcsize = parseFloat(value);
        index=Math.floor(Math.log(srcsize)/Math.log(1024));
        var size =srcsize/Math.pow(1024,index);
        size=size.toFixed(2);//保留的小数位数
        return size+unitArr[index];
    }
});