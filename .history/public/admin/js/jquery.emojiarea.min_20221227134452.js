!function($,f,b){var h=["p","div","pre","form"],i=[8,9,17,18,37,38,39,40,91,46];$.emojiarea={assetsPath:"",spriteSheetPath:"",blankGifPath:"",iconSize:25,icons:{}};var j=":joy:,:kissing_heart:,:heart:,:heart_eyes:,:blush:,:grin:,:+1:,:relaxed:,:pensive:,:smile:,:sob:,:kiss:,:unamused:,:flushed:,:stuck_out_tongue_winking_eye:,:see_no_evil:,:wink:,:smiley:,:cry:,:stuck_out_tongue_closed_eyes:,:scream:,:rage:,:smirk:,:disappointed:,:sweat_smile:,:kissing_closed_eyes:,:speak_no_evil:,:relieved:,:grinning:,:yum:,:laughing:,:ok_hand:,:neutral_face:,:confused:".split(",");$.fn.emojiarea=function(a){return a=$.extend({},a),this.each(function(){var d=$(this);if("contentEditable"in b.body&& !1!==a.wysiwyg){var c=getGuid();new e(d,c,$.extend({},a))}else{var c=getGuid();new g(d,c,a)}d.attr({"data-emojiable":"converted","data-id":c,"data-type":"original-input"})})};var a={};a.restoreSelection=f.getSelection?function(b){var c=f.getSelection();c.removeAllRanges();for(var a=0,d=b.length;a<d;++a)c.addRange(b[a])}:b.selection&&b.selection.createRange?function(a){a&&a.select()}:void 0,a.saveSelection=f.getSelection?function(){var a=f.getSelection(),c=[];if(a.rangeCount)for(var b=0,d=a.rangeCount;b<d;++b)c.push(a.getRangeAt(b));return c}:b.selection&&b.selection.createRange?function(){var a=b.selection;return"none"!==a.type.toLowerCase()?a.createRange():null}:void 0,a.replaceSelection=f.getSelection?function(a){var c,d=f.getSelection(),e="string"==typeof a?b.createTextNode(a):a;d.getRangeAt&&d.rangeCount&&((c=d.getRangeAt(0)).deleteContents(),c.insertNode(e),c.setStart(e,0),f.setTimeout(function(){(c=b.createRange()).setStartAfter(e),c.collapse(!0),d.removeAllRanges(),d.addRange(c)},0))}:b.selection&&b.selection.createRange?function(a){var c=b.selection.createRange();"string"==typeof a?c.text=a:c.pasteHTML(a.outerHTML)}:void 0,a.insertAtCursor=function(c,a){c=" "+c;var d,e,f=a.value;void 0!==a.selectionStart&& void 0!==a.selectionEnd?(d=a.selectionStart,a.selectionEnd,a.value=f.substring(0,d)+c+f.substring(a.selectionEnd),a.selectionStart=a.selectionEnd=d+c.length):void 0!==b.selection&& void 0!==b.selection.createRange&&(a.focus(),(e=b.selection.createRange()).text=c,e.select())},a.extend=function(a,b){if(void 0!==a&&a||(a={}),"object"==typeof b)for(var c in b)b.hasOwnProperty(c)&&(a[c]=b[c]);return a},a.escapeRegex=function(a){return(a+"").replace(/([.?*+^$[\]\\(){}|-])/g,"\\$1")},a.htmlEntities=function(a){return String(a).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;")},a.emojiInserted=function(a,b){ConfigStorage.get("emojis_recent",function(b){var c=(b=b||j||[]).indexOf(a);if(!c)return!1;-1!=c&&b.splice(c,1),b.unshift(a),b.length>42&&(b=b.slice(42)),ConfigStorage.set({emojis_recent:b})})};var c=function(){};c.prototype.setup=function(){var a=this;this.$editor.on("focus",function(){a.hasFocus=!0}),this.$editor.on("blur",function(){a.hasFocus=!1}),a.emojiMenu=new d(a),this.setupButton()},c.prototype.setupButton=function(){var b=this,a=$("[data-id="+this.id+"][data-type=picker]");a.on("click",function(a){b.emojiMenu.show(b)}),this.$button=a,this.$dontHideOnClick="emoji-picker"},c.createIcon=function(c,f){var e=c[0],g=c[1],h=c[2],i=c[3],j=$.emojiarea.spriteSheetPath?$.emojiarea.spriteSheetPath:$.emojiarea.assetsPath+"/emoji_spritesheet_!.png",k=$.emojiarea.blankGifPath?$.emojiarea.blankGifPath:$.emojiarea.assetsPath+"/blank.gif",b=f&&Config.Mobile?26:$.emojiarea.iconSize,l=Config.EmojiCategorySpritesheetDimens[e][1]*b,m=Config.EmojiCategorySpritesheetDimens[e][0]*b,d="display:inline-block;";return d+="width:"+b+"px;",d+="height:"+b+"px;",d+="background:url('"+j.replace("!",e)+"') "+ -(b*h)+"px "+ -(b*g)+"px no-repeat;",'<img src="'+k+'" class="img" style="'+(d+="background-size:"+l+"px "+m+"px;")+'" alt="'+a.htmlEntities(i)+'">'},$.emojiarea.createIcon=c.createIcon;var g=function(a,b,c){this.options=c,this.$textarea=a,this.$editor=a,this.id=b,this.setup()};g.prototype.insert=function(b){$.emojiarea.icons.hasOwnProperty(b)&&(a.insertAtCursor(b,this.$textarea[0]),a.emojiInserted(b,this.menu),this.$textarea.trigger("change"))},g.prototype.val=function(){return"\n"==this.$textarea?"":this.$textarea.val()},a.extend(g.prototype,c.prototype);var e=function(c,d,e){var h=this;this.options=e||{},"unicode"===$(c).attr("data-emoji-input")?this.options.inputMethod="unicode":this.options.inputMethod="image",this.id=d,this.$textarea=c,this.emojiPopup=e.emojiPopup,this.$editor=$("<div>").addClass("emoji-wysiwyg-editor").addClass($(c)[0].className),this.$editor.data("self",this),c.attr("maxlength")&&this.$editor.attr("maxlength",c.attr("maxlength")),this.$editor.height(c.outerHeight()),this.emojiPopup.appendUnicodeAsImageToElement(this.$editor,c.val()),this.$editor.attr({"data-id":d,"data-type":"input",placeholder:c.attr("placeholder"),contenteditable:"true"});var g="blur change";this.options.norealTime||(g+=" keyup"),this.$editor.on(g,function(a){return h.onChange.apply(h,[a])}),this.$editor.on("mousedown focus",function(){b.execCommand("enableObjectResizing",!1,!1)}),this.$editor.on("blur",function(){b.execCommand("enableObjectResizing",!0,!0)});var j=this.$editor;this.$editor.on("change keydown keyup resize scroll",function(a){-1==i.indexOf(a.which)&&!((a.ctrlKey||a.metaKey)&&65==a.which)&&!((a.ctrlKey||a.metaKey)&&67==a.which)&&j.text().length+j.find("img").length>=j.attr("maxlength")&&a.preventDefault(),h.updateBodyPadding(j)}),this.$editor.on("paste",function(c){c.preventDefault();var a,d=j.attr("maxlength")-(j.text().length+j.find("img").length);(c.originalEvent||c).clipboardData?(a=(c.originalEvent||c).clipboardData.getData("text/plain"),h.options.onPaste&&(a=h.options.onPaste(a)),d<a.length&&(a=a.substring(0,d)),b.execCommand("insertText",!1,a)):f.clipboardData&&(a=f.clipboardData.getData("Text"),h.options.onPaste&&(a=h.options.onPaste(a)),d<a.length&&(a=a.substring(0,d)),b.selection.createRange().pasteHTML(a)),j.scrollTop(j[0].scrollHeight)}),c.after("<i class='emoji-picker-icon emoji-picker "+this.options.popupButtonClasses+"' data-id='"+d+"' data-type='picker'></i>"),c.hide().after(this.$editor),this.setup(),$(b.body).on("mousedown",function(){h.hasFocus&&(h.selection=a.saveSelection())})};e.prototype.updateBodyPadding=function(a){var b=$("[data-id="+this.id+"][data-type=picker]");$(a).hasScrollbar()?(b.hasClass("parent-has-scroll")||b.addClass("parent-has-scroll"),$(a).hasClass("parent-has-scroll")||$(a).addClass("parent-has-scroll")):(b.hasClass("parent-has-scroll")&&b.removeClass("parent-has-scroll"),$(a).hasClass("parent-has-scroll")&&$(a).removeClass("parent-has-scroll"))},e.prototype.onChange=function(b){var a=new CustomEvent("input",{bubbles:!0});this.$textarea.val(this.val())[0].dispatchEvent(a)},e.prototype.insert=function(b){var d="";if("unicode"==this.options.inputMethod)d=this.emojiPopup.colonToUnicode(b);else{var e=$(c.createIcon($.emojiarea.icons[b]));e[0].attachEvent&&e[0].attachEvent("onresizestart",function(a){a.returnValue=!1},!1),d=e[0]}this.$editor.trigger("focus"),this.selection&&a.restoreSelection(this.selection);try{a.replaceSelection(d)}catch(f){}a.emojiInserted(b,this.menu),this.onChange()},e.prototype.val=function(){for(var c=[],d=[],e=this.emojiPopup,f=function(){c.push(d.join("")),d=[]},g=function(a){if(3===a.nodeType)d.push(a.nodeValue);else if(1===a.nodeType){var b=a.tagName.toLowerCase(),e=-1!==h.indexOf(b);if(e&&d.length&&f(),"img"===b){var i=a.getAttribute("alt")||"";i&&d.push(i);return}"br"===b&&f();for(var j=a.childNodes,c=0;c<j.length;c++)g(j[c]);e&&d.length&&f()}},b=this.$editor[0].childNodes,a=0;a<b.length;a++)g(b[a]);d.length&&f();var i=c.join("\n");return e.colonToUnicode(i)},a.extend(e.prototype,c.prototype),jQuery.fn.hasScrollbar=function(){var a=this.get(0).scrollHeight;return this.outerHeight()<a};var d=function(c){var e=this;e.id=c.id;var a=$(b.body);$(f),this.visible=!1,this.emojiarea=c,d.menuZIndex=5e3,this.$menu=$("<div>"),this.$menu.addClass("emoji-menu"),this.$menu.attr("data-id",e.id),this.$menu.attr("data-type","menu"),this.$menu.hide(),this.$itemsTailWrap=$('<div class="emoji-items-wrap1"></div>').appendTo(this.$menu),this.$categoryTabs=$('<table class="emoji-menu-tabs"><tr><td><a class="emoji-menu-tab icon-recent" ></a></td><td><a class="emoji-menu-tab icon-smile" ></a></td><td><a class="emoji-menu-tab icon-flower"></a></td><td><a class="emoji-menu-tab icon-bell"></a></td><td><a class="emoji-menu-tab icon-car"></a></td><td><a class="emoji-menu-tab icon-grid"></a></td></tr></table>').appendTo(this.$itemsTailWrap),this.$itemsWrap=$('<div class="emoji-items-wrap mobile_scrollable_wrap"></div>').appendTo(this.$itemsTailWrap),this.$items=$('<div class="emoji-items">').appendTo(this.$itemsWrap),this.emojiarea.$editor.after(this.$menu),a.on("keydown",function(a){(27===a.keyCode||9===a.keyCode)&&e.hide()}),a.on("message_send",function(a){e.hide()}),a.on("mouseup",function(b){var a=(b=b.originalEvent||b).target||f;if(!$(a).hasClass(e.emojiarea.$dontHideOnClick)){for(;a&&a!=f;)if((a=a.parentNode)==e.$menu[0]||e.emojiarea&&a==e.emojiarea.$button[0])return;e.hide()}}),this.$menu.on("mouseup","a",function(a){return a.stopPropagation(),!1}),this.$menu.on("click","a",function(a){if(e.emojiarea.updateBodyPadding(e.emojiarea.$editor),$(this).hasClass("emoji-menu-tab"))return e.getTabIndex(this)!==e.currentCategory&&e.selectCategory(e.getTabIndex(this)),!1;var b=$(".label",$(this)).text();return f.setTimeout(function(){e.onItemSelected(b),(a.ctrlKey||a.metaKey)&&e.hide()},0),a.stopPropagation(),!1}),this.selectCategory(0)};d.prototype.getTabIndex=function(a){return this.$categoryTabs.find(".emoji-menu-tab").index(a)},d.prototype.selectCategory=function(a){this.$categoryTabs.find(".emoji-menu-tab").each(function(b){b===a?this.className+="-selected":this.className=this.className.replace("-selected","")}),this.currentCategory=a,this.load(a)},d.prototype.onItemSelected=function(a){this.emojiarea.$editor.text().length+this.emojiarea.$editor.find("img").length>=this.emojiarea.$editor.attr("maxlength")||this.emojiarea.insert(a)},d.prototype.load=function(f){var g=[],d=$.emojiarea.icons,e=$.emojiarea.assetsPath,i=this;e.length&&"/"!==e.charAt(e.length-1)&&(e+="/");var h=function(){i.$items.html(g.join(""))};if(f>0){for(var b in d)d.hasOwnProperty(b)&&d[b][0]===f-1&&g.push('<a href="javascript:void(0)" title="'+a.htmlEntities(b)+'">'+c.createIcon(d[b],!0)+'<span class="label">'+a.htmlEntities(b)+"</span></a>");h()}else ConfigStorage.get("emojis_recent",function(b){var e,f;for(f=0,b=b||j||[];f<b.length;f++)d[e=b[f]]&&g.push('<a href="javascript:void(0)" title="'+a.htmlEntities(e)+'">'+c.createIcon(d[e],!0)+'<span class="label">'+a.htmlEntities(e)+"</span></a>");h()})},d.prototype.hide=function(a){this.visible=!1,this.$menu.hide("fast")},d.prototype.show=function(a){if(this.visible)return this.hide();$(this.$menu).css("z-index",++d.menuZIndex),this.$menu.show("fast"),this.currentCategory||this.load(0),this.visible=!0}}(jQuery,window,document)