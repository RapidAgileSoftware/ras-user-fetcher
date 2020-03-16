(function($) {
	'use strict';
	//console.log('Hey-ya');
	//console.log(php_vars);
	function getUserData(){

		return [
			{
				id: 1,
				name: "Leanne Graham",
				username: "Bret",
				email: "Sincere@april.biz",
				address: {
					street: "Kulas Light",
					suite: "Apt. 556",
					city: "Gwenborough",
					zipcode: "92998-3874",
					geo: {
						lat: "-37.3159",
						lng: "81.1496"
					}
				},
				phone: "1-770-736-8031 x56442",
				website: "hildegard.org",
				company: {
					name: "Romaguera-Crona",
					catchPhrase: "Multi-layered client-server neural-net",
					bs: "harness real-time e-markets"
				}
			},
		] 
	}


    $(document).ready(function() {
    	$('#ras-user-fetcher').jtable({
			title: 'Table of people',
			actions: {
				listAction: php_vars.user_endpoint
				},
			fields: {
				id: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
				name: {
						title: 'Name',
						width: '20%'
					},
				username:{
						title: 'User Name',
						width: '20%'
				},
				email:{
						title: 'Email',
						width: '20%'
				},
				phone:{
						title: 'Phone',
						width: '20%'
				},
				website:{
					title: 'website',
					width: '20%'
				}
			}	
			});
		$('#ras-user-fetcher').jtable('load');
       

    });
})(jQuery);
