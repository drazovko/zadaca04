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
    
    //Aplikativna statistika dio !!!
    
$("#zupanije").one( "click", puniIzbornikZupanijama);
$("#zupanije").on( "click", testSlova);

var vrijednost = $("#zupanije").val();
console.log(vrijednost);

function testSlova(){
    var izbornikID = $("#zupanije");
    $(izbornikID).css('color', 'green');
    var vrijednost = $("#zupanije").val();
    console.log(vrijednost);
    if (vrijednost > 0) {
        console.log("Dinamo!");
        puniTablicuGradjevinarima(vrijednost);
    }
}

function isprazniIzbornik(izbornikID)
{
    $(izbornikID).children().remove();
}

function puniIzbornikZupanijama()
{
    var izbornikID = $("#zupanije");
    $.ajax({
        url: 'php_xml/pocetna_stranica_jquery.php',
        type: 'GET',
        dataType: 'xml',
        success: function(xml) {
            //isprazniIzbornik(izbornikID);
            $(xml).find('name').each(function() {
                $(izbornikID).append('<option value="' + $(this).attr('sifra') + '">' +
                $(this).text() + '</option>');
            });
        }
    });
}

function puniTablicuGradjevinarima(izbornikID)
{
    var tablica = $('<table id="tablica3" class="display" cellspacing="0" width="100%">');
        tablica.append('<thead><tr><th class="prvi_stupac">Ime</th><th class="drugi_stupac">Prezime</th><th>Zaht.</th><th>Video</th><th>Ocj.</th></tr></thead>');
        console.log("Radi");
    
    $.ajax({
        url: "php_xml/dnevnikStatistikaAplikativna.php",
        type: 'GET',
        dataType: 'xml',
        data:{
            'idZupanije': izbornikID
        },
        success: function(xml) {
            var tbody = $("<tbody>");
            var brojZaht;
            var brojVidea = 0;
            var brojZahtijeva = 0;
            $(xml).find('name').each(function() {
                var red = '<tr>';
                red += '<td class="prvi_stupac">' + $(this).attr('ime') + '</td>';
                red += '<td class="drugi_stupac">' + $(this).attr('prezime') + '</td>';
                red += '<td>' + $(this).text() + '</td>';               
                red += '<td>' + $(this).attr('videaPoGradjevinaru') + '</td>';               
                red += '<td>' + $(this).attr('ocjenaPoGradjevinaru') + '</td>';               
                red += '</tr>';
                brojZaht = $(this).attr('ukupnoZahtijeva');
                brojVidea = $(this).attr('videaPoZupaniji');
                tbody.append(red);
            });
                       
        tbody.append("</tbody>");
        tablica.append(tbody);
               
        $('#tuto3').html(tablica);
        $('#tablica3').dataTable(
            {
             "aaSorting": [[0, "asc"],[1,"asc"]],
             "bPaginate": true,
             "bLengthChange": true,
             "bFilter":true,
             "bSort":true,
             "bInfo":true,
             "bAutoWidth":true
            });
            
        var tablica4 = $('<table id="tablica4" class="display" cellspacing="0" width="100%">');
        tablica4.append('<thead><tr><th class="prvi_stupac">-</th><th class="drugi_stupac">Zaht.</th><th>Video</th></tr></thead>');
        var tbody4 = $('<tbody id="tbody4">');
        var red4 = '<tr><td>Ukupno po županiji:</td><td>' + brojZaht + '</td><td>' + brojVidea + '</td></tr>';
        tbody4.append(red4);
        tbody4.append("</tbody>");
        tablica4.append(tbody4);
            
        $('#tuto4').html(tablica4);
        $('#tablica4').dataTable(
            {
             "aaSorting": [[0, "asc"],[1,"asc"]],
             "bPaginate": true,
             "bLengthChange": true,
             "bFilter":true,
             "bSort":true,
             "bInfo":true,
             "bAutoWidth":true
            });
        }
    });
}