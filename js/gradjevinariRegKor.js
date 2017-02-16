
var idZahtijeva;
var idGradjevinara;
var IdKor = $("#IdKor").val();
var komentarRegKor = "";
var imeGradjevinara = "";
var prezimeGradjevinara = "";
var ocjenaGradjevinara;
$(function () {
    console.log("U funkciji sam 2!");
    
   
    var tablica = $('<table id="tablica" class="display" cellspacing="0" width="100%">');
        tablica.append('<thead><tr><th class="prvi_stupac">Ime građ.</th><th class="drugi_stupac">Prezime građ.</th><th>Ukupno br. zahtijeva</th><th>Prosječna ocjena</th></tr></thead>');
        console.log("Radi");
  $.ajax(
            {
                type: "GET",
                url: "php_xml/gradjevinariRegKorPregled.php",
                dataType: 'xml',
                data:{
                    'IdKor': IdKor
                },
                
                success: function (data) {
                    console.log("U funkciji sam 3!");
                    var tbody = $("<tbody>");
                    $(data).find('name').each(function() {
                    var red = '<tr>';
                    red += '<td class="prvi_stupac">' + $(this).attr('ime') + '</td>';
                    red += '<td class="drugi_stupac">' + $(this).attr('prezime') + '</td>';
                    red += '<td>' + $(this).attr('zahtijevaPoGradjevinaru') + '</td>';
                    red += '<td>' + $(this).attr('prosjecnaOcjenaPoGradjevinaru') + '</td>';
                    red += '</tr>';
                    tbody.append(red);
                    });
                    tbody.append("</tbody>");
                    tablica.append(tbody);
                    $('#tuto').html(tablica);
                    //$('#tablica').dataTable();
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
                    //zelenaTablica();
                    
},  
                error: function (data) {
                    console.log("Greška u komunikaciji . . ."); 
                    $('#greske').html("Greška u komunikaciji . . .");
                }
            });
    
});



function zelenaTablica(){
    $('#tablica').css('color', 'green');
}