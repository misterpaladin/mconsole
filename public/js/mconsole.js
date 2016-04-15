var Mconsole=function(){this.initPopovers(),this.notifications={badge:$(".notifications-count"),container:$(".notifications-container"),items:0},this.search={form:$(".search-form"),results:$(".search-results"),icon:$(".search-form").find(".submit i"),ajax:null,data:[]},this.search.form.on("submit",function(){return!1}),$(document).on("click",function(){this.search.form.hasClass("open")&&this.search.data.length>0?this.search.results.show():this.search.results.hide()}.bind(this)),this.search.results.on("click",".search-result-item",function(){window.location.href=$(this).find("a").prop("href")}),this.search.form.on("keyup",this.handleSearch.bind(this)),this.notifications.container.on("click",function(i){if("LI"==$(i.target).prop("nodeName"))var s=$(i.target);else var s=$(i.target).closest("li");var t=s.data("id");s.remove();var a=this.notifications.badge.text(),e=0==a?0:a-1;this.notifications.badge.text(e),$.get("/mconsole/api/notifications/"+t+"/seen")}.bind(this));var i=this;i.getNotifications(),setInterval(function(){i.getNotifications()},1e4)};Mconsole.prototype.initPopovers=function(){$(function(){$(".popovers").popover()})},Mconsole.prototype.handleSearch=function(){return this.search.ajax&&this.search.ajax.abort(),0==this.search.form.find("input").val().length?(this.search.results.children().remove(),this.search.results.hide(),void(this.search.data=[])):void(this.search.form.find("input").val().length<3||(this.search.icon.removeClass("icon-magnifier").addClass("fa fa-spin fa-spinner"),this.search.ajax=$.ajax({method:"GET",url:"/mconsole/api/search",data:this.search.form.serialize()}),this.search.ajax.success(this.handleSearchResults.bind(this))))},Mconsole.prototype.handleSearchResults=function(i){if(this.search.data=i,this.search.results.children().remove(),i.length>0){for(var s in i){var t=i[s].icon?'<i class="fa fa-'+i[s].icon+'"></i> ':"",a=$('<li class="search-result-item"><a href="'+i[s].link+'"><span class="details">'+t+i[s].title+"</span>"+i[s].description+"</a></li>");this.search.results.append(a)}this.search.form.hasClass("open")&&this.search.results.show()}else this.search.results.hide();this.search.icon.removeClass("fa fa-spin fa-spinner").addClass("icon-magnifier")},Mconsole.prototype.getNotifications=function(){$.get("/mconsole/api/notifications",this.handleNotifications.bind(this))},Mconsole.prototype.handleNotifications=function(i){this.notifications.container.html("");var s=[];0==i.length?(s.push($('<li>                <a href="javascript:;">                    <span class="details">Нет новых уведомлений</span>                </a>            </li>')),this.notifications.badge.text("")):(s=i.map(function(i){var s=i.link.length>0?i.link:"javascript:;",t=i.link.length>0?'target="_blank"':"",a=i.link.length>0?'<span class="pull-right label label-sm label-icon label-success"><i class="fa fa-external-link"></i> </span>':"";return $li=$('<li data-id="'+i.id+'"><a href="'+s+'" '+t+'><span class="details">'+i.text+a+"</span></a></li>"),$li}.bind(this)),this.notifications.badge.text(i.length));for(var t in s)this.notifications.container.append(s[t])},$(document).ready(function(){new Mconsole});