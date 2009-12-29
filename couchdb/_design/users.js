{
	"authentication":{
		"map": "function(doc) { if(doc.type == 'user') { emit(doc.username, doc.password); }}"
	},
	
	"authenticateEmail":{
		"map": "function(doc) { if(doc.type == 'user') { emit(doc.username, doc); }}"
	},
	
	"authenticateScreenname":{
		"map": "function(doc) { if(doc.type == 'user') { emit(doc.screenname, doc); }}"
	},
	
	"accountAuthorization":{
		"map": "function(doc) { if(doc.type == 'authorization') { emit(doc._id, doc); }}"
	}
}
