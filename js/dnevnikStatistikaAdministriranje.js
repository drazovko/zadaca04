var prijave = "";
$("#a2").on('click', dnevnik());
function dnevnik() {
    console.log("U funkciji sam 2 dnevnik!");
    
   
    var tablica1 = $('<table id="tablica1" class="display" cellspacing="0" width="100%">');
        tablica1.append('<thead><tr><th class="prvi_stupac">Id</th><th class="drugi_stupac">Korisnik</th><th>Adresa</th><th>Poruka</th><th>Virtualno vrijeme</th><th>Stvarno vrijeme</th></tr></thead>');
        console.log("Radi");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/dnevnikStatistikaAdministriranje.php",
                dataType: 'xml',
                data:{
                   
                },
                
                success: function (data) {
                    console.log("U funkciji sam 3 dnevnik!");
                    var tbody = $("<tbody id='fbody1'>");
                    $(data).find('name').each(function() {
                    var red = '<tr>';
                    red += '<td class="prvi_stupac">' + $(this).attr('iddnevnik') + '</td>';
                    red += '<td class="drugi_stupac">' + $(this).attr('korisnik') + '</td>';
                    red += '<td >' + $(this).attr('adresa') + '</td>';
                    red += '<td >' + $(this).attr('tekst') + '</td>';
                    red += '<td >' + $(this).attr('virVrijeme') + '</td>';
                    red += '<td >' + $(this).attr('stvVrijeme') + '</td>';
                    red += '</tr>';
                    tbody.append(red);
                    });
                    tbody.append("</tbody>");
                    tablica1.append(tbody);
                    $('#tuto1').html(tablica1);
                    $('#tablica1').dataTable(
                        {
                        "aaSorting": [[5, "desc"],[0,"asc"]],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter":true,
                        "bSort":true,
                        "bInfo":true,
                        "bAutoWidth":true
                        });
                    
                    $('#tablica1 tr').click(function(){
                        $('#tablica1 tr').each(function(){
                            $(this).css('color', 'green');
                        });
            
                        $(this).css('color', 'blue');
                        
                   });      
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            });
    
}

$('#uvod input').on('change', function() {
   prijave = ($('input[name=prijave]:checked', '#uvod').val()); 
});

$("#korisnik").keyup(function() {
	var rows = $("#fbody1").find("tr").hide();
	var data = this.value.split(" ");
	$.each(data, function(i, v) {
		rows.filter(":contains('" + v + "')").show();
	});
});



function statistikaDnevnika(){
    korisnik = $('#korisnik').val();
    odDatuma = $('#odDatuma').val();
    doDatuma = $('#doDatuma').val();
    test = $( '#tablica1 td:eq(1)').text();
 
    console.log(korisnik, odDatuma, doDatuma, prijave);
    console.log("U funkciji sam 2 statistikaDnevnika!");
    
   
    var tablica1 = $('<table id="tablica1" class="display" cellspacing="0" width="100%">');
        tablica1.append('<thead><tr><th class="prvi_stupac">Korisnik</th><th class="drugi_stupac">Ukupno</th><th>Od datuma</th><th>Do datuma</th></tr></thead>');
        console.log("Radi");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/dnevnikStatistikaUpit.php",
                dataType: 'xml',
                data:{
                    'korisnik': korisnik,
                    'odDatuma': odDatuma,
                    'doDatuma': doDatuma,
                    'prijave': prijave
                },
                
                success: function (data) {
                    console.log("U funkciji sam 3 statistikaDnevnik!");
                    var tbody = $("<tbody id='fbody1'>");
                    $(data).find('name').each(function() {
                    var red = '<tr>';
                    red += '<td class="prvi_stupac">' + $(this).attr('korisnik') + '</td>';
                    red += '<td class="drugi_stupac">' + $(this).attr('broj') + '</td>';
                    red += '<td >' + odDatuma + '</td>';
                    red += '<td >' + doDatuma + '</td>';
                    red += '</tr>';
                    tbody.append(red);
                    });
                    tbody.append("</tbody>");
                    tablica1.append(tbody);
                    $('#tuto1').html(tablica1);
                /*    $('#tablica1').dataTable(
                        {
                        "aaSorting": [[5, "desc"],[0,"asc"]],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter":true,
                        "bSort":true,
                        "bInfo":true,
                        "bAutoWidth":true
                        });
                  */  
                    $('#tablica1 tr').click(function(){
                        $('#tablica1 tr').each(function(){
                            $(this).css('color', 'green');
                        });
            
                        $(this).css('color', 'blue');
                        
                   });      
                },  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            });
    
    
    
    }