// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    //document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 

function getMessage(flag_area) {

    var area_id = 0;
    var region_id = 0;

    if (flag_area > 0) {
        var obj_area = document.getElementById("area");
        area_id = obj_area.options[obj_area.selectedIndex].value;
    } else {
        var obj_region = document.getElementById("region");
        region_id = obj_region.options[obj_region.selectedIndex].value;
    }

    $.ajax({
        type: 'GET',
        url: '/getmsg',

        //data: '{ _token = <?php echo csrf_token() ?> , area_id : area_id, region_id : region_id }',

        data: {
            area_id: area_id,
            region_id: region_id
        },


        success: function (data) {
            /*
            var myJSON = JSON.stringify(data.msg);
            */
            var html_settlement = "<option value=''>Выбрать нас. пункт...</option>";
            document.getElementById("settlement_id").innerHTML = html_settlement;

            if (flag_area > 0) {
                var html_region = "<option value=''>Выбрать район...</option>";
                for (i in data.regions) {
                    region = data.regions[i];
                    html_region += "<option value=" + region.id + ">" + region.name + "</option>";
                }
                document.getElementById("region").innerHTML = html_region;
            } else {
                for (i in data.settlements) {
                    settlement = data.settlements[i];
                    html_settlement += "<option value=" + settlement.id + ">" + settlement.name + "</option>";
                }
                document.getElementById("settlement_id").innerHTML = html_settlement;
            }
        }
    });
}

function getRegions() {

    var obj_area = document.getElementById("area_id");
    var area_id = obj_area.options[obj_area.selectedIndex].value;

    $.ajax({
        type: 'GET',
        url: '/getregions',

        data: {
            area_id: area_id
        },

        success: function (data) {
            /*
            var myJSON = JSON.stringify(data.regions);
            console.log(myJSON);
            */

            var html_region = "<option value=''>Выбрать район...</option>";
            for (i in data.regions) {
                region = data.regions[i];
                html_region += "<option value=" + region.id + ">" + region.name + "</option>";
            }
            document.getElementById("region_id").innerHTML = html_region;
        }
    });
}

function selectOptionId(selector_name, id){

    var selector = document.getElementById(selector_name);
    var arr_option = selector.options;

    for(var x=0; x < arr_option.length; x++){
        if (arr_option[x].value == id) {
            arr_option[x].selected = true;
            return;
        }   
    }

}


function checkV(flright, flcheck){

    var inputname = "";

    if (flright == 0){
        inputname = "order_left_";
    }else{
        inputname = "order_right_";
    }

    var inputs = document.getElementsByTagName("input");

    for(var x=0; x<inputs.length; x++){

        var input = inputs[x];

        if (input.type != "checkbox"){
            continue;
        }

        var str = input.name;

        var pos = str.indexOf(inputname);

        if (pos != 0){
            continue;
        }

        if(flcheck == 0){
            input.checked = false;
        }else if(flcheck == 1){
            input.checked = true;
        }else{
            input.checked = !input.checked;
        }

    }
}

function checkVname(inputname){

    var inputs = document.getElementsByTagName("input");

    for(var x=0; x<inputs.length; x++){

        var input = inputs[x];

        if (input.type != "checkbox"){
            continue;
        }

        var str = input.name;

        var pos = str.indexOf(inputname);

        if (pos != 0){
            continue;
        }

       input.checked = !input.checked;
    }
}


function getSumQty()
{
    var sum_qty = 0;
    var inputname = "location_";
    var inputs = document.getElementsByTagName("input");

    for(var x=0; x<inputs.length; x++){

        var input = inputs[x];

        if (input.type != "checkbox"){
            continue;
        }

        if (!input.checked){
            continue;
        }

        //var str = input.name;
        var str = input.id;

        var pos = str.indexOf(inputname);

        if (pos != 0){
            continue;
        }

        sum_qty += parseInt(input.value);
    }
    
    document.getElementById("sum_qty").innerText = sum_qty;
}

function checkLocation()
{
    var inputname = "location_";

    var inputs = document.getElementsByTagName("input");

    for(var x=0; x<inputs.length; x++){

        var input = inputs[x];

        if (input.type != "checkbox"){
            continue;
        }

        //var str = input.name;
        var str = input.id;

        var pos = str.indexOf(inputname);

        if (pos != 0){
            continue;
        }

        input.checked = !input.checked;
    }
}

function detectMobileDevice()
{
    if( navigator.userAgent.match(/Android/i)
       || navigator.userAgent.match(/webOS/i)
       || navigator.userAgent.match(/iPhone/i)
       || navigator.userAgent.match(/iPad/i)
       || navigator.userAgent.match(/iPod/i)
       || navigator.userAgent.match(/BlackBerry/i)
       || navigator.userAgent.match(/Windows Phone/i)
       )
        return true;

    return false;
}

