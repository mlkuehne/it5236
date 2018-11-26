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
	validator.validateUsername(event.username, errors);
	validator.validatePasswordHash(event.passwordHash, errors);
	
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
		var sql = "SELECT userid, passwordhash, email, emailvalidated FROM users WHERE username = ?";
		
		conn.query(sql, [event.username], function (err, result) {
		  	if (err) {
				// This should be a "Internal Server Error" error
				callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
		  	} else {
		    	if(result == 0){
		    		errors.push("Bad username");
		    		callback(formatErrorResponse('BAD_REQUEST', errors));
		    	} else {
		    		if(result[0].passwordhash != [event.passwordHash]){
		    			errors.push("Bad password");
		    			callback(formatErrorResponse('BAD_REQUEST', errors));
		    		} else if (result[0].emailvalidated == 0){
		    			errors.push("Email not validated");
		    			callback(formatErrorResponse('BAD_REQUEST', errors));
		    		} else {
		    			// how to include the newsession?? ask in chat later
		    			console.log("successful login");
					    callback(null,"user login successful");
		    		}
		    	}
			} //good code count
		}); //query registration codes
		}); //connect database
	} //no validation errors
} //handler
