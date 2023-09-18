#!/usr/bin/env node


/* base path */
var base_path = __dirname.replace('resources/node', '');

/* dotenv*/
require('dotenv').config({
    path: base_path +'/../.env'
});

/* variables */
var
    env = process.env,
    port = env.NODE_SERVER_PORT,
    redis = require('ioredis'),
    redis_client = new redis(),
    redis_broadcast = new redis(),
    cookie = require('cookie'),
    crypto = require('crypto'),
    PHPUnserialize = require('php-unserialize'),
    fs = require('fs'),
    server = null,
    offline_timeout = {},
    users = {},
	appKey = env.APP_KEY,
	connectedUsers = [],
	mysql = require('mysql'),
	connection = mysql.createConnection({
		host     : env.DB_HOST,
		user     : env.DB_USERNAME,
		password : env.DB_PASSWORD,
		database : env.DB_DATABASE
	});

	
	
/* APP_KEY */
if(appKey.startsWith('base64:'))
{
    appKey = new Buffer(appKey.substring(7), 'base64');
}

/* environnement */
if(env.APP_ENV == 'production') 
{
    console.log = function(){};
}

/* redis subscribed */
redis_broadcast.psubscribe('*', function(err, count) 
{

});

/* broadcast */
redis_broadcast.on('pmessage', function(subscribed, channel, message) 
{
    message = JSON.parse(message);
    io.emit(channel, message.data);
	//console.log(message);
});

/* mode https/http */
if(env.NODE_HTTPS == 'on') 
{
    server = require('https').createServer({
        key: fs.readFileSync(env.SSL_KEY),
        cert: fs.readFileSync(env.SSL_CERT)
    });
} 
else 
{
    server = require('http').createServer();
}

/* start socket */
console.log('Server on Port : ' + port);
server.listen(port);
var io = require('socket.io')(server);

/* checking user */
io.use(function(socket, next) 
{

    if(typeof socket.request.headers.cookie != 'undefined') 
	{
		//console.log('laravel:' + decryptCookie(cookie.parse(socket.request.headers.cookie).laravel_session));
		
		/* 
		 * laravel:laravel_session
		 * cache.php : 'prefix' => 'laravel'
		 * session.php : 'cookie' => 'laravel_session',
		 */
		
        redis_client.get('laravel:' + decryptCookie(cookie.parse(socket.request.headers.cookie).laravel_session), function(error, result) 
		{
			console.log(error);
			console.log(result);
			
			if (error) 
			{
				console.log('ERROR');
				next(new Error(error));
			}
			else if (result) 
			{
				console.log('Logged In');
				next();
			}
			else 
			{
				console.log('Not Authorized 2');
				next(new Error('Not Authorized 2'));
			}
        });
    } 
	else 
	{
        console.log('Not Authorized');
        next(new Error('Not Authorized'));
    }
});

/* User have been checked we can put our function here */
io.on('connection', function (socket) 
{	
    socket.on('user_info', function(user_info) 
	{

        clearTimeout(offline_timeout[user_info.id]);

        if(!users[user_info.id]) 
		{
            socket.user_id = user_info.id;
			user_info.online = 1;
        }
        else 
		{
            socket.leave(users[user_info.id]);
			users[user_info.id].location = user_info.location;
			user_info.online = 1;
        }

		connectedUsers[user_info.id] = user_info;
        socket.join('user_' + user_info.id);
		io.emit('users', connectedUsers);
		
		//connection.connect();
		connection.query('UPDATE users SET online = 1, last_activity = NOW() WHERE id = ' + user_info.id + '', function(err, rows, fields) 
		{
			if (!err)
				console.log('The solution is: ', rows);
			else
				console.log('Error while performing Query.');
		});
		//connection.end();

		console.log('user joined '+ user_info.id);
		console.log(connectedUsers);
    });

    socket.on('disconnect', function () 
	{
        if(socket.user_id) 
		{
            offline_timeout[socket.user_id] = setTimeout(
                function() 
				{
                    console.log('user ' + socket.user_id + ' disconnected');
                    delete users[socket.user_id];
					connectedUsers[socket.user_id].online = 0;
					//connectedUsers.splice(connectedUsers.indexOf(socket.user_id), 1);
					io.emit('users', connectedUsers);
					connection.query('UPDATE users SET online = 0, last_activity = NOW() WHERE id = ' + socket.user_id + '', function(err, rows, fields) 
					{
						if (!err)
							console.log('The solution is: ', rows);
						else
							console.log('Error while performing Query.');
					});

                }, 15000
            );
        }
    });
	
});

/* decrypt cookie (laravel_session) */
function decryptCookie(cookie)
{
	if(typeof cookie != 'undefined')
	{
		var parsedCookie = JSON.parse(new Buffer(cookie, 'base64'));

		var iv = new Buffer(parsedCookie.iv, 'base64');
		var value = new Buffer(parsedCookie.value, 'base64');

		var decipher = crypto.createDecipheriv('aes-256-cbc', appKey, iv);

		var resultSerialized = Buffer.concat([
			decipher.update(value),
			decipher.final()
		]);


		return PHPUnserialize.unserialize(resultSerialized.toString('utf8'));
	}
}