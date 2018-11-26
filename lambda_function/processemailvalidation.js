var mysql = require('./node_modules/mysql');
var config = require('./config.json');
var validator = require('./validation.js');

function formatErrorResponse(code, errs) {
	return JSON.stringify({ 
		error  : code,
		errors : errs
	});
}

exports.handler = (event, context, callback) => {
	//instruct the function to return as soon as the callback is invoked
	context.callbackWaitsForEmptyEventLoop = false;

	//validate input
	var errors = new Array();
	
	 // Validate the user input
	// validator.validateUsername(event.username, errors);
	// validator.validatePasswordHash(event.passwordHash, errors);
	// validator.validateEmail(event.email, errors);
	// validator.validateRegistrationCode(event.registrationcode, errors);
	
	if(errors.length > 0) {
		// This should be a "Bad Request" error
		callback(formatErrorResponse('BAD_REQUEST', errors));
	} else {
	
	//getConnection equivalent
	var conn = mysql.createConnection({
		host 	: config.dbhost,
		user 	: config.dbuser,
		password : config.dbpassword,
		database : config.dbname
	});
	
	//prevent timeout from waiting event loop
	context.callbackWaitsForEmptyEventLoop = false;

	//attempts to connect to the database
	conn.connect(function(err) {
	  	
		if (err)  {
			// This should be a "Internal Server Error" error
			callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
		};
		console.log("Connected!");
		var sql = "SELECT userid FROM emailvalidation WHERE emailvalidationid = ?";
		
		conn.query(sql, [event.validationid], function (err, result) {
		  	if (err) {
				// This should be a "Internal Server Error" error
				callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
		  	} else {
		    	if(!result[0]){
		    		console.log("invalid request");
		    		errors.push("That does not appear to be a valid request");
					callback(formatErrorResponse('BAD_REQUEST', errors));
		    	} else {
		    		var userid = result[0].userid;
		    		var sql = "DELETE FROM emailvalidation WHERE emailvalidationid = ?";
		    		
		    		conn.query(sql, [event.validationid], function (err, result) {
		    			if(err){
		    				// This should be a "Internal Server Error" error
							callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
		    			} else if (result.length != 0) {
		    				console.log("Email address validated");
		    				var sql = "UPDATE users SET emailvalidated = 1 WHERE userid = ?";
		    				conn.query(sql, [userid], function (err, result) {
		    					if(err){
		    						// This should be a "Internal Server Error" error
									callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
		    					} else {
		    						console.log("Email validation updated in users table");
		    						callback(null,"email validation successful");
		    					}
		    				});
		    			} else {
		    				console.log("invalid request");
		    				errors.push("That does not appear to be a valid request");
							callback(formatErrorResponse('BAD_REQUEST', errors));
		    			}
		    		});
		    	}
		  		
			} //good code count
		}); //query registration codes
		}); //connect database
	} //no validation errors
} //handler
