

//Admin user listing
$("#profess").click(function(){
    localStorage.setItem("selected", "professional");
});
$("#recru").click(function(){
	localStorage.setItem("selected", "recruiter");
});
$("#organi").click(function(){
	localStorage.setItem("selected", "organization");
});

$( document ).ready(function() {
	var selectedMenu = localStorage.getItem("selected");
	if(selectedMenu && selectedMenu == "professional"){
		$('.professMenu, .professionalWrapper').addClass('active show');
		$('.recruiterWrapper').removeClass('active show');
		$('.organizationWrapper').removeClass('active show');
	}
	if(selectedMenu && selectedMenu == "recruiter"){
		$('.recuMenu, .recruiterWrapper').addClass('active show');
		$('.professionalWrapper').removeClass('active show');
		$('.organizationWrapper').removeClass('active show');
	}
	if(selectedMenu && selectedMenu == "organization"){
		$('.orgMenu, .organizationWrapper').addClass('active show');
		$('.professionalWrapper').removeClass('active show');
		$('.recruiterWrapper').removeClass('active show');
	}
});
//search box 
function reload(){
	$('form').attr('action',"javascript:void(0);");     
 }
 //for export csv
   function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
  // for advertisment --------
  

   



 