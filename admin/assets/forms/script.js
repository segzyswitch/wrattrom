$(document).ready( function() {
	// alert();
	// New User
	$("#registerForm").on('submit', function(){
	  event.preventDefault();

	  $.ajax({
	    url: "config/process.php",
	    type: "POST",
	    data: new FormData(this),
	    cache: false,
	    contentType: false,
	    processData: false,
	    beforeSend: function() {
		    $("#registerForm .submit-btn").html("Loading <i class='fa fa-cog fa-spin'></i>");
	    },
	    success: function(data) {
		    $("#registerForm .submit-btn").html("Create New Profile");
		    if ( data.search('success') !== -1 ) {
		    	$("#registerForm .feedback").html(data);
		    	$("#registerForm input").val('');
		    	$("#registerForm select").val('');
		    }else {
		      $("#registerForm .feedback").html(data);
		    }
	    },
	    error: function() {
		    $("#registerForm .submit-btn").html("Create New Profile");
	    	$("#registerForm .feedback").html("<div class='alert alert-danger'>An error occured, try again!</div>");
	    }
	  });
	});

	// planForm
	$("#planForm").on('submit', function(){
	  event.preventDefault();

	  $.ajax({
	    url: "config/process.php",
	    type: "POST",
	    data: new FormData(this),
	    cache: false,
	    contentType: false,
	    processData: false,
	    beforeSend: function() {
	    	$("#planForm .submit-btn").addClass('disabled');
		    $("#planForm .submit-btn").html("Loading <i class='spinner-border spinner-border-sm'></i>");
	    },
	    success: function(data) {
	    	$("#planForm .submit-btn").removeClass('disabled');
		    $("#planForm .submit-btn").html("Submit");
		    if ( data.search('success') !== -1 ) {
		    	$("#planForm input").val('');
		    	$("#planForm textarea").val('');
		    	window.location.href = 'investments-plans?message='+data;
		    }else {
		    	notify('warning', data);
		    }
	    },
	    error: function() {
	    	$("#planForm .submit-btn").removeClass('disabled');
		    $("#planForm .submit-btn").html("Submit");
		    notify('danger', 'An unknown error occured, try again')
	    }
	  });
	});

	// updateUser
	$("#updateUser").on('submit', function(){
	  event.preventDefault();

	  $.ajax({
	    url: "config/process.php",
	    type: "POST",
	    data: new FormData(this),
	    cache: false,
	    contentType: false,
	    processData: false,
	    beforeSend: function() {
	    	$("#updateUser .submit-btn").addClass('disabled');
		    $("#updateUser .submit-btn").html("Loading <i class='spinner-border spinner-border-sm'></i>");
	    },
	    success: function(data) {
	    	$("#updateUser .submit-btn").removeClass('disabled');
		    $("#updateUser .submit-btn").html("Submit");
		    if ( data.search('success') !== -1 ) {
		    	$("#updateUser input").val('');
		    	$("#updateUser textarea").val('');
		    	window.location.reload();
		    }else {
		    	notify('warning', data);
		    }
	    },
	    error: function() {
	    	$("#updateUser .submit-btn").removeClass('disabled');
		    $("#updateUser .submit-btn").html("Submit");
		    notify('danger', 'An unknown error occured, try again')
	    }
	  });
	});

	// new Wallet Form
	$("#newWalletForm").on('submit', function(){
	  event.preventDefault();

	  $.ajax({
	    url: "config/process.php",
	    type: "POST",
	    data: new FormData(this),
	    cache: false,
	    contentType: false,
	    processData: false,
	    beforeSend: function() {
	    	$("#newWalletForm .submit-btn").addClass('disabled');
		    $("#newWalletForm .submit-btn").html("Loading <i class='spinner-border spinner-border-sm'></i>");
	    },
	    success: function(data) {
	    	$("#newWalletForm .submit-btn").removeClass('disabled');
		    $("#newWalletForm .submit-btn").html("Submit");
		    if ( data.search('success') !== -1 ) {
		    	// $("#newWalletForm input").val('');
		    	notify('success', data);
		    	$(".modal").modal('hide')
		    }else {
		    	notify('warning', data);
		    }
	    },
	    error: function() {
	    	$("#newWalletForm .submit-btn").removeClass('disabled');
		    $("#newWalletForm .submit-btn").html("Submit");
		    notify('danger', 'An unknown error occured, try again')
	    }
	  });
	});

	// funding Form
	$("#fundingForm").on('submit', function(){
	  event.preventDefault();

	  $.ajax({
	    url: "config/process.php",
	    type: "POST",
	    data: new FormData(this),
	    cache: false,
	    contentType: false,
	    processData: false,
	    beforeSend: function() {
	    	$("#fundingForm .submit-btn").addClass('disabled');
		    $("#fundingForm .submit-btn").html("Loading <i class='spinner-border spinner-border-sm'></i>");
	    },
	    success: function(data) {
	    	$("#fundingForm .submit-btn").removeClass('disabled');
		    $("#fundingForm .submit-btn").html("Fund wallet");
		    if ( data.search('success') !== -1 ) {
		    	notify('success', data);
					console.log(data);
					window.location.reload;
		    }else {
		    	notify('warning', data);
		    }
	    },
	    error: function() {
	    	$("#fundingForm .submit-btn").removeClass('disabled');
		    $("#fundingForm .submit-btn").html("Fund wallet");
		    notify('danger', 'An unknown error occured, try again')
	    }
	  });
	});

	// confirmForm
	$("#confirmForm").on('submit', function(){
	  event.preventDefault();
	  $.ajax({
	    url: "config/process.php",
	    type: "POST",
	    data: new FormData(this),
	    cache: false,
	    contentType: false,
	    processData: false,
	    beforeSend: function() {
	    	$("#confirmForm .submit-btn").addClass('disabled');
		    $("#confirmForm .submit-btn").html("Loading <i class='spinner-border spinner-border-sm'></i>");
	    },
	    success: function(data) {
	    	// return console.log(data.message)
	    	$("#confirmForm .submit-btn").removeClass('disabled');
		    $("#confirmForm .submit-btn").html("Delete");
		    if ( data.message.search('success') !== -1 ) {
		    	$("#tRow"+data.id).addClass('bg--danger');
		    	$("#tRow"+data.id).hide(1000);
		    	notify('success', data.message);
		    	$(".modal").modal('hide');
		    }else {
		    	notify('warning', data);
		    }
	    },
	    error: function() {
	    	$("#confirmForm .submit-btn").removeClass('disabled');
		    $("#confirmForm .submit-btn").html("Delete");
		    notify('danger', 'An unknown error occured, try again')
	    }
	  });
	});

});