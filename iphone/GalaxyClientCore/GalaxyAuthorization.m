//
//  GalaxyAuthorization.m
//  GalaxyClientCore
//
//  Created by Adam Venturella on 1/25/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "GalaxyAuthorization.h"


@implementation GalaxyAuthorization
@synthesize authorizationType, applicationKey, applicationSecret;

-(id) init
{
	if(self = [super init])
	{	
		self.authorizationType = GalaxyAuthorizationOAuth;
	}
	
	return self;
}

- (id)copyWithZone:(NSZone *)zone
{
	GalaxyAuthorization *copy = [[self class] allocWithZone: zone];
	copy.applicationKey       = [[applicationKey copy] autorelease];
	copy.applicationSecret    = [[applicationSecret copy] autorelease];
	
	return copy;
}
- (void) dealloc
{
	//self.authorizationType = nil;
	self.applicationKey    = nil;
	self.applicationSecret = nil;
	[super dealloc];
}
@end
