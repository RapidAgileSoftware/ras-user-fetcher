(function($) {
	'use strict';

	function showUserDetails(user){
		
		// initiate a dedicated child table
        $('#ras-user-fetcher').jtable('openChildTable', $('#ras-user-fetcher-details'),
            {
                title: user.name + ' - Details',
                	actions: {
                    	listAction: php_vars.user_endpoint +'&user_id='+ user.id,
                    },
                    fields: {
                    	id: {
                        	title: 'Id',
							key: true,
							list: true,
							width: '20%',
                            },
                        name: {
							title: 'Name',
							width: '40%',	
							},          
                    }
            }, 
            function (data) { //opened handler
            	data.childTable.jtable('load');
            });
                     
	}

    $(document).ready(function() {
    	// Initiate parent User table
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
						width: '20%',
						display: function (user){
							var $link = $('<a href="#'+user.record.id+'">'+user.record.id+"</a>");
							$link.click(function () { showUserDetails(user.record); });
							return $link;
							}

					},
				name: {
						title: 'Name',
						width: '40%',
						display: function (user){
							var $link = $('<a href="#'+user.record.id+'">'+user.record.name+"</a>");
							$link.click(function () { showUserDetails(user.record); });
							return $link;
							}
					},
				username:{
						title: 'User Name',
						width: '40%',
						display: function (user){
							var $link = $('<a href="#'+user.record.id+'">'+user.record.username+"</a>");
							$link.click(function () { showUserDetails(user.record); });
							return $link;
							}
						}
					}	
			});

		$('#ras-user-fetcher').jtable('load');
		
       

    });
})(jQuery);
