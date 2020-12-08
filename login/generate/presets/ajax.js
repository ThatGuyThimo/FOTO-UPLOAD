function InitAJAX() {
    var objxml;
    var IEtypes = [`Msxml2.XMLHTTP.6.0`, `Msxml2.XMLHTTP.3.0`, `Microsoft.XMLHTTP`];

    try {
        // Probeer het eerst op "Moderne" standaardmanier (ES6)
        objxml = new XMLHttpRequest();
    } catch (e) {
        // De standaardmanier werkte niet, probeer oude IE manieren (ES5)
        for (let i = 0; i < IEtypes.length; i++) {
            try {
                objxml = new ActiveXObject(IEtypes[i]);
            } catch (e) {
                continue;
            }
        }
    }
    return objxml;
}


function zoek1(myName) 
{
    var xmlHttp = InitAJAX();


    var url = `delete.php`;

    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            const result = xmlHttp.responseText;

            window.location.replace("../../groupselect.php");
            // document.getElementById('resultaat').innerHTML = result;
        }
    }


    // verstuur de request
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}