//
//  GalaxyApplication.m
//  GalaxyClientCore
//
//  Created by Adam Venturella on 1/24/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "GalaxyApplication.h"
#import "GalaxyChannels.h"
#import "GalaxyOptions.h"
#import "GalaxyCommand.h"
#import "GalaxyAuthorization.h"
#import "GalaxyOperation.h"

@implementation GalaxyApplication
@synthesize defaultOptions, cacheDelegate;

- (id)init
{
	if (self = [super init])
	{
		
		networkOperations = [[NSOperationQueue alloc] init];
		[networkOperations setMaxConcurrentOperationCount:2];
		
		defaultOptions = [[GalaxyOptions alloc] init];
	}
	
	return self;
}

- (void)execute:(GalaxyCommand *)command options:(GalaxyOptions *)options
{	
	if(options == nil) options = (GalaxyOptions *) defaultOptions;

	GalaxyOperation * operation = [[GalaxyOperation alloc] initWithCommandAndOptions:command options:options];
	
	NSData * cachedResponse = nil;
	
	if(cacheDelegate)
	{
		cachedResponse = [cacheDelegate galaxyCachedResponseForOperation:operation];
	}
	
	if(cachedResponse)
	{
		[self performSelector:operation.command.callback withObject:cachedResponse];
	}
	else 
	{
		operation.delegate = self;
		[networkOperations addOperation:operation];
		[operation release];
	}
}

- (void)operationDidFinish:(GalaxyOperation *)operation
{
	
	if(cacheDelegate)
	{
		[cacheDelegate galaxySetCacheForOperation:operation];
	}
	
	if(operation.command.callback)
	{
		[self performSelector:operation.command.callback withObject:operation.result];
	}
}

- (void)channels:(SEL)callback
{
	GalaxyChannels * command = [[[GalaxyChannels alloc] init] autorelease];
	command.callback = callback;
	[self execute:command options:nil];
}

- (void)setApplicationId:(NSString *)value
{
	defaultOptions.context = value;
}

- (void)setApplicationKey:(NSString *)value
{
	defaultOptions.authorization.applicationKey = value;
}

- (void)setApplicationSecret:(NSString *)value
{
	defaultOptions.authorization.applicationSecret = value;
}

- (void)operationDidFailWithError:(NSError *)error
{
	NSLog(@"ERROR!");
}

- (void)dealloc
{
	[networkOperations release];
	[defaultOptions release];
	
	[super dealloc];
}
@end
