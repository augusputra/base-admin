function show_alert(strong, desc, type, position)
{
	if(strong && desc && type && position)
	{
    $([document.documentElement, document.body]).animate({
        scrollTop: $(position).offset().top-100
    }, 500);
		$(position).prepend('<div class="alert alert-'+type+' alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'+strong+'!</strong> '+desc+'</div>');
	}
	
}		

function show_loading()
{
  Swal.close();
  Swal.fire({
    title: "Please wait!",
    text: "Processing Data.",
    allowOutsideClick: false,
    closeOnClickOutside: false,
    didOpen: function() {
      Swal.showLoading()
    }
  });
	//hide_loading();
	//$('body').append('<div class="loading-cover" style="position: fixed; left: 40%; right: 40%; top: 30%; bottom: 49%;"><center class="shadow-lg rounded bg-light" style="padding: 10px;"><div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div><br>Please Wait, Loading </center></div>');
}

function hide_loading()
{
  Swal.close();
	//$(document).find('.loading-cover').remove();
}

function redirect(url)
{
	window.location.replace(url);
}

$(document).on('submit','#form',function(e){
  if (!$(this).hasClass('no_ajax')) {
    e.preventDefault();
  	var url = $(this).attr('action');
  	//var data_form = $(this).serialize();

    var form = $(this)[0];
    var data_form = new FormData(form);

    var this_selector = $(this);
  	$.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        enctype: 'multipart/form-data',
        data: data_form,
        processData: false,
        contentType: false,
        cache: false,
        async: true,
        beforeSend: function()
        {
          $('button[type="submit"]').attr('disabled','');
          show_loading();
        },
        success: function(response)
        {
          $('button[type="submit"]').removeAttr('disabled');
          
          if(response.status=='SUCCESS')
          {
            show_alert('Success',response.message,'success','form');
            if(response.redirect)
            {
              redirect(response.redirect);
            }
            else
            {
              hide_loading();
            }
            if(response.callback)
            {
              this_selector.append('<script id="dump_js_'+(dump_js)+'">'+response.callback+' $("#dump_js_'+(dump_js++)+'").remove();</script>');
            }
          }
          else
          {
            hide_loading();
            show_alert('Failed',response.message,'danger','form');
          }
        	
          
        },
        error: function(xhr, ajaxOptions, thrownError)
        {
          switch (xhr.status) {
          case 419:
            $('button[type="submit"]').removeAttr('disabled');
            show_alert('Failed','This page expire, please refresh','danger','form');
          break;  
          default:
            $('button[type="submit"]').removeAttr('disabled');
            show_alert('Failed','server not response','danger','form');
          break;
          }
          hide_loading();
        }
      });
  }
});

let dump_js=0;

function get_api(url,element)
{
  $.ajax({
      url: url,
      method: 'GET',
      dataType: 'json',
      async: true,
      beforeSend: function()
      {
        show_loading();
      },
      success: function(response)
      {
        if(response.status=='SUCCESS')
        {
          hide_loading();
          if(response.callback)
          {
            $(element).append('<script id="dump_js_'+(dump_js)+'">'+response.callback+' $("#dump_js_'+(dump_js++)+'").remove();</script>');
          }
        }
        else
        {
          hide_loading();
          //$(element).append('<script id="dump_js_'+(dump_js)+'"> alert("Error fetch data"); $("#dump_js_'+(dump_js++)+'").remove();</script>');
        }
      },
      error: function()
      {
        //$(element).append('<script id="dump_js_'+(dump_js)+'"> alert("Error fetch data"); $("#dump_js_'+(dump_js++)+'").remove();</script>');
        hide_loading();
      }
    });
}

function delete_confirmation(url)
{
  Swal.fire({
    title: 'Are you sure to delete this data?',
    showCancelButton: true,
    icon: 'question',
    confirmButtonText: `Yes`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      redirect(url);
    } else if (result.isDenied) {
      
    }
  })
}

$('#photo').on('change', function() {
  document.getElementById('previewThumbnail').src = window.URL.createObjectURL(this.files[0])  
});