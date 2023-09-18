var express = require('express');
var app = express();

app.listen(3000, function(err) {
    if(err){
       console.log(err);
       } else {
       console.log("listen:3000");
    }
});

//something useful
app.get('*', function(req, res) {
  res.status(200).send('ok')
});