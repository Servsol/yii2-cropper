(function ($) {
	
	$.fn.cropImage = function (config) {
		$("#input-id").attr("value", 'xyz.jpg');
		$("#cropper-box").hide();
        $("#cropImage").hide();
        
        var fileName;
        var extension;
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                	
                    var myFormData = new FormData();
                    	myFormData.append(config.name, input.files[0]);
                    var url = config.uploadUrl + '&inputName=' + config.name;
                    
                    //after image is selected, upload to tmp folder before displaying cropper
                    $.ajax({
                        type:"POST",
                        url: url,
                        data: myFormData,
                        processData: false,
                        contentType: false,
                        dataType : "json",
                        success:function(data){
                            $("#cropper-box").attr("src", data.file);
                            $("#cropper-box").cropper("destroy");
                            $("#cropper-box").show();
                            $("#cropper-box").cropper({aspectRatio: config.aspectRatio,});
                            $("#cropImage").show();
                            fileName = data.name;
                            extension = data.extension;
                            var shortExtension = extension.substring(6);
                            $.post(config.changeUrl +'&attribute=' + config.attribute + '&fileName=' + fileName + '.'+shortExtension,
                        		    config.model,
                        		    function(data)
                        		    {	
                            	  		var obj = JSON.parse(data);
                        		    	$("#contactform-subject_image").attr("value", obj.subject);
                        		    });
                        },
                        error: function(e){
                            console.log("error");
                        }
                    });
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#input-id").on("change", function() {
            readURL(this);
        });
        
        //after crop button is clicked save cropped image to uploads folder
        $("#cropImage").on("click", function() {
            $("#cropper-box").cropper("getCroppedCanvas").toBlob(function (blob) {
            	  var formData = new FormData();
                  formData.append(config.name, blob);
                  var url = config.uploadCroppedUrl + '&inputName=' + config.name + '&fileName=' + fileName; 
                  var shortExtension = extension.substring(6);
                  $.ajax({
                    method: "POST",
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType : "json",
                    success: function (data) {
                      $(".cropper-container").hide();
                      $("#cropper-box").attr('src', '');
                      $("#cropper-box").attr('src', data.file);
                      $("#cropper-box").attr('class', '');
                      $("#cropper-box").show();
                      $("#cropImage").hide();  
                      $("#input-id").attr("value", data.name);

                      model = JSON.stringify(config.model);
                      $.post(config.changeUrl +'&attribute=' + config.attribute + '&fileName=' + fileName + '_cropped.'+shortExtension,
                		    config.model,
                		    function(data)
                		    {	
                    	  		var obj = JSON.parse(data);
                		    	$("#contactform-subject_image").attr("value", obj.subject);
                		    });
                    },
                    error: function () {
                      console.log("Upload error");
                    }
                  });
            }, extension);

        });
    
	};

})(window.jQuery);