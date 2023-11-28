 
function update_full() {
	full_adr= $('#zip').val()
	+' '+$('#region').val()
	+' '+$('#district').val()
	+' '+$('#city').val()
	+' '+$('#street').val()
	+' '+$('#building').val();
	
	$('#address').val(full_adr);
}

$(document).ready(function () {
	var full_adr='';
	var $address = $('#address');
	var 	$zip = $('#zip'),
        	$region = $('#region'),
        	$district = $('#district'),
        	$city = $('#city'),
        	$street = $('#street'),
        	$building = $('#building');
        	
	$('#address').fias({
		oneString: true,
		verify: true,
		'withParents': true,
		change: function (obj) {
			console.log(obj);
			$.each( obj.parents, function( key, item ) {
  				if (obj.zip !== null) $('#zip').val(item.zip);
  				$('#'+item.contentType).val(item.typeShort+'. '+item.name)
			});
			$('#'+obj.contentType).val(obj.typeShort+'. '+obj.name)
			if (obj.zip !== null) $('#zip').val(obj.zip);
		}
	});
	
	$('#region').fias({
            'type': $.fias.type.region,
            verify: true,
            'withParents': true,
            change: function (obj) {
            	console.log(obj);
            	//$('#region').val(obj.typeShort+'. '+obj.name)
            	$('#zip').val(obj.zip);
            	$('#district').val('');
            	$('#city').val('');
            	$('#street').val('');
            	$('#building').val('');
            	update_full();
            	
            	
            	
            }
    	});
    	$('#district').fias({
	    parentInput:$('#region'),
	    verify: true,
            'type': $.fias.type.district,
            'withParents': true,
            change: function (obj) {
            	console.log(obj);
            	$('#zip').val(obj.zip);
            	$('#city').val('');
            	$('#street').val('');
            	$('#building').val('');
            	update_full();
            }
    	});
    	$('#city').fias({
    	    parentInput:$('#district'),
    	    verify: true,
            'type': $.fias.type.city,
            'withParents': true,
            change: function (obj) {
            	console.log(obj);
            	$('#zip').val(obj.zip);
            	
            	$('#street').val('');
            	$('#building').val('');
            	update_full();
            }
    	});
    	$('#street').fias({
    	    parentInput:$('#city'),
    	    verify: true,
            'type': $.fias.type.street,
            'withParents': true,
            change: function (obj) {
            	console.log(obj);
            	$('#zip').val(obj.zip);
            	$('#building').val('');
            	update_full();
            }
    	});
    	$('#building').fias({
    	    parentInput:$('#street'),
    	    verify: true,
            'type': $.fias.type.building,
            'withParents': true,
            change: function (obj) {
            	console.log(obj);
            	$('#zip').val(obj.zip);
            	update_full();
            }
    	});
    	
    	
	/*$()
        .add($region)
        .add($district)
        .add($city)
        .add($street)
        .add($building)
        .fias({
        	//parentInput: $container.find('.js-form-address'),
            	verify: true,
            	change: function (obj) {
			console.log(obj);
		},
            	select: function (obj) {
                	if (obj.zip) $zip.val(obj.zip);//Обновляем поле zip
                	//setLabel($(this), obj.type);
                	//$tooltip.hide();
            	},
            	check: function (obj) {
                	var $input = $(this);

                	if (obj) {
	                   	// setLabel($input, obj.type);
                    		//$tooltip.hide();
                	}
                	else {
                    		//showError($input, 'Ошибка');
                	}
            	},
            	checkBefore: function () {
                	var $input = $(this);

                	if (!$.trim($input.val())) {
                    		$tooltip.hide();
                    	return false;
                }
            }
        });
        $region.fias('type', $.fias.type.region);
    	$district.fias('type', $.fias.type.district);
    	$city.fias('type', $.fias.type.city);
    	$street.fias('type', $.fias.type.street);
    	$building.fias('type', $.fias.type.building);

    	$district.fias('withParents', true);
    	$city.fias('withParents', true);
    	$street.fias('withParents', true);
    	$building.fias('verify', true);
    	$zip.fiasZip($('#adr_con'));*/
	
	
})