function getIndentForMobile()
{
    if (!detectMobileDevice()){
        return;
    }

    var div_mobile_indent = document.getElementById("mobile_indent");
    div_mobile_indent.setAttribute('class', 'pt-3');
    
    return;
}

function testElementForm(name, kolsymb)
{
    var input_name = document.getElementById(name);

    if (input_name.value.length >= kolsymb){

        var input_name_error = document.getElementById(name+"_error");
        input_name_error.innerText = "";

        return true;
    }

    var input_name_error = document.getElementById(name+"_error");
    input_name_error.innerText = "Укажите "+name+" (минимум "+kolsymb+" символов)!";

    return false;
}

function validateForm() 
{
    var flproducts = 0;
    var flallchosen = 1;

    var inputid = "nomenclature_";
    var inputs = document.getElementsByTagName("input");
    for(var x=0; x<inputs.length; x++)
    {
        var input = inputs[x];

        var str = input.id;

        var pos = str.indexOf(inputid);

        if (pos != 0){
            continue;
        }

        if(input.value > 0){
            flproducts = 1;
            break;
        }
    }

    if (flproducts == 0){
        var div_nomenclature_error = document.getElementById("nomenclature_error");
        div_nomenclature_error.innerText = "Укажите количество товара!";
    }


    var result = true;

    result = testElementForm("phone", 10);
    if (!result){
        flallchosen = 0;
    }

    result = testElementForm("name", 3);
    if (!result){
        flallchosen = 0;
    }

    result = testElementForm("settlement_id", 1);
    if (!result){
        flallchosen = 0;
    }

    if (flproducts == 1 && flallchosen == 1){
        return true;
    }

    return false;
}


function getChooseSettlements() 
{
    var name = '';

    var obj_name = document.getElementById("testsettlement");
    name = obj_name.value;

    $.ajax({
        type: 'GET',
        url: '/chooseSettlements',

        //data: '{ _token = <?php echo csrf_token() ?> , area_id : area_id, region_id : region_id }',

        data: {
            name: name,
        },


        success: function (data) {
            //$("#msg").html(data.msg);

            for (i in data){
                var cur_element = data[i];
                
                var id = cur_element.id;
                var fullname = cur_element.fullname;

                console.log(''+id+', '+fullname);
            }

            document.getElementById("settlement_id").innerText = '';

            //$("#msg").html(x);
        }
    });
}

function fillAvto()
{
    var driver_id = document.getElementById("driver_id").value;
    if (driver_id == 0){
        return;
    }

    $.ajax({
        type: 'GET',
        url: '/getdriveravto',

        data: {
            driver_id: driver_id,
        },

        success: function (data) {
            
            if (data.length == 0) return;
            if (!('avto' in data)) return;

            var avto = data.avto;

            selectOptionId("avto_id", avto.id);
        }
    });

}

function searchOldOrders()
{
    var phone = document.getElementById("phone").value;

    if (phone.length < 10) return;

    $.ajax({
        type: 'GET',
        url: '/getorderinfo',

        data: {
            phone: phone,
        },

        success: function (data) {
            
            if (data.length == 0) return;
            if (!('info' in data)) return;

            var div = document.getElementById("oldorders");
            div.innerText = '';

            var str = "";
            for (i in data.info){
                var cur_element = data.info[i];
                var id = cur_element.id;
                var description = cur_element.info;
                
                var newlink = document.createElement('a');

                newlink.setAttribute('href', "/orders/"+id);

                newlink.setAttribute('class', "mr-3");

                newlink.innerText = description;
                
                div.appendChild(newlink);
            }
        }
    });    
}

function validateForm_searchform()
{
    var search = document.getElementById("search");

    var strsearch = search.value;

    if (strsearch.length > 0){
        return true;
    }

    return false;
}

function losesvodnaya()
{
    document.getElementById("svodnaya_id").value = 0;

    document.getElementById("svodnaya_id_label").innerText = "";
}

function showregion(area_id)
{
    var str_div = "details_area_id_";
    var str_div_title = "title_area_id_";

    var divs = document.getElementsByTagName("div");

    for (var i = divs.length - 1; i >= 0; i--) {
        var cur_element =  divs[i];

        if (!cur_element.id){
            continue;
        }

        //---- details --- 

        var pos = cur_element.id.indexOf(str_div);

        if (pos == 0){
            var id = cur_element.id.substring(str_div.length);

            if (area_id == id){
                cur_element.hidden = !cur_element.hidden;
            }else{
                cur_element.hidden = true;
            }
        }

        //---- title --- 

        var pos = cur_element.id.indexOf(str_div_title);

        if (pos == 0){
            var id = cur_element.id.substring(str_div_title.length);

            if (area_id == id){
                cur_element.setAttribute("class", "font-weight-bold");
            }else{
                cur_element.setAttribute("class", "");
            }
        }
    } 

}

