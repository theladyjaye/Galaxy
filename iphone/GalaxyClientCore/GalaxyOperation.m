//
//  GalaxyOperation.m
//  GalaxyClientCore
//
//  Created by Adam Venturella on 1/25/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "GalaxyOperation.h"
#import "GalaxyOptions.h"
#import "GalaxyCommand.h"
#import "GalaxyAuthorization.h"
#import "GalaxySignatureOAuth.h"
#import "GalaxyAuthorizationSignature.h"


#define kGalaxyHost      @"api.galaxyfoundry.com"
#define kGalaxyPort      80
#define kGalaxyTimeout   10
#define kGalaxyUserAgent @"GalaxyClientCore/1.0 (OBJC)"
#define kGalaxyScheme    @"glxy://"

@implementation GalaxyOperation
@synthesize delegate, result, command, options;

- (GalaxyOperation *)initWithCommandAndOptions:(GalaxyCommand *)consumer_command options:(GalaxyOptions *)consumer_options
{
	if(self = [super init])
	{
		self.command = consumer_command;
		self.options = consumer_options;
	}
	
	return self;
}

- (void)main 
{
	NSString * target = [NSString stringWithFormat:@"http://%@:%i/%@", kGalaxyHost, kGalaxyPort, command.endpoint];
	NSURL * url = [NSURL URLWithString:target];
	NSMutableDictionary * headers = [[NSMutableDictionary alloc] init];
	NSMutableURLRequest * request = [NSMutableURLRequest requestWithURL:url
															cachePolicy:NSURLRequestUseProtocolCachePolicy 
														timeoutInterval:kGalaxyTimeout];
	
	
	
	[request setHTTPMethod:command.method];
	
	if(options.authorization.authorizationType == GalaxyAuthorizationOAuth)
	{
		GalaxySignatureOAuth * signature = [GalaxySignatureOAuth signatureWithKey:options.authorization.applicationKey 
																		   secret:options.authorization.applicationSecret];
		
		signature.method      = command.method;
		signature.realm       = [NSString stringWithFormat:@"%@%@", kGalaxyScheme, options.context];
		signature.absoluteUrl = [NSString stringWithFormat:@"http://%@/%@", kGalaxyHost, command.endpoint];;
		
		if(command.method == kGalaxyMethodGet || command.method == kGalaxyMethodPost)
		{
			//[(GalaxySignatureOAuth *)authorization setAdditionalParameters:command.content];
		}
		
		[headers setValue:[signature authorizationSignature] forKey:@"Authorization"];
	}
	
	[headers setValue:kGalaxyUserAgent forKey:@"User-Agent"];
	[headers setValue:options.applicationFormat forKey:@"Accept"];
	
	[request setAllHTTPHeaderFields:headers];
	[headers release];
	
	NSError * error;
	NSURLResponse * response;
	result = [NSURLConnection  sendSynchronousRequest:request returningResponse:&response error:&error];
	[result retain];
	
	if(error)
	{
		[self.delegate performSelectorOnMainThread:@selector(operationDidFailWithError:)
										withObject:error
									 waitUntilDone:YES];
	}
	else 
	{
		[self.delegate performSelectorOnMainThread:@selector(operationDidFinish:)
										withObject:self
									 waitUntilDone:YES];
	}
}

- (void)dealloc
{
	self.command = nil;
	self.options = nil;
	[result release];
	
	[super dealloc];
}
@end
