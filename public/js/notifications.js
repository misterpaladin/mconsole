var notifications;this.Notification=function(){function t(){this.config={closeButton:!1,debug:!1,newestOnTop:!1,progressBar:!1,positionClass:"toast-top-right",preventDuplicates:!1,showDuration:100,hideDuration:100,timeOut:1e4,extendedTimeOut:1e4,showEasing:"swing",hideEasing:"linear",tapToDismiss:!0}}return t.prototype.push=function(t,i,n,o){var s;return s=this.config,o&&$.extend(s,o),toastr.options=s,-1!==["success","info","warning","error"].indexOf(t)?toastr[t](i,n):void 0},t}(),notifications={push:function(t,i,n){var o;return o=new Notification,o.push(t,i,n)}};