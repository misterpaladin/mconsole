function BladeHelper(e){this.helper=e,this.searchRequest=null,this.searchCaller=null,this.classes={buttons:{toggle:".toggle-blade-helper, .blade-helper .helper-close.blade-helper-close",toggleSearch:".blade-helper-search .helper-close.blade-helper-search-close",back:".blade-back",copy:".blade-copy"},containers:{item:".blade-item"}},this.selectors={list:$(this.helper.find(".list")),inputList:$(this.helper.find(".input-list")),input:$(this.helper.find(".blade-input")),search:$(this.helper.find(".blade-helper-search")),searchResults:$(this.helper.find(".blade-search-results"))},this.directives={image:"@image('{id}', [{arguments}])",variable:{withArgs:"@variable('{key}', [{arguments}])",withoutArgs:"@variable('{key}')"}},this.init(),this.initSearch()}BladeHelper.prototype.init=function(){this.helper.draggable({addClasses:!1,stop:function(e,t){$(t.helper).css({height:"auto"})}}),$(document).on("click",this.classes.buttons.toggle,this.toggle.bind(this)),$(document).on("click",this.classes.buttons.back,this.back.bind(this)),$(document).on("click",this.classes.buttons.toggleSearch,this.toggleSearch.bind(this));var e=this;new Clipboard(e.classes.buttons.copy,{text:function(t){return notification("info",trans("blade-helper-copied"),null,{timeOut:1e3,extendedTimeOut:1e3}),e.makeDirective()}}),this.helper.find(this.classes.containers.item).on("click",this.select.bind(this))},BladeHelper.prototype.select=function(e){this.selectors.list.hide();var t=$(e.target).data("key"),s=$(e.target).data("value"),i=s.match(/\$\w+/gi);i&&(i=this.removeDollarChar(i)),this.form(t,i)},BladeHelper.prototype.toggle=function(e){this.helper.is(":visible")?this.helper.fadeOut(250):(this.helper.css("top",($(window).height()-this.helper.outerHeight())/2+"px"),this.helper.css("left",($(window).width()-this.helper.outerWidth())/2+"px"),this.helper.fadeIn(250))},BladeHelper.prototype.form=function(e,t){var s=this.selectors.input,i=this.selectors.inputList;if(t){t=t.reverse();for(var a in t){var r=$('<div class="form-group"><div class="input-group input-group-sm"><input class="form-control variable" name="'+t[a]+'" placeholder="'+t[a]+'" type="text"><span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-search-plus"></i></button></span></div></div>');r.on("keyup","input",this.code.bind(this)),r.on("click","button",this.toggleSearch.bind(this)),r.prependTo(i)}}e=$('<div class="form-group"><strong>'+e+"</strong></div>"),e.prependTo(i),s.show(),this.code()},BladeHelper.prototype.back=function(){this.selectors.inputList.html(""),this.selectors.input.hide(),this.selectors.list.show(),this.selectors.search.fadeOut(250)},BladeHelper.prototype.code=function(){var e=this.makeDirective();this.helper.find(".code textarea").length>0?this.helper.find(".code textarea").text(e):this.selectors.inputList.append($('<div class="form-group code"><label>'+trans("blade-helper-code")+'</label><textarea class="form-control" readonly>'+e+"</textarea></div>"))},BladeHelper.prototype.makeDirective=function(){var e=this.helper.find(".form-group input.variable"),t=e.length>0?this.directives.variable.withArgs:this.directives.variable.withoutArgs,s=this.selectors.input.find("strong").text();if(t=t.replace("{key}",s),e.length>0){var i=[];e.each(function(e,t){i.push("'"+$(t).attr("name")+"' => '"+$(t).val()+"'")}),t=t.replace("{arguments}",i.join(", "))}return t},BladeHelper.prototype.removeDollarChar=function(e){for(var t in e)e[t]=e[t].replace("$","");return e},BladeHelper.prototype.initSearch=function(){this.selectors.search.find('input[name="search"]').on("keyup",this.startSearch.bind(this)),this.selectors.searchResults.on("click",".file-copy",this.insertPath.bind(this))},BladeHelper.prototype.toggleSearch=function(e){return $(e.target).hasClass("helper-close")?(this.selectors.search.fadeOut(250),this.searchCaller=null,!1):void(e.target==this.searchCaller?(this.selectors.search.fadeOut(250),this.searchCaller=null):(this.searchCaller=e.target,this.prepareSearch(),this.selectors.search.fadeIn(250),this.selectors.search.find('input[name="search"]').focus()))},BladeHelper.prototype.prepareSearch=function(){this.selectors.search.find('input[name="search"]').val(""),this.selectors.searchResults.html("")},BladeHelper.prototype.startSearch=function(e){this.searchRequest&&this.searchRequest.abort(),this.selectors.search.find("i.fa-spin").addClass("fa-spinner"),this.selectors.searchResults.html(""),this.searchRequest=$.ajax({type:"GET",url:"/mconsole/api/search/uploads?query="+e.target.value}),this.searchRequest.success(this.handleSearchResults.bind(this))},BladeHelper.prototype.handleSearchResults=function(e){if(this.selectors.search.find("i.fa-spin").removeClass("fa-spinner"),e)for(var t in e){var s=e[t].preview.length>0,i=$('<li class="media"><a class="pull-left" href="javascript:;" style="width: 42px; height: 32px;"></a><div class="media-body"><div><strong></strong></div></div></li>');if(s){var a=$('<img style="width: 32px; height: 32px;" class="media-object" src="'+e[t].preview+'" />');a.appendTo(i.find("a"))}if(i.find("strong").text(e[t].title),e[t].original){var r=$('<div class="btn btn-xs default file-copy" data-path="'+e[t].original+'">Original</div>');r.appendTo(i.find(".media-body"))}if(e[t].copies)for(var l in e[t].copies){var h=e[t].copies[l],o=[e[t].basepath,e[t].path,h.path,e[t].filepath].join("/"),n=$('<div class="btn btn-xs default file-copy" data-path="'+o+'">'+h.path+" "+h.width+"x"+h.height+"</div>");n.appendTo(i.find(".media-body"))}i.appendTo(this.selectors.searchResults)}},BladeHelper.prototype.insertPath=function(e){$(this.searchCaller).closest(".form-group").find("input").val($(e.target).data("path")),this.code()},$(function(){$(".blade-helper").length>0&&new BladeHelper($(".blade-helper"))});