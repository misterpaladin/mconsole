var initMenu;initMenu=function(){var e,t,n;return n="li:not(.toggle-blade-helper)",e=function(t,n){var l;return l=[],t.children(n).map(function(t,r){var o;return o={key:$(r).data("key")},$(r).children("ul").length>0&&(o.children=e($(r).children("ul"),n)),l.push(o)}),l},t=$("#main-menu"),t.sortable({containment:"parent",items:n,stop:function(l){var r;return r=e(t,n),$.ajax({url:t.data("ajax"),headers:{"X-CSRF-TOKEN":$('meta[name="_token"]').attr("content")},type:"POST",data:{menus:JSON.stringify(r)}})}})},$(document).ready(function(){var e,t,n,l,r,o,a,i,u,c,s,d,m;if($(".delete-confirm").on("click",function(){var e;return e=new Confirm("mconsole-table-delete",jstrans("delete-modal-title"),jstrans("delete-modal-body"),jstrans("delete-modal-ok"),jstrans("delete-modal-cancel"),"btn-danger"),e.show(function(e){return function(){return $(e).closest("form").submit()}}(this)),!1}),e=$(".color-picker"),null!=e)for(n=0,o=e.length;o>n;n++)t=e[n],$(t).minicolors({defaultValue:"#0088cc",theme:"bootstrap"});if(s=$(".multi-select:not(.grouped)"),null!=s)for(l=0,a=s.length;a>l;l++)t=s[l],$(t).multiSelect();if(d=$(".multi-select.grouped"),null!=d)for(r=0,i=d.length;i>r;r++)t=d[r],$(t).multiSelect({selectableOptgroup:!0});if(m=$(".select2"),null!=m)for(c=0,u=m.length;u>c;c++)t=m[c],$(t).select2();return initMenu()});