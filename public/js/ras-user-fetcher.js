(function($) {
	'use strict';

	// responsible for rendering the user details with jTable 
	function showUserDetails(user){
		//scroll to user details
		$('html, body').animate({ scrollTop: $("#ras-user-fetcher-details").offset().top}, 1000);

		// initiate a dedicated child table
        $('#ras-user-fetcher').jtable('openChildTable', $('#ras-user-fetcher-details'),
            {
                title: '<h3>'+user.name + '</h3>',
                	actions: {
                    	listAction: php_vars.user_api +'?action=user-details&id='+ user.id,
                    },
                    fields: {
                    	id: {
							key: true,
							list: false,
                            },
                        email: {
							title: 'Email'
							},
						phone: {
							title: 'Phone'
						},
						website: {
							title: 'Website'	
						},
						address: {
							title: 'Address',
							display: function(user){
								var address = $("<span>"+user.record.address.street+"<br>"+user.record.address.suite+"<br>"+user.record.address.zipcode+" "+user.record.address.city+"<br> Geo:<br> Lat:"+user.record.address.geo.lat+"<br> Long:"+user.record.address.geo.lng+"</span>");
								return address;
							},
						},
						company: {
							title: 'Company',
							width: '20%',
							display: function(user){
								var company = $("<span><b>"+user.record.company.name+"</b><br><i>"+user.record.company.catchPhrase+"</i><br>"+user.record.company.bs+"</span>");
									return company;
							},
						},
						// provide access to user related albums, posts and todos
						albums: {
							title: 'Albums',
							display: function(user){
								var $button = $('<button />').text('View').click(
									function()
									{
										$('#ras-user-fetcher').jtable('openChildTable', $button.closest('tr'),
                                    		{
                                        		title: '',
                                        		actions: {
                                            		listAction: php_vars.user_api +'?action=user-albums&id='+ user.record.id,
                                            
                                        		},
                                        		fields: {
                                        			id: {
                                        				title: "Album Id"
                                        			},	
                                            		title: {
                                                		title: "Album Title",
                                                	},
                                                	
                                        		}
                                    		}, 
                                    		function (data) { data.childTable.jtable('load');}
                                    	);
									});
								return $button;
							},
						},
						posts: {
							title: 'Posts',
							display: function(user){
								var $button = $('<button />').text('View').click(
									function()
									{
										$('#ras-user-fetcher').jtable('openChildTable', $button.closest('tr'),
                                    		{
                                        		title: '',
                                        		actions: {
                                            		listAction: php_vars.user_api +'?action=user-posts&id='+ user.record.id,
                                            
                                        		},
                                        		fields: {
                                        			id: {
                                        				title: "Post Id"
                                        			},	
                                            		title: {
                                                		title: "Post Title",
                                                	},
                                                	body: {
                                                		title: "Post Body",
                                                	},
                                        		}
                                    		}, 
                                    		function (data) { data.childTable.jtable('load');}
                                    	);
									});
								return $button;
							},
						},
						todos: {
							title: 'ToDos',
							display: function(user){
								var $button = $('<button />').text('View').click(
									function()
									{
										$('#ras-user-fetcher').jtable('openChildTable', $button.closest('tr'),
                                    		{
                                        		title: '',
                                        		actions: {
                                            		listAction: php_vars.user_api +'?action=user-todos&id='+ user.record.id,
                                            
                                        		},
                                        		fields: {
                                        			id: {
                                        				title: "ToDo Id"
                                        			},	
                                            		title: {
                                                		title: "Todo Title"
                                                	},
                                                	completed:{
                                                		title: "Completed?"
                                                	}
                                                	
                                        		}
                                    		}, 
                                    		function (data) { data.childTable.jtable('load');}
                                    	);
									});
								return $button;
							},
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
			title: '',
			actions: {
				listAction: php_vars.user_api +'?action=list-users'
				},
			fields: {
				id: {
						title: 'Id',
						key: true,
						list: true,
						width: '20%',
						display: function (user){
							var $link = $('<a href="#ras-user-fetcher-details">'+user.record.id+"</a>");
							$link.click(function (event) { event.preventDefault(); showUserDetails(user.record); return false;});
							return $link;
							}

					},
				name: {
						title: 'Name',
						width: '40%',
						display: function (user){
							var $link = $('<a href="#ras-user-fetcher-details">'+user.record.name+"</a>");
							$link.click(function (event) { event.preventDefault(); showUserDetails(user.record); return false;});
							return $link;
							}
					},
				username:{
						title: 'User Name',
						width: '40%',
						display: function (user){
							var $link = $('<a href="#ras-user-fetcher-details">'+user.record.username+"</a>");
							$link.click(function (event) { event.preventDefault(); showUserDetails(user.record); return false;});
							return $link;
							}
						}
					}	
			});

		$('#ras-user-fetcher').jtable('load');
		
       

    });
})(jQuery);
