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
	   validator.validateThingID(event.thingid, errors);
	
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
		var sql = "SELECT things.thingid, things.thingname, convert_tz(things.thingcreated,@@session.time_zone,'America/New_York') as thingcreated, things.thinguserid, things.thingattachmentid, things.thingregistrationcode, username, filename FROM things LEFT JOIN users ON things.thinguserid = users.userid LEFT JOIN attachments ON things.thingattachmentid = attachments.attachmentid WHERE thingid = ?";
		
		conn.query(sql, [event.thingid], function (err, result) {
		  	if (err) {
				// This should be a "Internal Server Error" error
				callback(formatErrorResponse('INTERNAL_SERVER_ERROR', [err]));
		  	} else if (!result[0]) {
		    	console.log("thing not found");
		    	callback(formatErrorResponse('BAD_REQUEST', [err]));
			} else {
				var json = { 
					thingid : event.thingid,
					thingname : result[0].thingname,
					thingcreated : result[0].thingcreated,
					thinguserid : result[0].thinguserid,
					thingattachmentid : result[0].thingattachmentid,
					thingregistrationcode : result[0].thingregistrationcode,
					username : result[0].username,
					filename : result[0].filename
				}
				
				callback(null, json);
			} //good code count
		}); //query registration codes
		}); //connect database
	} //no validation errors
} //handler
