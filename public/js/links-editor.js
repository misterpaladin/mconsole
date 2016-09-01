var LinksEditor=function(t){self=this,self.input=t,self.links=t.val().length>0?JSON.parse(t.val()):[],self.init()};LinksEditor.prototype.factory={},LinksEditor.prototype.generateItem=function(t){var t=self.factory.linkItem(t);return self.factory.linkItemDOM(t)},LinksEditor.prototype.init=function(){this.input.parents(".form-group").removeClass("hide");var t=$('<div class="links-editor-items"></div>'),e=$('<div class="form-group"><div class="btn btn-sm blue form-control">+</div></div>');e.on("click",function(){t.append(self.generateItem())});for(var i in self.links)t.append(self.generateItem(self.links[i]));e.insertAfter(self.input),t.insertAfter(self.input),t.sortable({axis:"y",handle:".drag",stop:self.handleLinksChange}),self.container=t},LinksEditor.prototype.handleLinksChange=function(){$(this).hasClass("remove")&&$(this).closest(".links-editor-item").remove();var t=$(self.container).find(".links-editor-item"),e=[];t.length>0&&t.map(function(t,i){var n={id:$(i).data("id"),title:$(i).find("input").eq(0).val(),url:$(i).find("input").eq(1).val(),order:t,enabled:$(i).find('input[type="checkbox"]:checked').length>0};n.title&&n.url&&e.push(n)}),self.input.val(JSON.stringify(e))},LinksEditor.prototype.factory.linkItem=function(t){return t?t:{id:"",title:"",url:"",order:"",enabled:1}},LinksEditor.prototype.factory.linkItemDOM=function(t){var e={title:jstrans("links-editor-title"),url:jstrans("links-editor-url"),enabled:jstrans("links-editor-enabled")},i=$('<div class="ui-state-default links-editor-item" data-id="'+t.id+'">\t\t<input class="form-control input-sm" placeholder="'+e.title+'" type="text" value="'+t.title+'">\t\t<div class="input-icon input-icon-sm"><i class="fa fa-link"></i><input class="form-control input-sm" placeholder="'+e.url+'" type="text" value="'+t.url+'"></div>\t\t<div class="btn btn-xs blue drag"><i class="fa fa-bars"></i></div>\t\t<div class="btn btn-xs btn-danger remove"><i class="fa fa-trash"></i></div>\t\t<label class="checkbox-inline"><input type="checkbox" value="1"> '+e.enabled+" </label>\t</div>");return 1==t.enabled&&i.find('input[type="checkbox"]').prop("checked","checked"),i.find("input").on("keyup click",self.handleLinksChange),i.find(".remove").on("click",self.handleLinksChange),i},$.fn.loadLinksEditor=function(){new LinksEditor(this)},$(document).ready(function(){var t=".links-editor";$(t).length>0&&$(t).map(function(){console.log($(this)),$(this).loadLinksEditor()})});