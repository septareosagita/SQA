function stripToMoney(words,character) {
    var spaces = words.length;
    for(var x = 1; x<spaces ; ++x){
        words = words.replace("-", "");
        words = words.replace(".", "");
        words = words.replace(",", "");
    }
    return words;
}

function DecimalAsString(value)
{
    var i = parseFloat(value);
    if(isNaN(i)) {
        i = 0;
    }
    var minus = '';
    if(i < 0) {
        minus = '-';
    }
    i = Math.abs(i);
    i = parseInt((i + .005) * 100);
    i = i / 100;
    s = new String(i);
    if(s.indexOf('.') < 0) {
        s += ',-';
    }
    s = minus + s;
    return FormatNumberBy3(s);
}

function FormatNumberBy3(num, decpoint, sep) {
    // check for missing parameters and use defaults if so
    if (arguments.length == 2) {
        sep = ".";
    }
    if (arguments.length == 1) {
        sep = ".";
        decpoint = ",";
    }
    // need a string for operations
    num = num.toString();
    // separate the whole number and the fraction if possible
    a = num.split(decpoint);
    x = a[0]; // decimal
    y = a[1]; // fraction
    z = "";


    if (typeof(x) != "undefined") {
        // reverse the digits. regexp works from left to right.
        for (i=x.length-1;i>=0;i--)
            z += x.charAt(i);
        // add seperators. but undo the trailing one, if there
        z = z.replace(/(\d{3})/g, "$1" + sep);
        if (z.slice(-sep.length) == sep)
            z = z.slice(0, -sep.length);
        x = "";
        // reverse again to get back the number
        for (i=z.length-1;i>=0;i--)
            x += z.charAt(i);
        // add the fraction back in, if it was there
        if (typeof(y) != "undefined" && y.length > 0)
            x += decpoint + y;
    }
    return x;
}

function cekgo(url) {
    var cek = confirm('Are you Sure ?');
    if (cek) {
        window.location = url;
    }
}

function cekgod(url, d){
    var cek = confirm(d);
    if (cek) {
        window.location = url;
    }
}


function cek(frm) {
    //alert('yeah');
	
    if(frm.cekall.checked){
        for(i=0; i<frm.length;i++){
            if(frm.elements[i].type == 'checkbox'){
                frm.elements[i].checked=true;
            }
        }
    } else {
        for(i=0; i<frm.length;i++){
            if(frm.elements[i].type == 'checkbox'){
                frm.elements[i].checked=false;
            }
        }
    }
}

function cekdulu(frm) {
    cek = centangsAll(frm);
    if (cek) {
        var cek = confirm('Delete Selected ?');
        if (cek) {
            frm.submit();
        }
    }
}

function centangsAll(frm){
    var nb = 0;
    for (i = 0; i< frm.length; i++)	{
        if ((frm.elements[i].type == 'checkbox') && (frm.elements[i].name == 'cek[]') && (frm.elements[i].checked)) {
            nb = nb + 1;
        }
    }
    if(nb == 0)
        return 0;
    else
        return 1;
}

function viewReport(url,w,h) {
    var wh = '';
    if (w!='' && h!='') {
        wh = ', width=' + w + ', height=' + h;
    }
    window.open(url, '', 'scrollbars=yes, resizable=yes' + wh);
}

/* FORMAT ANGKA 3 titik*/
function angka(objek) {
    objek = typeof(objek) != 'undefined' ? objek : 0;
    a = objek.value;
    b = a.replace(/[^\d]/g,"");
    c = "";
    panjang = b.length;
    j = 0;
    for (i = panjang; i > 0; i--) {
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)) {
            c = b.substr(i-1,1) + "." + c;
        } else {
            c = b.substr(i-1,1) + c;
        }
    }
    objek.value = c;
}

function str_replace(haystack, needle, replacement) {
    var temp = haystack.split(needle);
    return temp.join(replacement);
}