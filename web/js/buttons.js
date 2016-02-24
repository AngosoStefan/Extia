
$(document).ready(function(){

    $("#btn1").click(function(e){
        e.preventDefault();

        var l1 = $('#l1').val();
        
		$('#lfinal').val(l1);

        $('#room').text(l1);
    });

	$("#btn2").click(function(e){
		e.preventDefault();

        var l2 = $('#l2').val();

		$('#lfinal').val(l2);

        $('#room').text(l2);
    });

    $("#btn3").click(function(e){
        e.preventDefault();

        var l3 = $('#l3').val();

        $('#lfinal').val(l3);

        $('#room').text(l3);

    });

});