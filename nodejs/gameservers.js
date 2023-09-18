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
    port = env.NODE_SERVER_PORT2,
    fs = require('fs'),
	cors = require('cors'),
	express = require('express'),
	query = require('game-server-query'),
	app = express(),
    server = null;

/* environnement */
if(env.APP_ENV == 'production') 
{
    console.log = function(){};
}

/* mode https/http */
if(env.NODE_HTTPS == 'on') 
{
    server = require('https').createServer({
        key: fs.readFileSync(env.SSL_KEY),
        cert: fs.readFileSync(env.SSL_CERT)
    }, app);
} 
else 
{
    server = require('http').createServer(app);
}

app.get('/:game/:host/:port', function(req, res) 
{
	var port = parseInt(req.params.port);
	if( port > 0 && port < 65536)
	{
		query(
			{
				type: req.params.game,
				host: req.params.host,
				port: port
			},
			function(state) 
			{
				res.json(state);
				res.end();
			}
		);
	}
	else
	{
		res.json({'error':'port range > 0 and < 65536'});
		res.end();
	}
});

server.listen(port);