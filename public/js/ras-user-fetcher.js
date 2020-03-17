(function($) {
	'use strict';
	//console.log('Hey-ya');
	console.log(php_vars);


    $(document).ready(function() {
    	$('#ras-user-fetcher').jtable({
			title: 'Here are some awesome users ...',
			actions: {
				listAction: php_vars.user_endpoint
				},
			fields: {
				id: {
						key: true,
						list: false
					},
				name: {
						title: 'Name',
						width: '25%'
					},
				username:{
						title: 'User Name',
						width: '25%'
				},
				email:{
						title: 'Email',
						width: '25%'
				},
				phone:{
						title: 'Phone',
						width: '25%'
				},
				website:{
					title: 'website',
					width: '25%'
				}
			}	
			});

		$('#ras-user-fetcher').jtable('load');
       

    });
})(jQuery);
