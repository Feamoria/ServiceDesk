var ex_user_mass = [];
var arr_st={
            		"0":{name:'Заявка подана',css:'label label-danger'},
            		"1":{name:'Заявка в работе',css:'label label-warning'},
            		"2":{name:'Заявка выполнена',css:'label label-success'},
            		};
            		
function opn_add_user(i)
{
	if (i===2) {
		$('#op').val("edit");
		$.ajax({
    			async: true,
    			type : 'POST',
    			url : 'api/users.php?get',
   	 		//data : data,
   	 		dataType:'json',
   	 		success: function (data) {
   	 			console.log(data);
   	 			$('#fm_add_user1')[0].reset();
   	 			var user = data.data[0];
   	 			$('#login').val(user.login);
   	 			$('#fio').val(user.fio);
   	 			$('#tel').val(user.telephone);
   	 			$('#address').val(user.address);
   	 			$('#type').val(user.role);
   	 		}
		})
	} else {$('#op').val("add");}
	$('#fm_add_user').dialog("open");
	

}

function send_mess(id){

	let mess=$('#message_user').val();
	$.ajax({
	        async: true,
	        type : 'POST',
	        dataType:'json',
	        url : 'api/log.php?set_mess',
	        data : 'id='+id+'&mess='+mess,
	        success: function (data) {
	   
	        	//show_mess(id);
	        	//$('#fm_tack').dialog("close");
	        	//opn_tack(id);
	        	
		}
        });

}
function show_mess(id) {
	$.ajax({
	        async: true,
	        type : 'POST',
	        dataType:'json',
	        url : 'api/log.php?show_comment',
	        data : 'id='+id,
	        success: function (data) {
	        	//task_mess
	        	console.log(data.data);
	        	let html_st="<div class='' style='max-height: 300px; overflow: auto;'><table class='table table-bordered'>"+
	        	"<thead class=''><tr><th>Дата/Время</th><th>ФИО</th><th>Сообщение</th></tr></thead><tbody class='' id='task_table_body'>";
	        	if (typeof(data.data)!=='undefined') {
				$.each( data.data, function( key, val ) {
					html_st+="<tr><td>"+val.dt_message+"</td><td>"+val.fio  +"</td><td>"+val.message+"</td></tr>";
				})
			}
			html_st+="</tbody></table></div><textarea class='form-control'  id='message_user'></textarea><button class='btn btn-lg btn-primary btn-block' id='btn_mess'>Отправить</button>"
	        	$('#task_mess').html(html_st);
	        	$('#btn_mess').on('click',function(event){
	        		event.preventDefault();
	        		
	        		send_mess(id);
	        		$('#fm_tack').dialog("close");
	        		opn_tack(id)
	        		//show_mess(id);
	        	})
		}
        });

}

