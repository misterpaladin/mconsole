var Variables=function(a){this.container=a,this.add=$(".add-variable"),this.submit=$(".submit");new Clipboard(".copy-variable",{text:function(a){var e=$(a).hasClass("multiline"),i=$(a).closest(".row"),t=i.find("input").eq(0).val(),r=i.find("textarea").val(),n=r.match(/\$\w+/gi);if(!n)return"@variable('"+t+"')";var l="@variable('"+t+"', [";for(var s in n){var o=n[s];o=e?o.replace("$","\r\n	'"):0==s?o.replace("$","'"):o.replace("$"," '"),l=l+o+"' => ''",(s<n.length-1||e)&&(l+=",")}return l+=e?"\r\n])":"])"}});this.toggleSubmit(),this.container.on("click",".remove-variable",this.removeVariable.bind(this)),this.add.on("click",this.appendVariable.bind(this))};Variables.prototype.appendVariable=function(){var a=this.container.find(".row").length+1,e=$(".variables-template .row").clone();for(var i in e.find("input, textarea")){var t=e.find("input, textarea").eq(i);t.attr("name","variables["+a+"]["+t.data("name")+"]")}this.container.append(e),this.toggleSubmit()},Variables.prototype.removeVariable=function(a){$(a.target).closest(".row").remove()},Variables.prototype.toggleSubmit=function(){this.container.find(".row").length>0?this.submit.removeClass("hide"):this.submit.addClass("hide")},$(function(){var a=$(".variables-list");if(a.length>0){new Variables(a)}});