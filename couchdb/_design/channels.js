{
	"user":{
		"map": "function(doc) { if(doc.type == 'channel' && !doc.deleted) { emit([doc.user, doc.label], doc); }}"
	},
	
	"shortname":{
		"map":"function(doc){if(doc.type == 'channel'){emit(doc.short_label, 1)}}"
	},
	
	"channel" :{
		"map": "function(doc) { if(doc.type == 'channel' && !doc.deleted) { emit(doc.key, doc); }}"
	}
}
