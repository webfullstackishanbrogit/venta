


var db;
//var updateurl = "http://localhost/testingzone/dbsyncexample/serverbackend/service.cfc?method=getupdates&returnformat=json";
var updateurl = "http://www.raymondcamden.com/demos/2012/apr/3/serverbackend/service.cfc?method=getupdates&returnformat=json";
function init() {
    document.addEventListener("deviceready",startup);
}



function dbError(e) {
    console.log("SQL ERROR");
    console.dir(e);
}


function initDB(tx) {
    tx.executeSql("create table if not exists docs(id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, body TEXT, lastupdated DATE, token TEXT)");
}

function dbReady() {
    console.log("DB initialization done.");
    //begin sync process
    if(navigator.network && navigator.network.connection.type != Connection.NONE) syncDB();
    else displayDocs();
}

function syncDB() {
    $("#docs").html("Refreshing documentation...");
    var date = localStorage["lastdate"]?localStorage["lastdate"]:'';
    console.log("Will get items after "+date);
    
    $.get(updateurl, {date:date}, function(resp,code) {
        console.log("back from getting updates with "+resp.length + " items to process.");
	
	resp.forEach(function(ob) {
    db.transaction(function(ctx) {
        ctx.executeSql("select id from docs where token = ?", [ob.token], function(tx,checkres) {
            if(checkres.rows.length) {
                console.log("possible update/delete");
                if(!ob.deleted) {
                    console.log("updating "+ob.title+ " "+ob.lastupdated);
                    tx.executeSql("update docs set title=?,body=?,lastupdated=? where token=?", [ob.title,ob.body,ob.lastupdated,ob.token]);
                } else {
                    console.log("deleting "+ob.title+ " "+ob.lastupdated);
                    tx.executeSql("delete from docs where token = ?", [ob.token]);
                }
            } else {
            //only insert if not deleted
            console.log("possible insert");
                if(!ob.deleted) {
                    console.log("inserting "+ob.title+ " "+ob.lastupdated);
                    tx.executeSql("insert into docs(title,body,lastupdated,token) values(?,?,?,?)", [ob.title,ob.body,ob.lastupdated,ob.token]);
                }
            }
        });
    });
});
});
});