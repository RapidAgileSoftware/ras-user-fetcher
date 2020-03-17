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
						title: 'Id',
						key: true,
						list: true,
						width: '20%'

					},
				name: {
						title: 'Name',
						width: '40%'
					},
				username:{
						title: 'User Name',
						width: '40%'
				}	
			}	
			});

		$('#ras-user-fetcher').jtable('load');
       

    });
})(jQuery);
