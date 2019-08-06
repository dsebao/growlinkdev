/*
AJAX - Send data using ajax
Receive data, use one callback for beforesend and another for handle output
*/


var getDates = function(startDate, endDate) {
    var dates = [],
        currentDate = startDate,
        addDays = function(days) {
          var date = new Date(this.valueOf());
          date.setDate(date.getDate() + days);
          return date;
        };
    while (currentDate <= endDate) {
      dates.push(currentDate);
      currentDate = addDays.call(currentDate, 1);
    }
    return dates;
  };


function ajaxSend(mydata,beforeSend,handleData,type = 'POST',datatype = 'json',globaltype = true){
    $.ajax({
        type: type,
        url: jsvar.ajaxurl,
        dataType: datatype,
        data: mydata,
        global: globaltype,
        beforeSend: function (data) {
            beforeSend(data);
        },
        success: function(data){
            console.log(data);
            handleData(data);
        },
        error: function(e){
            console.log(e);
            $.notify(e,{type: 'danger'});
        }
    });
}

function nav(){
    $('.navhoverdropdown').bootnavbar();
    var navm = $('#dash-menu');
    var url = navm.data('page');
    navm.find('a').each(function(){
    	var d = $(this);
		var href = d.attr('href');
		if (href === url)
			d.parent().addClass('active');
		else
			d.parent().removeClass('active');
	});
}



function ajaxForms(){
    var nonce = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': nonce}});

    $('form.s_form').validator().submit(function(event) {
        var form = $(this);

        if (event.isDefaultPrevented()) {
        } else{
            event.preventDefault();
            ajaxSend(form.serialize() + '&_userid=' + jsvar.userid + '&_wpn=' + jsvar.ajax_nonce,function(data){
                //Before send
                $('html, body').css("cursor", "auto");
            },function(out){
                //Success
                if(out.success){
                    if(out.url != '')
                        window.location.href = out.url;
                    if(out.message != '')
                    	$.notify(out.message,{type: 'success'});

                } else {
                    if(out.action){
                        form.find('.message').html('<div class="alert alert-'+out.type+'">'+out.message+'</div>');
                    } else {
                        $.notify(out.message + ' ' +out.error,{type: 'danger'});
                    }
                }
                if(out.resetform)
                    form.trigger('reset');
            });
        }
    });
}

jQuery(document).ready(function($) {

	nav();

	ajaxForms();
});