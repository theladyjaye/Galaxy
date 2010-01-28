//
//  GalaxyCommand.m
//  iPhone_GalaxyClientCore
//
//  Created by Adam Venturella on 1/23/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "GalaxyCommand.h"
#import "GalaxyChannels.m"

NSString * const kGalaxyMethodGet    = @"GET";
NSString * const kGalaxyMethodPost   = @"POST";
NSString * const kGalaxyMethodPut    = @"PUT";
NSString * const kGalaxyMethodDelete = @"DELETE";

@implementation GalaxyCommand
@synthesize method, endpoint, content, contentType, callback;

- (id) init
{
	if(self = [super init])
	{
		[self prepareCommand];
	}
	
	return self;
}

- (void) prepareCommand { }


- (void) dealloc
{
	self.contentType = nil;
	self.content     = nil;
	self.endpoint    = nil;
	self.method      = nil;
	
	[super dealloc];
}
@end
