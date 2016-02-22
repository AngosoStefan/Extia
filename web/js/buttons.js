
$(document).ready(function(){

    $("#btn1").click(function(e){
        e.preventDefault();

        var l1 = $('#l1').val();
        

		$('#lfinal').val(l1);

		var lf = $('#lfinal').val();

		alert(lf);
    });

	$("#btn2").click(function(e){
		e.preventDefault();

        var l2 = $('#l2').val();

		$('#lfinal').val(l2);

		var lf = $('#lfinal').val();

		alert(lf);
    });

});