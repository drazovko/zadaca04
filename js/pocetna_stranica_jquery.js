/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$("#zupanije").one( "click", puniIzbornikZupanijama);
$("#zupanije").on( "click", testSlova);


var vrijednost = $("#zupanije").val();
console.log(vrijednost);

function akcija_5() {
                $('<br>').insertAfter('a[id*=v_]:even');
                }

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
    var tablica = $('<table id="tablica" class="display" cellspacing="0" width="100%">');
        tablica.append('<thead><tr><th class="prvi_stupac">Ime</th><th class="drugi_stupac">Prezime</th><th>Zahtijevi</th><th>Slike</th><th>Video</th><th>Dokumenti</th></tr></thead>');
        console.log("Radi");
    
    $.ajax({
        url: "php_xml/pocetna_stranica_jquery_1.php",
        type: 'GET',
        dataType: 'xml',
        data:{
            'idZupanije': izbornikID
        },
        success: function(xml) {
            var tbody = $("<tbody>");
            $(xml).find('name').each(function() {
                var red = '<tr>';
                red += '<td>' + $(this).attr('ime') + '</td>';
                red += '<td>' + $(this).attr('prezime') + '</td>';
                red += '<td>' + $(this).text() + '</td>';
                red += '<td>' + $(this).attr('slikaPoGradjevinaru') + '</td>';
                red += '<td>' + $(this).attr('videaPoGradjevinaru') + '</td>';
                red += '<td>' + $(this).attr('dokumenataPoGradjevinaru') + '</td>';
                
                
                red += '</tr>';
                tbody.append(red);
            });
        tbody.append("</tbody>");
        tablica.append(tbody);
        
        $('#uvod').html(tablica);
        $('#tablica').dataTable(
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