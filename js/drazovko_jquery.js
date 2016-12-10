/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    $("#kor_ime").focusout(function (e) {provjera_kor_imena("kor_ime");});
    $("#ime").focusout(function (e) {provjera_ime_i_prezime("ime");});
    $("#prezime").focusout(function (e) {provjera_ime_i_prezime("prezime");});
    $("#lozinka").focusout(function (e) {provjera_lozinka("lozinka");});
    
    var gradovi = new Array();

    $.getJSON("http://arka.foi.hr/WebDiP/2014/materijali/zadace/dz3_dio2/gradovi.json",
            function (data) {
                $.each(data, function (key, val) {
                    console.log(val);
                    gradovi.push(val);
                });
            });
            
    $('#grad').autocomplete({
        source: gradovi
    });
    
    if($('#tablica_korisnici')) { 
    $('#tablica_korisnici').dataTable(
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
   
   $('#lista_XML').click(function (){
        var tablica = $('<table id="tablica">');
        tablica.append('<thead><tr><th>Ime</th><th>Prezime</th><th>Email</th></tr></thead>');
        console.log("Radi");
        
        $.ajax({
            type: "GET",
            url: "http://arka.foi.hr/WebDiP/2014/materijali/zadace/dz3_dio2/korisnici.xml",
            dataType: "xml",
            success: function (data){
            var tbody = $("<tbody>");
            $(data).find('korisnik').each(function (){
                var red = '<tr>';
                red += '<td>' + $(this).attr('ime') + '</td>';
                red += '<td>' + $(this).attr('prezime') + '</td>';
                red += '<td>' + $(this).attr('email') + '</td>';
                red += '</tr>';
                tbody.append(red);
            }
            );
           tbody.append("</tbody>");
           tablica.append(tbody);
           $('#sadržaj_tablice').html(tablica);
           $('#tablica').dataTable();
        }});
    }    
    );
   
    $('#lista_JSON').click(function (){
        var tablica = $('<table id="tablica">');
        tablica.append('<thead><tr><th>Ime</th><th>Prezime</th><th>Email</th></tr></thead>');
        console.log("Radi");
        
        $.getJSON('http://arka.foi.hr/WebDiP/2014/materijali/zadace/dz3_dio2/korisnici.json',function (data){
            var tbody = $("<tbody>");
            for(i=0; i<data.length;i++){
               var red = "<tr>";
               red += "<td>"+data[i].ime+"</td>";
               red += "<td>"+data[i].prezime+"</td>";
               red += "<td>"+data[i].email+"</td>";
               red += "</tr>";
               tbody.append(red);
           }
           tbody.append("</tbody>");
           tablica.append(tbody);
           $('#sadržaj_tablice').html(tablica);
           $('#tablica').dataTable();
        });
        
    }    
    );
    
    
} );


function provjera_lozinka(ulaz){
    var Lozinka = $('#lozinka').val();
    console.log("Lozinka: " + Lozinka);
    if(Lozinka == ""){
        $('#lozinka').css("background-color", "orangered");
        $("#lozinka").effect("highlight", 3000);
        $('#greske').html("Unesite vašu lozinku!<hr>");
        $('#lozinka').focus();
        return false;
    }
    console.log("Lozinka: " + Lozinka);
    var pattern = /^(?=(.*\d){2})(?=.*[a-z]{2})(?=.*[A-Z]).{10,32}$/;
    
    if(!(Lozinka.match(pattern))){
                        $('#lozinka').css("background-color", "orangered");
                        $("#lozinka").effect("highlight", 3000);
                        $('#greske').html("Lozinka: minimalno dva mala slova, jedno veliko slovo i dvije brojke i minimalna veličina 10 znakova.<hr>");
                        $('#lozinka').focus();
                    }
                    else{
                        console.log("Lozinka je ok!");
                        $('#lozinka').css("background-color", "aqua");
                        $("#lozinka").effect("highlight", 3000);
                        $('#greske').html("");
                    }
}


function provjera_ime_i_prezime(ulaz){
    var Ime = $('#ime').val();
    var Prezime = $('#prezime').val();
    console.log("Vrijednost korisničkog unosa, ime: " + Ime + " , prezime: " + Prezime);
    if(Ime == ""){
        $('#ime').css("background-color", "orangered");
        $("#ime").effect("highlight", 3000);
        $('#greske').html("Unesite vaše ime!<hr>");
        $('#ime').focus();
        return false;
    }
    if(Prezime == ""){
        $('#prezime').css("background-color", "orangered");
        $("#prezime").effect("highlight", 3000);
        $('#greske').html("Unesite vaše prezime!<hr>");
 //       $('#greske').effect("highlight");
        $('#prezime').focus();
        return false;
    }
    console.log("Vrijednost korisničkog unosa, ime: " + Ime + " , prezime: " + Prezime);
    $.ajax(
            {
                type: "GET",
                url: "http://arka.foi.hr/WebDiP/2014/materijali/zadace/dz3_dio2/korisnikImePrezime.php",
                dataType: 'xml',
                data:{
                    'ime': Ime,
                    'prezime': Prezime
                },
                success: function (data) {
                var zauzeto = $(data).find('korisnicko_ime').text();
                    console.log("zauzeto = " + zauzeto);
                    if(zauzeto != 0){
                        $('#ime').css("background-color", "orangered");
                        $("#ime").effect("highlight", 3000);
                        $('#prezime').css("background-color", "orangered");
                        $("#prezime").effect("highlight", 3000);
                        $('#greske').html("Kombinacija imena i prezimena je zauzeta!<hr>\n\
Korisnik ima korisničko ime: " + zauzeto + "<hr>");
                        $('#ime').focus();
                    }
                    else{
                        console.log("IMe i prezime je slobodno!");
                        $('#ime').css("background-color", "aqua");
                        $("#ime").effect("highlight", 3000);
                        $('#prezime').css("background-color", "aqua");
                        $("#prezime").effect("highlight", 3000);
                        $('#greske').html("");
                    }
                },
                error: function (data) {
                    console.log("Greška u komunikaciji . . .");
                }
                
            }
          );
}



function provjera_kor_imena(ulaz){
    var korIme = $('#kor_ime').val();
    console.log("Vrijednost korisničkog unosa: " + korIme);
    if(korIme == ""){
        $('#kor_ime').css("background-color", "orangered");
        $("#kor_ime").effect("highlight", 3000);
        $('#greske').html("Unesite korisničko ime!<hr>");
        $("#greske").effect("highlight", 3000);
        $('#kor_ime').focus();
        return false;
    }
    
    $.ajax(
            {
                type: "GET",
                url: "http://arka.foi.hr/WebDiP/2014/materijali/zadace/dz3_dio2/korisnik.php",
                dataType: 'xml',
                data:{
                    'korisnik': korIme
                },
                success: function (data) {
                    var zauzeto = $(data).find('korisnik').text();
                    console.log("zauzeto = " + zauzeto);
                    if(zauzeto == 1){
                        $('#kor_ime').css("background-color", "orangered");
                        $("#kor_ime").effect("highlight", 3000);
                        $('#greske').html("Korisničko ime je zauzeto!<hr>");
                        $("#greske").effect("highlight", 3000);
                        $('#kor_ime').focus();
                    }
                    else{
                        console.log("Korisničko ime je možda i slobodno!");
                        $('#kor_ime').css("background-color", "aqua");
                        $("#kor_ime").effect("highlight", 3000);
                        $('#greske').html("");
                    }
                },
                error: function (data) {
                    console.log("Greška u komunikaciji . . .");
                }
            }
            );
}