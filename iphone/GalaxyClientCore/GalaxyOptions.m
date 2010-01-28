//
//  GalaxyOptions.m
//  GalaxyClientCore
//
//  Created by Adam Venturella on 1/25/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "GalaxyOptions.h"


@implementation GalaxyOptions
@synthesize applicationFormat, context, authorization;

-(id) init
{
	if(self = [super init])
	{
		self.applicationFormat  = @"application/json";
		self.authorization = [[GalaxyAuthorization alloc] init];
		
	}
	
	return self;
}

- (id)copyWithZone:(NSZone *)zone
{
	GalaxyOptions *copy    = [[self class] allocWithZone: zone];
	copy.applicationFormat = [[self.applicationFormat copy] autorelease];
	copy.context           = [[self.context copy] autorelease];
	copy.authorization     = [[self.authorization copy] autorelease];
	return copy;
}

- (void) dealloc
{
	self.context     = nil;
	self.applicationFormat = nil;
	self.authorization     = nil;
	
	[super dealloc];
}
@end
