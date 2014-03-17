/*global getScrollHeight*/
/*jslint browser: true */
var isMozilla = (navigator.userAgent.toLowerCase().indexOf('gecko') !== -1) ? true : false;
var regexp = new RegExp("[\r]", "gi");


function bbcode_ajout_balise(selec, nomForm, nomTextarea, value) {
    "use strict";
    var oField, objectValue, objectValueDeb, objectValueFin, objectSelected, str, sel, bidon, orig, i, r, n, pos, selec2;
    selec2 = (selec === "url" || selec === "urlExterne" || selec === "source") ? selec + "=" : selec;
    if (value) {
        selec2 += value;
    }
    if (isMozilla) {
        // Si on est sur Mozilla
        oField = document.forms[nomForm].elements[nomTextarea];

        objectValue = oField.value;

        objectValueDeb = objectValue.substring(0, oField.selectionStart);
        objectValueFin = objectValue.substring(oField.selectionEnd, oField.textLength);
        objectSelected = objectValue.substring(oField.selectionStart, oField.selectionEnd);

        //  alert("Debut:'"+objectValueDeb+"' ("+deb+")\nFin:'"+objectValueFin+"' ("+fin+")\n\nSelectionné:'"+objectSelected+"'("+(fin-deb)+")");
        oField.value = objectValueDeb + "[" + selec2 + "]" + objectSelected + "[/" + selec + "]" + objectValueFin;
        oField.selectionStart = objectValueDeb.length;
        oField.selectionEnd = (objectValueDeb + "[" + selec2 + "]" + objectSelected + "[/" + selec + "]").length;
        oField.focus();
        oField.setSelectionRange(
            objectValueDeb.length + selec.length + 2,
            objectValueDeb.length + selec.length + 2
        );
    } else {
    // Si on est sur IE
        oField = document.forms[nomForm].elements[nomTextarea];
        str = document.selection.createRange().text;

        if (str.length > 0) {
        // Si on a selectionné du texte
            sel = document.selection.createRange();
            sel.text = "[" + selec + "]" + str + "[/" + selec + "]";
            sel.collapse();
            sel.select();
        } else {
            oField.focus(oField.caretPos);
        //  alert(oField.caretPos+"\n"+oField.value.length+"\n")
            oField.focus(oField.value.length);
            oField.caretPos = document.selection.createRange().duplicate();
            bidon = "%~%";
            orig = oField.value;
            oField.caretPos.text = bidon;
            i = oField.value.search(bidon);
            oField.value = orig.substr(0, i) + "[" + selec + "][/" + selec + "]" + orig.substr(i, oField.value.length);
            r = 0;
            for (n = 0; n < i; n += 1) {
                if (regexp.test(oField.value.substr(n, 2)) === true) {
                    r += 1;
                }
            }
            pos = i + 2 + selec.length - r;
            //placer(document.forms['news'].elements['newst'], pos);
            r = oField.createTextRange();
            r.moveStart('character', pos);
            r.collapse();
            r.select();

        }
    }
}

function bbcode_select_source() {
    "use strict";
    document.getElementById('paramChampsAppelantSource').value = 'bbcode';
    document.getElementById('calqueSource').style.top = (getScrollHeight() + 150) + 'px';
    document.getElementById('calqueSource').style.display = 'block';
}

function bbcode_ajout_source(id) {
    "use strict";
    bbcode_ajout_balise('source',  'formAjoutDossier', 'description', id);
}


function bbcode_apercu(str) {
    "use strict";
    var i, tab;
    str = str.split("&").join("&amp;").split("<").join("&lt;").split(">").join("&gt;");
    tab = [
        ["\\[urlExterne=\"http\\://(.*?)\"\\](.*?)\\[\/urlExterne\\]", "<a href=\"http://$1\" target=\"_blank\">$2</a>"],
        ["\\[urlExterne=\"https\\://(.*?)\"\\](.*?)\\[\/urlExterne\\]", "<a href=\"https://$1\" target=\"_blank\">$2</a>"],
        ["\\[urlExterne=http\\://(.*?)\\](.*?)\\[\/urlExterne\\]", "<a href=\"http://$1\" target=\"_blank\">$2</a>"],
        ["\\[urlExterne=https\\://(.*?)\\](.*?)\\[\/urlExterne\\]", "<a href=\"https://$1\" target=\"_blank\">$2</a>"],
        ["\\[urlExterne=\"(.*?)\"\\](.*?)\\[\/urlExterne\\]", "<a href=\"$1\" target=\"_blank\">$2</a>"],
        ["\\[urlExterne=\'(.*?)\'\\](.*?)\\[\/urlExterne\\]", "<a href=\"$1\" target=\"_blank\">$2</a>"],
        ["\\[urlExterne\\](.*?)\\[\/urlExterne\\]", "<a href=\"http://$1\" target=\"_blank\">$1</a>"],
        ["\\[url=\"http\\://(.*?)\"\\](.*?)\\[\/url\\]", "<a href=\"http://$1\">$2</a>"],
        ["\\[url\\]http\\://(.*?)\\[\/url\\]", "<a href=\"http://$1\">$1</a>"],
        ["\\[url=\"(.*?)\"\\]\"(.*?)\"\\[\/url\\]", "<a href=\"http://$1\">$2</a>"],
        ["\\[url\\](.*?)\\[\/url\\]", "<a href=\"http://$1\">$1</a>"],
        ["\\[url=http\\://(.*?)\\](.*?)\\[\/url\\]", "<a href=\"http://$1\">$2</a>"],
        ["\\[url\\]http\\://(.*?)\\[\/url\\]", "<a href=\"http://$1\">$1</a>"],
        ["\\[url\\](.*?)\\[\/url\\]", "<a href=\"http://$1\">$1</a>"],
        ["\\[url=(.*?)\\](.*?)\\[\/url\\]", "<a href=\"http://$1\">$2</a>"],
        ["\\[b\\]([\\s\\S]*?)\\[/b\\]", "<strong>$1</strong>"],
        ["\\[u\\]([\\s\\S]*?)\\[/u\\]", "<u>$1</u>"],
        ["\\[i\\]([\\s\\S]*?)\\[/i\\]", "<em>$1</em>"],
        ["\\[quote\\](.*?)\\[/quote\\]", "\"$1\""],
        ["\\[iframe=(.*?)\\](.*?)\\[/iframe\\]", "<iframe src=\"$1\" width='425' height='349'>$2</iframe>"],
        ["\\[source=(.*?)\\]\\[/source\\]", "<sup><a title='Source' href=\"index.php?archiAffichage=listeAdressesFromSource&source=$1&submit=Rechercher\">[?]</a></sup>"],
        ["\\n", "<br />"]
    ];
    for (i = 0; i < tab.length; i += 1) {
        str = str.replace(new RegExp(tab[i][0], "g"), tab[i][1]);
    }
    return str;
}

function bbcode_keyup(champ, id) {
    "use strict";
    var str = bbcode_apercu(champ.value);
    document.getElementById(id).innerHTML = str;
}

