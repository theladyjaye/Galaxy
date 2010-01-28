//
//  GalaxyChannels.h
//  iPhone_GalaxyClientCore
//
//  Created by Adam Venturella on 1/23/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import "GalaxyChannels.h"

@implementation GalaxyChannels
- (void) prepareCommand
{
	self.method   = kGalaxyMethodGet;
	self.endpoint = @"channels";
}
@end


