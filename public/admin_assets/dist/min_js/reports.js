app.controller("reports",["$scope","$http",function(e,t){e.report=function(r,o,a){t.post(APP_URL+"/"+ADMIN_URL+"/reports",{from:r,to:o,category:a}).then(function(t){e.category||(e.users_report=t.data,e.rooms_report=!1,e.reservations_report=!1),"rooms"==e.category&&(e.users_report=!1,e.rooms_report=t.data,e.reservations_report=!1),"reservations"==e.category&&(e.users_report=!1,e.rooms_report=!1,e.reservations_report=t.data)})},e.print=function(e){e=e?e:"users";var t=document.getElementById(e),r=window.open("","","left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0");r.document.write(t.innerHTML),r.document.close(),r.focus(),r.print(),r.close()},$(".date").datepicker({dateFormat:"dd-mm-yy",maxDate:new Date}),$(document).ready(function(){$("#from_to_disable").change(function(){var e=$("#from_to_disable option:selected").val();"reservations"==e?($(".date").datepicker("option","maxDate",""),$(".date").datepicker("refresh")):($(".date").datepicker("option","maxDate",new Date),$(".date").datepicker("refresh"))})})}]);