function show_log(i){
	$.ajax({
	        async: true,
	        type : 'POST',
	        dataType:'json',
	        url : 'api/log.php?show_log',
	        data : 'id='+i,
	        success: function (data) {
	        	let html_st="<table class='table table-bordered'>"+
	        	"<thead><tr><th>Дата/Время</th><th>Статус</th></tr></thead><tbody id='task_table_body'>"
	   		$.each( data.data, function( key, val ) {
	            		html_st+="<tr><td>"+val.dt_status+"</td><td>"+"<span class='"+arr_st[val.status].css+"'>"+arr_st[val.status].name+"</span>"+"</td></tr>";
            		})
            		html_st+="</tbody></table>"
	        	$('#task_log').html(html_st);
		}
        });
}
function opn_tack(i)
{
	
	$('#detTack, #detTack2').show();
	$('#op_tack').val("edit");
	$('#tackMain').removeClass('col-md-6').addClass('col-md-6');
	$('#fm_tack1').removeClass('form-signin').addClass('form-signin');
	if (i===0) {
		$('#op_tack').val("add");
		$('#detTack,#detTack2').hide();
		$('#tackMain').removeClass('col-md-6');
		
		$('#PC').prop('disabled', false);
		$('#message').prop('disabled', false);
		$("#btn_fm_tack").show();
		
		$('#fm_tack').dialog("open");
			
	} else {
	 console.log(i);
	 //TODO Чтение инфы о заявке
	 $.ajax({
	        async: true,
	        type : 'POST',
	        dataType:'json',
	        url : 'api/task.php?show',
	        data : 'op_tack=show&id='+i,
	        success: function (data) {
	        	let task=data.data[0]
	        	//console.log(task);
	        	/*N,DT_cr,fio_owner,status,PC,message*/
	        	$('#N').html(task.N);
	        	$('#DT_cr').val(task.DT_create);
	        	$('#fio_owner').val(task.FIO_owner);
	        	$('#fio_executor').val(task.FIO_executor);
	        	$('#status').html("<span class='"+arr_st[task.status].css+"'>"+arr_st[task.status].name+"</span>");
	        	$('#PC').val(task.inv+" из "+task.place);
	        	$('#message').val(task.message);
	    
	        	$('#fm_tack1').removeClass('form-signin');
	        	$("#btn_fm_tack").hide();
	        	$('#PC').prop('disabled', true);
	        	$('#message').prop('disabled', true);
	        	show_mess(i);
	        	show_log(i);
	        	$('#fm_tack').dialog("open");
        	}
        });
        
        
        
	 
	 //$('#fm_tack').dialog("open");
	}

	
}

function btn_change_ex(id){

	$('#ex'+id+' >select').show();
	$('#ex'+id+' >select').unbind('change');
	$('#ex'+id+' >select').on('change',function(){
		change_ex(id)
	});
	$('#ex'+id+' >span').hide();
}

function change_ex(id) {
	let st=$('#ex'+id+' >select').val();
	$.ajax({
    			async: true,
    			type : 'POST',
    			url : 'api/task.php',
   	 		data : 'op_tack=chg_ex&id='+id+'&ex='+st,
   	 		success: function (data) {
   	 			show_task();
   	 		}
		})
}


function btn_change_status(id){

	$('#stat'+id+' >select').show();
	$('#stat'+id+' >select').unbind('change');
	$('#stat'+id+' >select').on('change',function(){
		change_status(id)
	});
	$('#stat'+id+' >span').hide();
}

function change_status(id){
	let st=$('#stat'+id+' >select').val();
	$.ajax({
    			async: true,
    			type : 'POST',
    			url : 'api/task.php',
   	 		data : 'op_tack=chg_st&id='+id+'&st='+st,
   	 		success: function (data) {
   	 			show_task();
   	 			
   	 		}
		})
}

