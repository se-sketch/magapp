function DeleteNomenclatureImage(image_id){

	if (!(image_id > 0)){
		return;
	}

    $.ajax({
        type: 'GET',
        url: '/nomenclatures/delete_image/',

        //data: '{ _token = <?php echo csrf_token() ?> , area_id : area_id, region_id : region_id }',

        data: {
            image_id: image_id
        },


        success: function (data) {
        	
        	var deteled_id = data.image_id;

        	if (deteled_id){
        		var div_image = document.getElementById("image_"+deteled_id).remove();
        	}
        }
    });   
}

function SetMainImage(image_id){
    if (!(image_id > 0)){
        return;
    }

    $.ajax({
        type: 'GET',
        url: '/nomenclatures/set_main_image/',

        //data: '{ _token = <?php echo csrf_token() ?> , area_id : area_id, region_id : region_id }',

        data: {
            image_id: image_id
        },


        success: function (data) {
            var main_image_id = data.image_id;
            var main = data.main;

            var button = document.getElementById("button_main_"+main_image_id);

            if (button){
                button.setAttribute('class', 'mainButton_'+main);
            }
        }
    });   

}