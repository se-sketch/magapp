 function sortByKey(jsObj){
    var sortedArray = [];

    // Push each JSON Object entry in array by [key, value]
    for(var i in jsObj)
    {
        sortedArray.push([i, jsObj[i]]);
    }

    // Run native sort function and returns sorted array.
    return sortedArray.sort();
}

function sortByValue(jsObj){
    var sortedArray = [];
    for(var i in jsObj)
    {
        // Push each JSON Object entry in array by [value, key]
        sortedArray.push([jsObj[i], i]);
    }
    return sortedArray.sort();
}

function fillupselector(sel, title, data_obj, select_id){

    var data_arr = sortByValue(data_obj);

    sel.innerHTML = '';

    var opt = document.createElement('option');
    opt.appendChild( document.createTextNode(title) );
    opt.value = ''; 
    sel.appendChild(opt); 

    for (i in data_arr) {
    	var tek_element = data_arr[i];
    	var name = tek_element[0];
    	var id = tek_element[1];

        obj = {'id': id, 'name': name};
        value = JSON.stringify(obj);

        var opt = document.createElement('option');
        opt.appendChild( document.createTextNode(name) );
        opt.value = value; 

        if (select_id == id){
        	opt.setAttribute('selected', true);
        }

        sel.appendChild(opt); 
    }
}

function getAddressKlissifier(flag_area){
    var str = '';
    var obj;

    var region_id = 0;
    var district_id = 0;
    var city_id = 0;

    var html_region = document.getElementById("region");
    var html_district = document.getElementById("district");
    var html_city = document.getElementById("city");


    if (flag_area == 1) {
        str = html_region.options[html_region.selectedIndex].value;
        if (str){
        	obj = JSON.parse(str); 
        	region_id = obj.id;
        	document.getElementById("old_region_id").value = region_id;
        }
    }

    if (flag_area == 2) {
        str = html_district.options[html_district.selectedIndex].value;
        if (str){
        	obj = JSON.parse(str); 
        	district_id = obj.id;
        	document.getElementById("old_district_id").value = district_id;
        }
    }

    if (flag_area == 3) {
        str = html_city.options[html_city.selectedIndex].value;
        if (str){
        	obj = JSON.parse(str); 
        	city_id = obj.id;
        	document.getElementById("old_city_id").value = city_id;
        }
        
        return;
    }


    $.ajax({
        type: 'GET',
        url: '/getaddressklissifier',

        //data: '{ _token = <?php echo csrf_token() ?> , area_id : area_id, region_id : region_id }',

        data: {
            region_id: region_id,
            district_id: district_id
        },


        success: function (data) {
            /*
            var myJSON = JSON.stringify(data);
            console.log(myJSON);
            */

            if (flag_area == 1){
                fillupselector(html_district, "Выберите район:", data.districts, 0);
            }

            if (flag_area == 2){
                fillupselector(html_city, "Выберите город:", data.cities, 0);
            }
        }
    });    
}

function fill_up_by_old_values(flag_area){

	var html_district = document.getElementById("district");
	var html_city = document.getElementById("city");
    
    var region_id = document.getElementById("old_region_id").value;
    var district_id = document.getElementById("old_district_id").value;
    var city_id = document.getElementById("old_city_id").value;

    //console.log(""+region_id+" ; "+district_id+" ; "+city_id);

    $.ajax({
        type: 'GET',
        url: '/getaddressklissifier',

        //data: '{ _token = <?php echo csrf_token() ?> , area_id : area_id, region_id : region_id }',

        data: {
            region_id: region_id,
            district_id: district_id
        },


        success: function (data) {
            /*
            var myJSON = JSON.stringify(data);
            console.log(myJSON);
            */

            fillupselector(html_district, "Выберите район:", data.districts, district_id);

            fillupselector(html_city, "Выберите город:", data.cities, city_id);
        }
    });    
}

function pickupstreet(element){

    var street_name = element.trim();
    if (street_name == ''){
        return;
    }

    var city_value = document.getElementById("city").value;
    if (city_value.trim() == ''){
        return;
    }

    obj = JSON.parse(city_value);
    city_id = obj.id;
    if (city_id == 0){
        return;
    }

    $.ajax({
        type: 'GET',
        url: '/getakstreets',

        //data: '{ _token = <?php echo csrf_token() ?> , area_id : area_id, region_id : region_id }',

        data: {
            street_name: street_name,
            city_id: city_id
        },


        success: function (data) {
            //var myJSON = JSON.stringify(data);

            var streets = data.streets;
            var keyCount  = Object.keys(streets).length;

            if (keyCount == 0){
                return;
            }
            
            var street_list = document.getElementById("streetdatalist");
            street_list.innerHTML = '';

            var kvo = 0;

            for (id in streets){
                name = streets[id];

                var value = "("+id+") "+name;
                
                var el_option = document.createElement("option");
                el_option.setAttribute("value", value);
                street_list.appendChild(el_option);

                kvo++;
                if (kvo > 5){
                    break;
                }
            }  
        }
    });   
}

function drag_street_id(street_value){
	var pattern = /\(\d+\)/;
  	var result_arr = street_value.match(pattern);
  	if (result_arr.length == 0){
  		return '';
  	}
  	street_id = result_arr[0];

	pattern = /\d+/;
	result_arr = street_id.match(pattern);
  	if (result_arr.length == 0){
  		return '';
  	}
  	street_id = result_arr[0];	

  	return street_id;
}

function pickup_housenumber(element){

    var housenumber = element.trim();

    var street_value = document.getElementById("street").value;
    if (!street_value){
        return;
    }
    var street_id = drag_street_id(street_value);

  	var housenumber = document.getElementById("housenumber").value;

    $.ajax({
        type: 'GET',
        url: '/getakhousenumbers',

        //data: '{ _token = <?php echo csrf_token() ?> , area_id : area_id, region_id : region_id }',

        data: {
            street_id: street_id,
            housenumber: housenumber
        },


        success: function (data) {
            //var myJSON = JSON.stringify(data);

            var housenumbers = data.housenumbers;
            var keyCount  = Object.keys(housenumbers).length;
            
            if (keyCount == 0){
                return;
            }
            
            var housenumber_datalist = document.getElementById("housenumber-datalist");
            housenumber_datalist.innerHTML = '';

            var kvo = 0;

            for (id in housenumbers){
                var value = housenumbers[id];
                
                var el_option = document.createElement("option");
                el_option.setAttribute("value", value);
                housenumber_datalist.appendChild(el_option);

                kvo++;
                if (kvo > 5){
                    break;
                }
            }  
        }
    });   
}

function TestAddressKlissifierForm(){

	var result = true;

	var region = document.getElementById("region").value;
	var district = document.getElementById("district").value;
	var city = document.getElementById("city").value;
	var street = document.getElementById("street").value;
	var housenumber = document.getElementById("housenumber").value;

	if (!region){
		document.getElementById("error_region").innerText = 'Region must be filled';
		result = false;
	}
	if (!district){
		document.getElementById("error_district").innerText = 'District must be filled';
		result = false;
	}
	if (!city){
		document.getElementById("error_city").innerText = 'City must be filled';
		result = false;
	}
	if (!street){
		document.getElementById("error_street").innerText = 'Street must be filled';
		result = false;
	}
	if (!housenumber){
		document.getElementById("error_housenumber").innerText = 'Housenumber must be filled';
		result = false;
	}

	return result;
}