function show_task(search) {
//запрос списка исполнителей
	if(!search){search=''};
	$("#task_table th span").each(function(){$(this).removeClass('glyphicon glyphicon-arrow-up glyphicon-arrow-down')})
    $.ajax({
    		async: 0,
    		type : 'POST',
    		dataType:'json',
    		url : 'api/users.php?GetEx',
   	 	success: function (data) {
   	 		ex_user_mass=data.data;
   	 	}
	})
    $.ajax({
        async: true,
        type : 'POST',
        dataType:'json',
        url : 'api/task.php?show',
        data : 'op_tack=show&search='+search,
        success: function (data) {
            console.log(data);
            if (data.result==='ok') {
            	
            	let html_st='<select style="display: none;">';
            	$.each( arr_st, function( key, val ) {
	            	html_st+="<option value='"+key+"'>"+val.name+"</option>";
            	})
            	html_st+='</select>'
            	let html_ex='<select style="display: none;">';
            	$.each( ex_user_mass, function( key, val ) {
	            	html_ex+="<option value='"+val.id+"'>"+val.fio+"</option>";
            	})
            	html_ex+='</select>';
            	let tbl=data.data;
            	let type=data.type_user;
            	let st='';
            	$.each( tbl, function( key, value ) {
  		
  			let stat=value.status;
  			let executor = value.FIO_executor+'';
  			if (executor === "null") {executor='';}
  			if (type=='1') {
  				stat = "<span class='"+arr_st[stat].css+"'>"+arr_st[stat].name+"</span>"+html_st+
  				"<button class='btn btn-xs btn-info' onclick='btn_change_status("+value.N+")'>"+
  				"<span class='glyphicon glyphicon-pencil'></span></button>";
  				executor="<span class='label label-success'>"+executor+"</span>"+html_ex+
  				"<button class='btn btn-xs btn-info' onclick='btn_change_ex("+value.N+")'>"+
  				"<span class='glyphicon glyphicon-pencil'></span></button>"
  				}
  			else if(type=='0') {
  				stat = "<span class='"+arr_st[stat].css+"'>"+arr_st[stat].name+"</span>";
  		
  			}
  			st+="<tr>"
  			+"<td>"+value.N+"</td>"
  			+"<td>"+value.FIO_owner+"</td>"
  			+"<td>"+value.DT_create+"</td>"
  			+"<td>"+value.inv+" в "+value.place+"</td>"
  			+"<td id='stat"+value.N+"'>"+stat+"</td>"
  			+"<td>"+value.message+"</td>"
  			+"<td id='ex"+value.N+"'>"+executor+"</td>"
  			+"<td><button class='btn btn-xs btn-primary' onclick='opn_tack("+value.N+")' >Открыть</button></td>"
  			+"</tr>";
		});
		$('#task_table_body').html(st)
            }
           
        }
    })

}

$(document).ready(function () {
	show_task();
	var fm_add_user= $('#fm_add_user, #fm_tack').dialog({
        	autoOpen: false,
        	height: 550,
        	width: 900,
        	modal: true,
    	});
    	//$( "#type" ).selectmenu();
	$( "#PC" ).autocomplete({
	      source: "api/search.php?InvPC",
	      minLength: 2,
	      select: function( event, ui ) {
	      		console.log(ui.item)
	      		$('#PC_id').val(ui.item.id);
      		}
    	});
    	
		
    	$('#btn_fm_tack').on('click',function(event){
    		event.preventDefault();
    		var data=$('#fm_tack1').serialize();
    		$.ajax({
    			async: true,
    			type : 'POST',
    			url : 'api/task.php?'+$('#op_tack').val(),
   	 		data : data,
   	 		success: function (data) {
   	 			show_task();
   	 			fm_add_user.dialog("close");
   	 		}
		})
    	
    	});
    	
    	$('#submit_fm_add_user').on('click',function(event){
    		event.preventDefault();
    		var data=$('#fm_add_user1').serialize();
    		//console.log(data);
    		$.ajax({
    			async: true,
    			type : 'POST',
    			url : 'api/users.php?'+$('#op').val(),
   	 		data : data,
   	 		success: function (data) {
   	 		
   	 			fm_add_user.dialog("close");
   	 		}
		})
    	
    	});
     $('#search').on('keyup',function(event){
     	//console.log($(this).val())
     	show_task($(this).val());
     })
    $('#task_table th').click(function(){
        var table = $(this).parents('table').eq(0)
        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
        this.asc = !this.asc
        if (!this.asc){rows = rows.reverse()}
        for (var i = 0; i < rows.length; i++){table.append(rows[i])}
        //glyphicon glyphicon-arrow-up
        //glyphicon glyphicon-arrow-down
         let ico='';
        if (this.asc) {
        	ico="glyphicon-arrow-down"
        } else {
        	ico="glyphicon-arrow-up"
        }
        $("#task_table th span").each(function(){$(this).removeClass('glyphicon glyphicon-arrow-up glyphicon-arrow-down')})
        //console.log($(this.firstElementChild));
        $(this.firstElementChild).addClass('glyphicon '+ico);
        //$(this).html($(this).html()+'[^]')
    })
    function comparer(index) {
        return function(a, b) {
            var valA = getCellValue(a, index), valB = getCellValue(b, index)
            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
        }
    }
    function getCellValue(row, index){ return $(row).children('td').eq(index).text() }
    	
})