function updatesumma()
{
    inputid = "order_id_";

    var vsegosumma = 0;

    var inputs = document.getElementsByTagName("input");
    for(var x=0; x<inputs.length; x++)
    {
        var input = inputs[x];
        if (input.type != "checkbox"){
            continue;
        }
        if (!input.checked){
            continue;
        }

        var str = input.id;
        var pos = str.indexOf(inputid);
        if (pos != 0){
            continue;
        }    

        var value = parseInt(input.value);

        vsegosumma += value;
    }

    document.getElementById("vsegosumma").innerText = vsegosumma;
}

function checkoneorder(order_id)
{
    var input = document.getElementById('order_id_'+order_id);

    input.checked = !input.checked;

    updatesumma();
}

function checkmanyorders()
{
    var qty = document.getElementById("qty").value;

    if ( !(qty > 0) ){
        return;
    }

    var minvalue = document.getElementById("minvalue").value;
    var maxvalue = document.getElementById("maxvalue").value;

    //console.log("minvalue = "+minvalue + " ; maxvalue = "+maxvalue);

    inputid = "order_id_";

    var vsegospisat = qty;

    var inputs = document.getElementsByTagName("input");
    for(var x=0; x<inputs.length; x++)
    {
        var input = inputs[x];
        if (input.type != "checkbox"){
            continue;
        }

        var str = input.id;
        var pos = str.indexOf(inputid);
        if (pos != 0){
            continue;
        }    

        var value = parseInt(input.value);

        if (value > maxvalue || value < minvalue){
            input.checked = false;
            continue;
        }


        if (vsegospisat >= value){

            input.checked = true;

            vsegospisat -= value;

        }else{
            input.checked = false;
        }
    }

    updatesumma();
}

function checkkitnom(id)
{
    $.get("checkkitnom",
    {
        id: id
    },
    function(data, status){
        if (status != 'success'){
            console.log(status);
            return;
        }

        var input = document.getElementById("nomenclature_"+data.id);
        if (input){
            input.checked = data.result;
        }
    });
}

function checkcost(cost_id)
{
    id = "approvedids_"+cost_id;

    var input = document.getElementById(id);
    if (!input){
        console.log('element not found: '+id);
        return;
    }

    $.ajax({
        type: 'GET',
        url: '/checkcost',

        data: {
            cost_id: cost_id,
        },

        success: function (data) {

            if (data.length == 0) return;

            if (!('approved' in data)) return;

            var approved = data.approved;

            input.checked = approved;

            if ('username' in data){
                var username = data.username;

                var div_approvedname = document.getElementById("approvedname_"+cost_id);

                if (div_approvedname){
                    div_approvedname.innerText = username;
                }
            }

            if ('summa' in data){

                var summa = parseFloat(data.summa, 2);

                var div_summa_approved = document.getElementById("summa_approved");

                if (div_summa_approved){

                    var summa_approved = parseFloat(div_summa_approved.innerText);

                    if (approved){
                        summa_approved += summa;
                    }else{
                        summa_approved -= summa;
                    }

                    div_summa_approved.innerText = summa_approved.toFixed(2);
                }
            }

        }
    });
}

function SvodnayasFilter()
{
    $("tr").show();

    var driver_id = $("select[name='driver_id']").val();

    if (driver_id > 0){
        $("tr[driver_id!="+driver_id+"]").hide();
    }

    $("tr:first").show();
}

function TableCostsSetSumma()
{
    var summa = 0;
    var divs = $("div[name='summa']");
    for (var i = divs.length - 1; i >= 0; i--) {

        var cur_element = divs[i];

        if (cur_element.parentElement.parentElement.hidden){
            continue;
        }

        summa += parseInt(divs[i].innerText);
    }
    
    $("#summa").text(summa);
}

function TableCostsFilter()
{
    var startdate = $("#startdate").val();
    var enddate = $("#enddate").val();

    $("tr").attr("hidden", false);

    if (startdate.length == 0 && enddate.length == 0){
        TableCostsSetSumma();
        return;
    }   

    var trs = $("tr");
    for (var i = trs.length - 1; i >= 0; i--) {
        var cur_element = trs[i];

        var str_date = cur_element.getAttribute('date');

        if (!str_date){
            continue;
        }

        attr_date = new Date(str_date);

        if (startdate.length > 0){
            d1 = new Date(startdate);
            if (attr_date < d1){
                cur_element.hidden = true;
                continue;
            }
        }

        if (enddate.length > 0){
            d2 = new Date(enddate);
            if (attr_date > d2){
                cur_element.hidden = true;
                continue;
            }
        }
    }

    TableCostsSetSumma();
}


